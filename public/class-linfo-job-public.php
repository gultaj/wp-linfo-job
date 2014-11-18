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

	static $post_per_page = 10;

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

    public function custom_posts_per_page($query) {
        if ( $query->query_vars['post_type'] == $this->plugin->job->vacancy) {
                $query->query_vars['posts_per_page'] = self::$post_per_page;
        }
        return $query;
    }

    public static function get_vacancies() {
    	global $wpdb;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    	$offset = ($paged - 1) * self::$post_per_page;

        $sql = "SELECT post.post_date, post.ID, post.post_title, post.post_name,
					MAX(IF(meta.meta_key = 'company', meta.meta_value, NULL)) AS company,
					MAX(IF(meta.meta_key = 'salary', meta.meta_value, NULL)) AS salary
				FROM wp_posts post INNER JOIN wp_postmeta meta ON post.ID = meta.post_id
				WHERE post.post_type = 'job_vacancy'
					AND post.post_status = 'publish'
					AND meta.meta_key = 'company'
					OR meta.meta_key = 'salary'
				GROUP BY post.ID
				ORDER BY post.post_title
				LIMIT ". $offset .", ". self::$post_per_page;
        $posts = $wpdb->get_results( $sql );

        return $posts;
    }

    public static function get_vacancy_data( $id ) {
    	global $wpdb;
    	$sql = "SELECT meta_key, meta_value
				FROM wp_postmeta meta
				WHERE meta.post_id = {$id}
				AND meta.meta_key NOT IN ('_edit_lock', '_edit_last')";
        $data = $wpdb->get_results( $sql );
        $meta = [];
        foreach ($data as $v) {
        	$meta[$v->meta_key] = ($v->meta_key == 'contact') ? unserialize($v->meta_value) : $v->meta_value;
        }
        return $meta;
    }

    public static function get_archive_link( $post_type ) {
    	$obj = get_post_type_object( self::$$post_type );
    	$link = '<a href="'. home_url('/'.$obj->rewrite['slug'] ).'" class="resume__list_link">';
    	$link .= 'Посмотреть '.mb_strtolower($obj->labels->name, 'utf-8').'</a>';
    	return $link;
    }

    public static function title( $obj ) { ?>
    	<div class="col-xs-12">
    		<h2>
			<?php if ( is_single() ) : ?>
    			 <a class="job__all_link" href="<?= home_url('/'.$obj->rewrite['slug']) ?>"><?= $obj->labels->name ?> города Лиды &raquo;</a>
    		<?php else : ?>
    			<?= $obj->labels->name ?> города Лиды
    		<?php endif; ?>
    		</h2>
    		<a class="icon-plus vacancy__add_link" href="<?= home_url('/'.$obj->rewrite['slug'].'?new' ); ?>"><?= $obj->labels->add_new ?></a>
    	</div>
    <?php }

    public static function breadcrumbs( $obj) { ?>
        <ol class="breadcrumb">
        	<li><a href="<?= home_url() ?>">Главная</a></li>
        	<?php if ( is_single() ) : ?>
        		<li><a href="<?= home_url('/'.$obj->rewrite['slug'] ) ?>"><?= $obj->labels->name ?></a></li>
        		<li class="active"><?php the_title()?></li>
        	<?php else : ?>
        		<li class="active"><?= $obj->labels->name ?></li>
        	<?php endif; ?>
    	</ol>
    <?php
    }

}
