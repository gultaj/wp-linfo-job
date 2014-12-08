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
        return $input;
    }

	public function add_admin_menu() {
		$page = add_submenu_page( 
			'edit.php?post_type='.$this->plugin->job->vacancy,
			'Настройки', 
			'Настройки', 
			'manage_options', 
			'settings_job', 
			[&$this, 'job_options_page']
		);

		add_action( 'admin_print_scripts-' . $page, [$this, 'add_settings_scripts'] );
	}

	public function add_settings_scripts() {
		wp_enqueue_script( 'job-settings-script', plugin_dir_url( __DIR__ ).'admin/js/job-settings-script.js', ['jquery'], '', true );
	}

	public function after_settings() { ?>
		<table class="form-table"><tbody>
			<tr>
				<th scope="row">Файл</th>
				<td>
					<input type="file" name="job_parse" id="job_parse_file" placeholder="" class="regular-text ">
					<button type="button" class="button-secondary" id="load_parse_file">Загрузить</button>
				</td>
			</tr>
		</tbody></table>
	<?php }

	public function job_options_page() { ?>
		<div class="wrap">
            <h2>Настройки Работы</h2>
			<?php $this->wpsf->settings(); ?>
        </div>
	<?php }

}

 ?>