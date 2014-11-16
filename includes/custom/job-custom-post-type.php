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
                'add_new'      => 'Добавить',
                'edit_item'    => 'Редактировать',
                'update_item'  => 'Обновить',
            ],
            'rewrite'            => ['slug' => $this->slug, 'with_front' => false],
            'supports'           => ['title'],
            'show_in_menu'       => 'edit.php?post_type=' . $this->vacancy,
            'show_in_nav_menus'  => true,
            'public'             => true,
            'has_archive'        => true
        ];

        register_post_type( $this->vacancy, $args );

        $args['labels']['name'] = 'Резюме';
        $args['labels']['add_new_item'] = 'Новое резюме';
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