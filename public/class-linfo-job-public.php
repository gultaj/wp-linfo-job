<?php

class Wp_Linfo_Job_Public {

	private $plugin;

	static $post_per_page = 10;

	public static $vacancy = 'job_vacancy';
	public static $resume = 'job_resume';
    public static $slug;

	public function __construct( $plugin ) {
		$this->plugin = $plugin;
        self::$post_per_page = wpsf_get_setting('linfo_job', 'job_settings', 'posts_per_page');
        self::$vacancy = $plugin->job->vacancy;
        self::$resume  = $plugin->job->resume;
		self::$slug  = $plugin->job->slug;
	}

	public function enqueue_styles() {
        $post_type = get_query_var( 'post_type' );
        if ( $post_type == $this->plugin->job->vacancy || $post_type == $this->plugin->job->resume)
		  wp_enqueue_style( $this->plugin->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'css/linfo-job.css', [], $this->plugin->get_version(), 'all' );

	}

	public function enqueue_scripts() {
        $post_type = get_query_var( 'post_type' );
        wp_register_script( 'job-ya-share', '//yastatic.net/share/share.js', [], '', true );
        if ( $post_type == $this->plugin->job->vacancy || $post_type == $this->plugin->job->resume) {
    		wp_enqueue_script( $this->plugin->get_plugin_name(), plugin_dir_url( __FILE__ ) . 'js/linfo-job-public.min.js', [ 'lidainfo-bootstrap' ], $this->plugin->get_version(), true );
            if (is_single()) {
                wp_localize_script( $this->plugin->get_plugin_name(), 'ajax_object', ['ajax_url' => admin_url( 'admin-ajax.php' ) ] );
                wp_enqueue_script( 'job-ya-share' );
            }
        }
	}

	public function template_include( $template ) {
		$post_type = get_query_var('post_type');
		$job = $this->plugin->job;
    	if ( $post_type == $job->vacancy || $post_type == $job->resume ) {
            if ( isset($_POST['vacancy']) && isset($_POST['create-vacancy-nonce']) ) {
                if ( wp_verify_nonce( $_POST['create-vacancy-nonce'], 'create-vacancy' ) ) {
                    if ($id = $this->plugin->job->create( 'vacancy', $_POST['vacancy'] )) {
                        wp_safe_redirect( get_permalink( $id ) );
                    }
                }
            }
            if ( isset($_POST['resume']) && isset($_POST['create-resume-nonce']) ) {
                if ( wp_verify_nonce( $_POST['create-resume-nonce'], 'create-resume' ) ) {
                    if ($id = $this->plugin->job->create( 'resume', $_POST['resume'] )) {
                        wp_safe_redirect( get_permalink( $id ) );
                    }
                }
            }
            if (isset($_GET['new'])) {
                return plugin_dir_path( __FILE__ ) . "partials/new-job.php";
            }
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
        if ( (is_post_type_archive( $this->plugin->job->vacancy)  || is_post_type_archive( $this->plugin->job->resume))
            && !is_admin() ) {
            $query->set('posts_per_page', self::$post_per_page);
        }
    }

    public static function get_vacancies() {
    	global $wpdb, $wp_query;
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $post_per_page = self::$post_per_page;
    	$offset = ($paged - 1) * $post_per_page;
        $sql = "SELECT post.post_date, post.ID, post.post_title, post.post_name,
                        MAX(IF(meta.meta_key = 'company', meta.meta_value, NULL)) AS company,
                        MAX(IF(meta.meta_key = 'salary', meta.meta_value, NULL)) AS salary
                FROM wp_posts post 
                INNER JOIN wp_postmeta AS meta ON post.ID = meta.post_id
                WHERE post.post_type = '".self::$vacancy."'
                    AND post.post_status = 'publish'
                    AND (meta.meta_key = 'company' OR meta.meta_key = 'salary')
                GROUP BY post.ID
                ORDER BY post.post_date DESC, post_title
				LIMIT ". $offset .", ". $post_per_page;
        
        $posts = $wpdb->get_results( $sql );

        return $posts;
    }

    public static function get_resumes() {
        global $wpdb, $wp_query;
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $post_per_page = self::$post_per_page;
        $offset = ($paged - 1) * $post_per_page;
        $sql = "SELECT post.post_date, post.ID, post.post_title, post.post_name,
                        MAX(IF(meta.meta_key = 'company', meta.meta_value, NULL)) AS company,
                        MAX(IF(meta.meta_key = 'salary', meta.meta_value, NULL)) AS salary
                FROM wp_posts post 
                INNER JOIN wp_postmeta AS meta ON post.ID = meta.post_id
                WHERE post.post_type = '".self::$resume."'
                    AND post.post_status = 'publish'
                    AND (meta.meta_key = 'company' OR meta.meta_key = 'salary')
                GROUP BY post.ID
                ORDER BY post.post_title
                LIMIT ". $offset .", ". $post_per_page;
        
        $posts = $wpdb->get_results( $sql );

        return $posts;
    }

    public static function get_vacancy_data( $id ) {
    	global $wpdb;
    	$sql = "SELECT meta_key, meta_value
				FROM wp_postmeta meta
				WHERE meta.post_id = {$id}
				AND meta.meta_key NOT IN ('_edit_lock','_edit_last','_wp_old_slug')";
        $data = $wpdb->get_results( $sql );
        $meta = [];
        foreach ($data as $v) {
        	$meta[$v->meta_key] = ($v->meta_key == 'contact') ? unserialize($v->meta_value) : $v->meta_value;
        }
        return $meta;
    }

    public static function get_archive_link( $post_type ) {
        // global $wpdb;
    	$obj = get_post_type_object( self::$$post_type );
        return home_url('/'.$obj->rewrite['slug'] );
    	/*$link = '<a href="'. home_url('/'.$obj->rewrite['slug'] ).'" class="resume__list_link">';
    	$link .= 'Посмотреть '.mb_strtolower($obj->label, 'utf-8').'</a>';
    	return $link;*/
    }

    public static function get_key( $obj_id ) {
        global $wpdb;
        $sql = "SELECT meta_value
                FROM wp_postmeta
                WHERE post_id = '{$obj_id}'
                AND meta_key = 'key'";
        $key = $wpdb->get_row( $sql );
        return ($key) ? $key->meta_value : 0;
    }

    public static function title( $obj ) { ?>
    	<div class="col-xs-12">
    		<h2>
			<?php if ( is_single() ) : ?>
    			 <a class="job__all_link" href="<?= home_url('/'.$obj->rewrite['slug']) ?>"><?= $obj->label ?> города Лиды &raquo;</a>
    		<?php else : ?>
    			<?= $obj->label ?> города Лиды
    		<?php endif; ?>
    		</h2>
            <?php $vars = ($obj->query_var == self::$resume)?'&resume':'' ?>
    		<a class="icon-plus job__add_link" href="<?= home_url('/'.self::$slug.'?new'.$vars ); ?>">Добавить</a>
    	</div>
    <?php }

    public static function post_date( $date ) {
    	return DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
    }

    public static function breadcrumbs( $obj ) { ?>
        <ol class="breadcrumb">
        	<li><a href="<?= home_url() ?>">Главная</a></li>
        	<?php if ( is_single() ) : ?>
        		<li><a href="<?= home_url('/'.$obj->rewrite['slug'] ) ?>"><?= $obj->label ?></a></li>
        		<li class="active"><?= trim_characters(get_the_title(), 100)?></li>
        	<?php else : ?>
                <?php if (isset($_GET['new'])) : ?>
                    <li><a href="<?= home_url('/'.$obj->rewrite['slug'] ) ?>"><?= $obj->label ?></a></li>
                    <li class="active">Добавить</li>
                <?php else : ?>
            		<li class="active"><?= $obj->label ?></li>
                <?php endif; ?>
        	<?php endif; ?>
    	</ol>
    <?php
    }

    public static function flashmessages() {
        if (Wp_Job_Flash::hasFlash()) {
            foreach (Wp_Job_Flash::getFlashes() as $type => $message) { ?>
                <div class="alert alert-<?= $type ?>" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
                    <?= $message ?>
                </div>
            <?php }
        }
    }

}
