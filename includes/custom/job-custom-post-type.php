<?php 


class Job_Custom_Post_Type {

	public $post_type = "job";


	public function register() {
		$args = [
            'labels' => [
                'name'               => 'Работа',
                'view_item'          => 'Просмотреть',
                'add_new_item'       => 'Новое',
                'add_new'            => 'Добавить',
                'edit_item'          => 'Редактировать',
                'update_item'        => 'Обновить',
            ],
            // 'rewrite'            => ['slug' => self::SLUG.'/%taxonomy_name%', 'with_front' => false],
            'supports'           => ['title', 'thumbnail', 'editor'],
            'public'             => true,
            'show_in_menu'  	 => 'edit.php?post_type=afisha',
            'menu_icon'          => 'dashicons-carrot',
            'has_archive'        => true
        ];

        register_post_type($this->post_type, $args);
	}
}