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
			do_action('remove_job', $obj_id );
			echo 'OK';
		} else {
			echo 'false';
		}
		die();
	}

	public function job_parse_file() {
		$file = $_FILES['job_parse'];
		$uploads_dir = wp_upload_dir();
		$temp_file = $uploads_dir['basedir'] . '/' . time() . basename($file['name']);
		if (move_uploaded_file($_FILES['job_parse']['tmp_name'], $temp_file)) {
			require_once 'parser/ParseExcelJob.php';
			$reader = new ParseExcelJob( $temp_file );
			$data = $reader->readData()->parse()->getResultData();
			do_action( 'create_from_file', $data);
		} else {
			echo "Error: can't load file";
		}
		die();
	}

}
 
?>