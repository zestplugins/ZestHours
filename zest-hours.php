<?php

/**
 * @link              https://github.com/zestplugins/ZestHours
 * @since             1.0.0
 * @package           Business hours management
 *
 * @wordpress-plugin
 * Plugin Name:       ZestHours
 * Plugin URI:        https://github.com/zestplugins/ZestHours
 * Description:       Effortlessly display and manage business hours on your website.
 * Version:           0.1.0
 * Author:            zestplugins
 * Author URI:        https://github.com/zestplugins/ZestHours
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       zesthours
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Current plugin version.
 */
define( 'ZESTHOURS_VERSION', '0.1.0' );

require plugin_dir_path( __FILE__ ) . 'includes/includes.php';