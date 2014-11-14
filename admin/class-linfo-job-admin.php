<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_Linfo_Job
 * @subpackage Wp_Linfo_Job/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Wp_Linfo_Job
 * @subpackage Wp_Linfo_Job/admin
 * @author     Your Name <email@example.com>
 */
class Wp_Linfo_Job_Admin {

	private $plugin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;
		// $this->version = $version;
		// $this->job_post = $job_post;
	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'css/linfo-job-admin.css', [], $this->plugin->get_version(), 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'js/linfo-job-admin.js', ['jquery'], $this->plugin->get_version(), false );

	}

	public function create_menu_pages() {
		add_menu_page( 'Работа', 'Работа', 'edit_posts', 'edit.php?post_type=' . $this->plugin->job->vacancy, '', 'dashicons-carrot', 25 );
	}

}
