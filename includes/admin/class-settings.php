<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'ZestHours_Menu_Settings_Page' ) ) {
	/**
	 * ZestHours Menu Settings Page Class
	 *
	 * This class handles the creation of the "Settings" submenu page for the ZestHours plugin.
	 *
	 * @package ZestHours
	 */
	class ZestHours_Menu_Settings_Page {

		/**
		 * ZestHours_Menu_Settings_Page constructor.
		 *
		 * Adds an action hook to create the "Settings" submenu page.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		}

		/**
		 * Add the "Settings" submenu page.
		 */
		public function add_menu_page() {
			add_submenu_page(
				'zesthours_menu',
				__('Settings', 'zesthours'),
				__('Settings', 'zesthours'),
				'manage_options',
				'zesthours_menu_settings',
				array( $this, 'menu_settings_page' )
			);
            remove_submenu_page( 'zesthours_menu', 'zesthours_menu' );
		}

		/**
		 * Callback function to display the content of the "Settings" submenu page.
		 */
		public function menu_settings_page() {
			?>
			<h2><?php esc_html_e( 'Settings Page', 'zesthours' ); ?></h2>
			<?php
		}
	}
}

new ZestHours_Menu_Settings_Page();
