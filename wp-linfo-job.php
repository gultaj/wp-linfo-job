<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Wp_Linfo_Job
 *
 * @wordpress-plugin
 * Plugin Name:       Работа
 * Plugin URI:        http://example.com/linfo-job-uri/
 * Description:       Поиск и размещение вакансий и резюме
 * Version:           1.0.0
 * Author:            gultaj
 * Author URI:        https://github.com/gultaj
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       linfo-job
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation and deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-linfo-job-install.php';

/** This action is documented in includes/class-linfo-job-activator.php */
register_activation_hook( __FILE__, array( 'Wp_Linfo_Job_Install', 'activate' ) );

/** This action is documented in includes/class-linfo-job-deactivator.php */
register_deactivation_hook( __FILE__, array( 'Wp_Linfo_Job_Install', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-linfo-job.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_linfo_job() {

	$plugin = new Wp_Linfo_Job();
	$plugin->run();

}
run_linfo_job();
