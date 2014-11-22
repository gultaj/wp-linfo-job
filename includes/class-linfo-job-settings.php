<?php 

class Wp_Linfo_Job_Settings {

	private $plugin;

	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		return $this;
	}

	public function add_admin_menu() {
		add_submenu_page( 
			'edit.php?post_type='.$this->plugin->job->vacancy,
			'Настройки', 
			'Настройки', 
			'manage_options', 
			'vacancy_settings', 
			[$this, 'vacancy_options_page']
		);
	}

	public function vacancy_options_page() {

	}

	public function register_settings() {
		register_setting( 'linfo_job', 'vacancy_settings' );

		add_settings_section(
	        'vacancy_settings',         // ID used to identify this section and with which to register options
	        'Настройки вакансий',                  // Title to be displayed on the administration page
	        [$this, 'vacancy_settings_section'], // Callback used to render the description of the section
	        'linfo_job'                           // Page on which to add this section of options
	    );		
	}

	public function vacancy_settings_section() {
		echo '<p>Select which areas of content you wish to display.</p>';
	}
}

 ?>