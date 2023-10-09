<?php
/**
 * Plugin Name: ZestHours
 * Description: Effortlessly display and manage business hours on your website.
 * Version: 0.1.0
 * Author: zestplugins
 * Author URI: https://github.com/zestplugins/ZestHours
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: zesthours
 * Domain Path: /languages
 * 
 * @link              https://github.com/zestplugins/ZestHours
 * @since             0.1.0
 * @package           ZestHours
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Define the current plugin version.
 */
define( 'ZESTHOURS_VERSION', '0.1.0' );

/**
 * Include necessary plugin files.
 */
require plugin_dir_path( __FILE__ ) . 'includes/includes.php';

/**
 * Add custom action link to the plugin's action links.
 *
 * @param array $links Existing plugin action links.
 * @return array Modified plugin action links.
 */
function zesthours_management_add_actions_link( $links ) {
    $settings_link = '<a href="' . admin_url( 'admin.php?page=zesthours_menu_settings' ) . '">' . esc_html__( 'Settings', 'zesthours' ) . '</a>';
    $help_link     = '<a href="' . admin_url( 'admin.php?page=zesthours_menu_help' ) . '">' . esc_html__( 'Help', 'zesthours' ) . '</a>';
    array_push( $links, $settings_link, $help_link );
    return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'zesthours_management_add_actions_link' );
