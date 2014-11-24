<?php 

class Wp_Linfo_Job_Ajax {

	protected $plugin;

	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	public function check_user_key() {
		$user_key = sanitize_text_field( $_POST['user_key'] );
		$obj_id = intval( $_POST['vacancy_id']);
		$key = Wp_Linfo_Job_Public::get_key( $vacancy_id );
	}

}
 
?>