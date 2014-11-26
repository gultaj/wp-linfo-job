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

    public function create_vacancy() {
        $vacancy = $_POST['vacancy'];
        if (strlen(trim($vacancy['title'])) == 0) return false;
        $args = [
            'post_type' => $this->vacancy,
            'post_title' => wp_strip_all_tags($vacancy['title']),
            'post_status' => 'publish'
        ];
        $vacancy_id = wp_insert_post( $args );
        wp_update_post( ['ID'=>$vacancy_id, 'post_name'=>'id'.$vacancy_id] );
        unset($vacancy['title']);

        do_action( 'save_'.$this->vacancy, $vacancy_id, $vacancy );

        $key = Wp_Linfo_Job_Public::get_key( $vacancy_id );
        $message = wpsf_get_setting('linfo_job', 'vacancy_settings', 'email');
        $message = preg_replace('/%key%/ui', $key, nl2br($message));
        Wp_Job_Flash::setFlash('success', $message);
        return $vacancy_id;
    }

    public function remove_vacancy( $id ) {
        if (wp_delete_post( $id, true )) {
            Wp_Job_Flash::setFlash('success', '<strong>Ваша вакансия удалена!</strong>');
        }
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