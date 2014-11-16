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

	public function menu_meta_box_filter($items, $menu, $args) {
        // foreach ($items as &$item) {
        //     if ($item->object != $this->plugin->job->vacancy) continue;
        //     $item->url = home_url( '/' . $this->plugin->job->slug );
        //     if ( get_query_var( 'post_type' ) == $item->type ) {
        //         $item->classes[] = 'current-menu-item';
        //         $item->current = true;
        //     }
        // }
        // return $items;
        /* alter the URL for cpt-archive objects */
  foreach ( $items as &$item ) {
    if ( $item->object != 'cpt-archive' ) continue;
    
    /* we stored the post type in the type property of the menu item */
    $item->url = get_post_type_archive_link( $item->type );

    if ( get_query_var( 'post_type' ) == $item->type ) {
      $item->classes []= 'current-menu-item';
      $item->current = true;
    }
  }

  return $items;
    }

    public function add_menu_meta_box( ) {
        //add_meta_box( 'add-'.$this->plugin->get_plugin_name(), 'Работа', [$this, 'menu_meta_box'], 'nav-menus', 'side', 'default');
        add_meta_box( 'add-cpt', __( 'CPT Archives' ), [$this,'menu_meta_box'], 'nav-menus', 'side', 'default' );
        //return $obj;
    }

    public function menu_meta_box() {
        global $nav_menu_selected_id;
        $vacancy = $this->plugin->job->vacancy;
        // if (post_type_exists($vacancy)) {
        //     $ob_post_type            = get_post_type_object($vacancy);
        //     $ob_post_type->classes   = [];
        //    	$ob_post_type->type      = 'post_type';
        //     $ob_post_type->object_id = $ob_post_type->name;
        //     $ob_post_type->title     = 'Работа';
        //     $ob_post_type->object    = $vacancy;

        //     $ob_post_type->menu_item_parent = null;
        //     $ob_post_type->url              = null;//home_url( '/' . $this->plugin->job->slug );
        //     $ob_post_type->xfn              = null;
        //     $ob_post_type->db_id            = null;
        //     $ob_post_type->target           = null;
        //     $ob_post_type->attr_title       = null;

        //     $walker          = new Walker_Nav_Menu_Checklist([]);
            
        //     require_once plugin_dir_path( __FILE__ ) . 'partials/linfo-job-menu-meta-box.php';
        $post_types = get_post_types( array( 'show_in_nav_menus' => true, 'has_archive' => true ), 'object' );
        $t = get_post_type_object($vacancy);
          /* hydrate the necessary properties for identification in the walker */
          foreach ( $post_types as &$post_type ) {
            $post_type->classes = array();
            $post_type->type = $post_type->name;
            $post_type->object_id = $post_type->name;
            $post_type->title = $post_type->labels->name;
            $post_type->object = 'cpt-archive';
            
            $post_type->menu_item_parent = 0;
            $post_type->url = 0;
            $post_type->xfn = 0;
            $post_type->db_id = 0;
            $post_type->target = 0;
            $post_type->attr_title = 0;
          }

          /* the native menu checklist */
          $walker = new Walker_Nav_Menu_Checklist( array() );
        ?>
        <pre><?php print_r($t) ?></pre>
  <div id="cpt-archive" class="posttypediv">
    <div id="tabs-panel-cpt-archive" class="tabs-panel tabs-panel-active">
    <ul id="ctp-archive-checklist" class="categorychecklist form-no-clear">
    <?php
      echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $post_types), 0, (object) array( 'walker' => $walker) );
    ?>
    </ul>
    </div><!-- /.tabs-panel -->
    </div>
    <p class="button-controls">
      <span class="add-to-menu">
	    <img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
        <input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-ctp-archive-menu-item" id="submit-cpt-archive" />
      </span>
    </p>
  <?php
    }

}
