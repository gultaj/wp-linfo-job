<?php 

class Wp_Linfo_Job_Ajax {

	protected $plugin;

	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	public function check_user_key() {
		$user_key = sanitize_text_field( $_POST['user_key'] );
		$obj_id = intval( $_POST['obj_id']);
		$key = Wp_Linfo_Job_Public::get_key( $obj_id );
		echo ($key === $user_key) ? 'OK' : 'false';
		die();
	}

	public function remove_job() {
		$user_key = sanitize_text_field( $_POST['user_key'] );
		$obj_id = intval( $_POST['obj_id']);
		$key = Wp_Linfo_Job_Public::get_key( $obj_id );
		if ($user_key === $key) {
			do_action('remove_job_vacancy', $obj_id );
			echo 'OK';
		} else {
			echo 'false';
		}
		die();
	}

}
 
?>