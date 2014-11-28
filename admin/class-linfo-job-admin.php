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

		// wp_enqueue_style( $this->plugin->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'css/linfo-job-admin.css', [], $this->plugin->get_version(), 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// wp_enqueue_script( $this->plugin->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'js/linfo-job-admin.js', ['jquery'], $this->plugin->get_version(), false );

	}

	public function create_menu_pages() {
		add_menu_page( 'Работа', 'Работа', 'edit_posts', 'edit.php?post_type=' . $this->plugin->job->vacancy, '', 'dashicons-carrot', 29 );
	}

    public function add_menu_meta_box( ) {
        add_meta_box( 'add-'.$this->plugin->get_plugin_name(), 'Работа', [$this, 'menu_meta_box'], 'nav-menus', 'side', 'default');
    }

    public function menu_meta_box() {
        global $nav_menu_selected_id;
        $vacancy = $this->plugin->job->vacancy;
        if (post_type_exists($vacancy)) {
            $ob_post_type            = get_post_type_object($vacancy);
            $ob_post_type->classes   = [];
           	$ob_post_type->type      = 'custom';
            $ob_post_type->object_id = $ob_post_type->name;
            $ob_post_type->title     = 'Работа';
            $ob_post_type->object    = $vacancy;

            $ob_post_type->url              = '/' . $this->plugin->job->slug;
            $ob_post_type->menu_item_parent = null;
            $ob_post_type->xfn              = null;
            $ob_post_type->db_id            = null;
            $ob_post_type->target           = null;
            $ob_post_type->attr_title       = null;

            $walker = new Walker_Nav_Menu_Checklist([]);
            
            require_once plugin_dir_path( __FILE__ ) . 'partials/linfo-job-menu-meta-box.php';
        }
    }

    public function clear_expired_objects() {
    	global $wpdb;
    	$time = time();
    	$sql = "SELECT post.ID
                FROM wp_posts post 
                INNER JOIN wp_postmeta AS meta ON post.ID = meta.post_id
                WHERE (post.post_type = '{$this->plugin->job->vacancy}') AND post.post_status = 'publish'
                    AND (mt1.meta_key = 'expiry' AND CAST(mt1.meta_value AS CHAR) < {$time})";
        $ids = $wpdb->get_results( $sql );
        foreach ($ids as $id) {
        	wp_delete_post( $id, true );
        }
    }

    public function send_vacancy_email(  ) {
    	$headers = 'От: lida.info <myname@lida.info>';
    	$message = '';
    	//wp_mail( $email, 'Новая вакансия', $message, $headers );
    }

}
