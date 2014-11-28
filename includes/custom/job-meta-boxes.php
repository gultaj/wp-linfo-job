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
 		'2' => 'разовая работа',
	];
	static $stage = [
		'0' => 'не имеет значения',
		'1' => 'без опыта',
		'2' => 'до 1 года',
		'3' => 'от 1 года до 3 лет',
		'4' => 'более 3 лет',
	];
	static $expiry = [
        "+1 week"  => "Неделя",
        "+2 week"  => "Две недели",
        "+1 month" => "Месяц",
        "+3 month" => "Три месяца",
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
		global $current_screen;
		$meta = ['desc', 'salary', 'edu', 'shift', 'stage', 'time', 'contact', 'company', 'expiry'];
		foreach ($meta as $value) {
			$$value = get_post_meta( $obj->ID, $value, true );
		}
		if (!is_array($contact)) $contact = ['address'=>'', 'phone'=>'', 'email'=>'', 'site'=>'', 'name'=>''];
		$name = $this->plugin->job->vacancy;
		require_once plugin_dir_path( __FILE__ ) . 'meta_partials/vacancy-meta-boxes.php';
	}

	public function resume_metabox( $obj ) {
		global $current_screen;
		$meta = ['desc', 'salary', 'edu', 'stage', 'contact', 'expiry'];
		foreach ($meta as $value) {
			$$value = get_post_meta( $obj->ID, $value, true );
		}
		if (!is_array($contact)) $contact = ['phone'=>'', 'email'=>'', 'name'=>''];
		$name = $this->plugin->job->resume;
		require_once plugin_dir_path( __FILE__ ) . 'meta_partials/resume-meta-boxes.php';
	}

	public function save_vacancy_meta_box( $obj_id, $data ) {
		$sanitize = [
			'intval' => ['shift', 'edu', 'type', 'stage'],
			'htmlentities' => ['desc'],
			'sanitize_text_field' => [
				'company', 'salary', 'expiry',
				'contact' => ['address', 'email', 'phone', 'site', 'name',]
			],
			'sanitize_email' => ['contact' => ['email']],
		];
		$data = $this->sanitize_meta( $data, $sanitize );
		$data['expiry'] = strtotime($data['expiry'], time());
		$data['key'] = $this->generate_password();
		foreach ($data as $key => $value) {
			update_post_meta( $obj_id, $key, $value );
		}
		if ( is_email( $data['contact']['email'] ))
			do_action( 'send_vacancy_key', $data['contact']['email'], $data['key'] );
		return $data['key'];
	}

	public function save_resume_meta_box( $obj_id, $data ) {
		$sanitize = [
			'intval' => ['edu','stage'],
			'htmlentities' => ['desc'],
			'sanitize_text_field' => [
				'salary', 'expiry',
				'contact' => ['email', 'phone', 'name',]
			],
			'sanitize_email' => ['contact' => ['email']],
		];
		$data = $this->sanitize_meta( $data, $sanitize );
		$data['expiry'] = strtotime($data['expiry'], time());
		$data['key'] = $this->generate_password();
		foreach ($data as $key => $value) {
			update_post_meta( $obj_id, $key, $value );
		}
		if ( is_email( $data['contact']['email'] ))
			do_action( 'send_resume_key', $data['contact']['email'], $data['key'] );
		return $data['key'];
	}

	public function validate_vacancy( $data ) {
		//if ($data[''])
	}

	private function sanitize_meta( $data, $rules ) {
		foreach ($rules as $func => $fields) {
			foreach ($fields as $name => $field) {
				if (is_array($field)) {
					$data[$name] = $this->sanitize_meta($data[$name], [$func => $field]);
					continue;
				}
				$data[$field] = call_user_func_array($func, [$data[$field]]);
			}
		}
		return $data;
	}

	private function generate_password($length = 6) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }
        return $result;
    }

	/* Static helpers */

	public static function dropdown( $name, $selected = 0 ) {
		foreach (self::$$name as $key => $value) {
			echo '<option value="'.$key.'"'.(($key == $selected) ? ' selected="selected">' : '>').$value.'</option>';
		}
	}

	public static function get_elem( $name, $value ) {
		$arr = self::$$name;
		return $arr[$value];
	}
}