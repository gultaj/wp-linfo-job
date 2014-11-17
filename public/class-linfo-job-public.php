<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_Linfo_Job
 * @subpackage Wp_Linfo_Job/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Wp_Linfo_Job
 * @subpackage Wp_Linfo_Job/public
 * @author     Your Name <email@example.com>
 */
class Wp_Linfo_Job_Public {

	private $plugin;
	public static $vacancy = 'job_vacancy';
	public static $resume = 'job_resume';

	public function __construct( $plugin ) {

		$this->plugin = $plugin;
		// $this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'css/linfo-job.css', [], $this->plugin->get_version(), 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'js/linfo-job-public.js', [ 'jquery' ], $this->plugin->get_version(), false );

	}

	public function template_include( $template ) {
		$post_type = get_query_var('post_type');
		$job = $this->plugin->job;
    	if ( $post_type == $job->vacancy || $post_type == $job->resume ) {
    		if ( is_single() ) {
                return plugin_dir_path( __FILE__ ) . "partials/single-{$post_type}.php";
            }
            if ( is_archive() ) {
                return plugin_dir_path( __FILE__ ) . "partials/archive-{$post_type}.php";
            }
    	}
    	return $template;
    }

    public static function get_vacancies() {
    	global $wpdb;
    	$count_post = 10;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts =  get_posts([
            'orderby'  => 'date',
            'order' => 'DESC',
            'post_type' => self::$vacancy,
            'post_status' => 'publish',
            'posts_per_archive_page' => $count_post,
            'paged' => $paged,
        ]);

        $sql = "SELECT
			post.post_date,
			post.ID,
			post.post_title,
			post.post_name,
			MAX(IF(meta.meta_key = 'company', meta.meta_value, NULL)) AS company,
			MAX(IF(meta.meta_key = 'salary', meta.meta_value, NULL)) AS salary
		FROM wp_posts post
		INNER JOIN wp_postmeta meta
			 ON post.ID = meta.post_id
		WHERE
			post.post_type = 'job_vacancy'
			AND post.post_status = 'publish'
			AND meta.meta_key = 'company'
			OR meta.meta_key = 'salary'";

        $posts = $wpdb->get_results( $sql );
        
        return $posts;
    }

}
