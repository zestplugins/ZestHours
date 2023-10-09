<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'ZestHoursMenuHelpPage' ) ) {
	/**
	 * ZestHoursMenuHelpPage Class
	 *
	 * This class handles the creation of the "Help" submenu page for the ZestHours plugin.
	 *
	 * @package ZestHours
	 */
	class ZestHoursMenuHelpPage {

		/**
		 * ZestHoursMenuHelpPage constructor.
		 *
		 * Adds an action hook to create the "Help" submenu page.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		}

		/**
		 * Add the "Help" submenu page.
		 */
		public function add_menu_page() {
			add_submenu_page(
				'zesthours_menu',
				__('Help', 'zesthours'),
				__('Help', 'zesthours'),
				'manage_options',
				'zesthours_menu_help',
				array( $this, 'menu_help_page' )
			);
		}

		/**
		 * Callback function to display the content of the "Help" submenu page.
		 */
		public function menu_help_page() {
			?>
			<h2><?php esc_html_e( 'Help Page', 'zesthours' ); ?></h2>
			<?php
		}
	}
}

new ZestHoursMenuHelpPage();
