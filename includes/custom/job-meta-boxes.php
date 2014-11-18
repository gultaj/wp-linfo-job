<?php 

class Job_Meta_Boxes {

	protected $plugin;

	static $education = [
		'0' => 'не имеет значения',
		'1'  => 'общее среднее',
		'2'  => 'средне-специальное',
		'3'  => 'профессионально-техническое',
		'4'  => 'высшее',
	];
	static $shift = [
		'0' => 'полный рабочий день',
		'1' => 'гибкий график',
		'2' => 'сменный график',
		'3' => 'удаленная работа',
	];
	static $type = [
		'0' => 'полная занятость',
 		'1' => 'частичная занятость',
 		'2' => 'проектная работа',
	];
	static $stage = [
		'0' => 'не имеет значения',
		'1' => 'нет опыта',
		'2' => 'до 1 года',
		'3' => 'от 1 года до 3 лет',
		'4' => 'более 3 лет',
	];

	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	public function create() {
		add_meta_box($this->plugin->job->vacancy, 'Вакансия',
            [$this, 'vacancy_metabox'],
            $this->plugin->job->vacancy, 'normal', 'high');

        add_meta_box($this->plugin->job->resume, 'Резюме',
            [$this, 'resume_metabox'],
            $this->plugin->job->resume, 'normal', 'high');
	}

	public function vacancy_metabox( $obj ) {
		$meta = ['desc', 'salary', 'edu', 'shift', 'stage', 'time', 'contact', 'company'];
		foreach ($meta as $value) {
			$$value = get_post_meta( $obj->ID, $value, true );
		}
		if (!is_array($contact)) $contact = ['address'=>'', 'phone'=>'', 'email'=>'', 'site'=>''];
		$name = $this->plugin->job->vacancy;
		require_once plugin_dir_path( __FILE__ ) . 'meta_partials/vacancy-meta-boxes.php';

	}

	public function resume_metabox( $obj ) {

	}

	public function save_vacancy_meta_box( $obj_id, $data ) {

		foreach ($data as $key => $value) {
			update_post_meta( $obj_id, $key, $value );
		}

	}

	private function sanitize_vacancy_meta( $data ) {

	}

	public function save_resume_meta_box( $obj_id, $data ) {

	}


	/* Static helpers */

	public static function dropdown( $name, $selected = 0 ) {
		foreach (self::$$name as $key => $value) {
			echo '<option value="'.$key.'"'.(($key == $selected) ? ' selected="selected">' : '>').$value.'</option>';
		}
	}
}