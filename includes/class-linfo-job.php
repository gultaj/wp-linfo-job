<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_Linfo_Job
 * @subpackage Wp_Linfo_Job/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Linfo_Job
 * @subpackage Wp_Linfo_Job/includes
 * @author     Your Name <email@example.com>
 */
class Wp_Linfo_Job {

	protected $loader;
	protected $name;
	protected $version;

	public $job;
	public $public;
	public $settings;

	public function __construct() {

		$this->name = 'linfo-job';
		$this->version = '1.0.0';
		$this->path = plugin_dir_path( __DIR__ );

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->define_custom_post_hooks();
		$this->define_meta_boxes_hooks();
		$this->define_settings_hooks();
	}

	private function load_dependencies() {

		require_once $this->path . 'includes/class-linfo-job-loader.php';

		require_once $this->path . 'includes/class-linfo-job-i18n.php';

		require_once $this->path . 'includes/class-linfo-job-settings.php';

		require_once $this->path . 'admin/class-linfo-job-admin.php';

		require_once $this->path . 'public/class-linfo-job-public.php';

		require_once $this->path . 'public/class-flashmessage.php';

		require_once $this->path . 'includes/custom/job-custom-post-type.php';

		require_once $this->path . 'includes/custom/job-meta-boxes.php';

		require_once $this->path . 'includes/custom/wp-settings-framework.php';

		$this->loader = new Wp_Linfo_Job_Loader();

		$this->job = new Job_Custom_Post_Types( $this );

		$this->meta = new Job_Meta_Boxes( $this );

		//$this->settings = new WordPressSettingsFramework( $this->path .'custom/settings/example-settings.php', 'prefix_settings_general' );
		$this->settings = new Wp_Linfo_Job_Settings( $this );
	}

	private function set_locale() {

		$plugin_i18n = new Wp_Linfo_Job_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Wp_Linfo_Job_Admin( $this );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_menu_pages' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_head-nav-menus.php', $plugin_admin, 'add_menu_meta_box' );
		$this->loader->add_action( 'cron_linfo_job', $plugin_admin, 'clear_expired_objects' );
		$this->loader->add_action( 'send_vacancy_key', $plugin_admin, 'send_vacancy_email' );
	}

	private function define_public_hooks() {

		$this->public = new Wp_Linfo_Job_Public( $this );

		$this->loader->add_action( 'wp_enqueue_scripts', $this->public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->public, 'enqueue_scripts' );
		
		$this->loader->add_filter( 'template_include', $this->public, 'template_include', 6 );
		$this->loader->add_filter( 'pre_get_posts', $this->public, 'custom_posts_per_page' );

	}

	private function define_custom_post_hooks() {

		$this->loader->add_action( 'init', $this->job, 'register' );
		$this->loader->add_action( 'save_post_'.$this->job->vacancy, $this->job, 'save', 10, 2 );
		$this->loader->add_action( 'save_post_'.$this->job->resume, $this->job, 'save', 10, 2 );
		$this->loader->add_action( 'wp_insert_post_data', $this->job, 'before_save', 10, 2 );

	}

	public function define_meta_boxes_hooks() {

		$this->loader->add_action( 'add_meta_boxes', $this->meta, 'create' );
		$this->loader->add_action( 'save_'.$this->job->vacancy, $this->meta, 'save_vacancy_meta_box', 10, 2 );
		$this->loader->add_action( 'save_'.$this->job->resume, $this->meta, 'save_resume_meta_box', 10, 2 );

	}

	public function define_settings_hooks() {

		//$settings = new Wp_Linfo_Job_Settings( $this );

		$this->loader->add_action( 'admin_menu', $this->settings, 'add_admin_menu' );
		//$this->loader->add_action( 'admin_init', $this->settings, 'register_settings' );*/

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
