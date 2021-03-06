<?php 


class Job_Custom_Post_Types {

	public $vacancy = "job_vacancy";
	
	public $resume = "job_resume";

    public $slug = 'job';


	public function register() {
		$args = [
            'labels' => [
                'name'         => 'Вакансии',
                'view_item'    => 'Просмотреть',
                'add_new_item' => 'Новая вакансия',
                'add_new'      => 'Добавить вакансию',
                'edit_item'    => 'Редактировать',
                'update_item'  => 'Обновить',
            ],
            'rewrite'            => ['slug' => $this->slug, 'with_front' => false],
            'supports'           => ['title'],
            'show_in_menu'       => 'edit.php?post_type=' . $this->vacancy,
            'show_in_nav_menus'  => false,
            'public'             => true,
            'has_archive'        => true
        ];

        register_post_type( $this->vacancy, $args );

        $args['labels']['name'] = 'Резюме';
        $args['labels']['add_new_item'] = 'Новое резюме';
        $args['labels']['add_new'] = 'Добавить резюме';
        $args['rewrite'] = ['slug' => $this->slug.'/resume', 'with_front' => false];

        register_post_type( $this->resume, $args );
	}

    public function save( $obj_id, $obj) {
        if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $obj_id ) ) {
            return $obj_id;
        }
        if (isset($_POST[$this->vacancy]))
            do_action( 'save_'.$this->vacancy, $obj_id, $_POST[$this->vacancy] );
        if (isset($_POST[$this->resume]))
            do_action( 'save_'.$this->resume, $obj_id, $_POST[$this->resume] );
    }

    public function create( $post_type, $data ) {
        if (strlen(trim($data['title'])) == 0) return false;
        $args = [
            'post_type' => $this->$post_type,
            'post_title' => wp_strip_all_tags($data['title']),
            'post_status' => 'publish'
        ];
        $obj_id = wp_insert_post( $args );
        wp_update_post( ['ID'=>$obj_id, 'post_name'=>'id'.$obj_id] );
        unset($data['title']);

        do_action( 'save_'.$this->$post_type, $obj_id, $data );

        $key = Wp_Linfo_Job_Public::get_key( $obj_id );
        $message = wpsf_get_setting( 'linfo_job', 'job_settings', 'register_'.$post_type );
        $message = preg_replace('/%key%/ui', $key, nl2br($message));
        Wp_Job_Flash::setFlash('success', $message);
        return $obj_id;    
    }

    public function create_from_file( $posts ) {
        global $wpdb;
        $saved = $updated = $duplicates = 0;
        foreach ($posts as $post) {
            $date = $post['date']->format('Y-m-d H:i:s');
            $sql = "SELECT ID
                    FROM wp_posts AS post
                    RIGHT JOIN wp_postmeta AS meta ON meta.post_id = post.ID 
                    WHERE post.post_title = %s AND post.post_type = %s AND post.post_status = 'publish'
                    AND meta.meta_key = 'company' AND meta.meta_value = %s
                    ORDER BY post.post_date";
            $ids = $wpdb->get_results( 
                $wpdb->prepare( $sql, wp_strip_all_tags($post['vacancy']), $this->vacancy, $post['company'] ) 
            );

            if (count($ids) > 0) {
                wp_update_post( ['ID'=>$ids[0]->ID, 'post_date'=>$date] );
                if ($d = $this->clear_duplicates($ids)) {
                    $duplicates += $d;
                }
                do_action( 'create_from_file_'.$this->vacancy, $ids[0]->ID, $post );
                $updated++;
            } else {
                $args = [
                    'post_type' => $this->vacancy,
                    'post_title' => wp_strip_all_tags($post['vacancy']),
                    'post_status' => 'publish',
                    'post_date' => $date
                ];
                $obj_id = wp_insert_post( $args );
                $saved++;
                wp_update_post( ['ID'=>$obj_id, 'post_name'=>'id'.$obj_id] );
                unset($post['vacancy']);
                do_action( 'create_from_file_'.$this->vacancy, $obj_id, $post );
            } 
        }
        echo "Сохранено: {$saved}; Обновлено: {$updated}; Дубликаты: {$duplicates}; Проигнорировано: ".(count($posts) - $saved - $updated); 
    }

    protected function clear_duplicates($duplicates) {
        $count = count($duplicates);
        for ($i = 1; $i < $count; $i++) { 
            wp_delete_post( $duplicates[$i]->ID, true ); 
        }
        return ($count - 1) > 0 ? $count - 1 : false;
    }

    public function remove( $id ) {
        $post_type = get_post_type( $id );
        if ($post_type === $this->vacancy) {
            $message = '<strong>Ваша вакансия удалена!</strong>';
        } else {
            $message = '<strong>Ваше резюме удалено!</strong>';
        }
        if (wp_delete_post( $id, true )) {
            Wp_Job_Flash::setFlash('success', $message);
        }
    }

    public function clear_rewrite_rules( $rewrite ) {
        unset( $rewrite->rules[$this->slug.'/[^/]+/([^/]+)/?$'] ); 
    }

    /**
     * Заменяте поле 'name' на 'id{id объекта}'
     */
    public function before_save( $obj_data, $objarr ) {
        if ($obj_data['post_type'] == $this->vacancy || $obj_data['post_type'] == $this->resume) {
            $obj_data['post_name'] = 'id'.$objarr['ID'];
        }
        return $obj_data;
    }
}