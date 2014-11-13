<?php 

class Job_Category_Taxonomy {

	public $taxonomy = 'job_category';

	protected $post_type;

	public function __construct( $post_type ) {
		$this->post_type = $post_type;
	}

	public function register() {
		$args = [
            'query_var'    => true,
            'hierarchical' => true,
            'show_in_nav_menus'  => true,
            'rewrite'      => ['slug' => self::SLUG, 'hierarchical' => true, 'with_front' => false],
            'labels'       => [
                'name'               => 'Вид',
                'singular_name'      => 'Категория',
                'menu_name'          => 'Категории',
                'all_items'          => 'Все категории',
                'view_item'          => 'Просмотреть',
                'add_new_item'       => 'Новая категория',
                'add_new'            => 'Добавить категорию',
                'edit_item'          => 'Редактировать',
                'update_item'        => 'Обновить',
                'search_items'       => 'Найти категорию',
                'not_found'          => 'Категории не найдены',
                'not_found_in_trash' => 'Не найдены категории в корзине',
            ]
        ];
        register_taxonomy($this->taxonomy, [$this->post_type], $args);
	}
}