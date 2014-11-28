<?php 

class Wp_Linfo_Job_Settings {

	private $plugin;
	public $wpsf;

	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->wpsf = new WordPressSettingsFramework($this->plugin->path .'settings/job-settings.php', 'linfo_job');
		//add_filter( $this->wpsf->get_option_group() .'_settings_validate', [$this, 'validate_settings'] );
		return $this;
	}

	function validate_settings( $input ) {
        // Do your settings validation here
        // Same as $sanitize_callback from http://codex.wordpress.org/Function_Reference/register_setting
        return $input;
    }

	public function add_admin_menu() {
		add_submenu_page( 
			'edit.php?post_type='.$this->plugin->job->vacancy,
			'Настройки', 
			'Настройки', 
			'manage_options', 
			'linfo_job', 
			[&$this, 'job_options_page']
		);
	}

	public function job_options_page() { ?>
		<div class="wrap">
            <h2>Настройки Работы</h2>
			<?php $this->wpsf->settings(); ?>
        </div>
	<?php }

}

 ?>