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
			<section style="background-color: #fdfdfd; margin-right: 15px; margin-top: 15px; min-height: 100svh;">
				<div class="zesthours-help-main">
					<h1 style="color: whitesmoke;"><?php esc_html_e( 'ZestHours', 'zesthours' ); ?></h1>
				</div>            
					
				<div class="zesthours-help-tabs">
					<ul class="zesthours-help-tab-links">
						<li class="zesthours-help-tab-active"><a href="#zesthours-welcome-tab"><?php esc_html_e( 'Welcome', 'zesthours' ); ?></a></li>
						<li><a href="#zesthours-support-tab"><?php esc_html_e( 'Support', 'zesthours' ); ?></a></li>
					</ul>
			
					<div class="zesthours-help-tab-content">
						<div id="zesthours-welcome-tab" class="zesthours-help-tab zesthours-help-tab-active">
							<div>
								<h3><?php esc_html_e( 'Thank You For choosing ZestHours.', 'zesthours' ); ?></h3>
								<p><?php esc_html_e( 'Better, beautiful and flexible business hours management and display.', 'zesthours' ); ?></p>
							</div>
						</div>
			
						<div id="zesthours-support-tab" class="zesthours-help-tab">
							<h2><?php esc_html_e( 'Support', 'zesthours' ); ?></h2>
							<!-- Add support content here -->
						</div>
					</div>
				</div>
			</section>
			
			<style>
				/* Style for tabs */
				.zesthours-help-tabs {
					font-family: Arial, sans-serif;
					padding-left: 10px;
				}
		
				.zesthours-help-main {
					display: flex;
					flex-direction: column;
					justify-content: center;
					align-items: center;
					text-align: center;
					background-color: black;
					min-height: 100px;
				}
		
				.zesthours-help-tab-links {
					display: flex;
					list-style: none;
					padding: 0;
					margin: 0;
				}
		
				.zesthours-help-tab-links li {
					margin-right: 10px;
				}
		
				.zesthours-help-tab-links a {
					text-decoration: none;
					background-color: #f2f2f2;
					padding: 10px 20px;
					border: 1px solid #ccc;
					border-radius: 5px;
				}
		
				.zesthours-help-tab-links a:hover {
					background-color: #ddd;
				}
		
				.zesthours-help-tab-links .zesthours-help-tab-active a {
					background-color: #fff;
					border: 1px solid #ddd;
				}
		
				/* Style for tab content */
				.zesthours-help-tab {
					display: none;
				}
		
				.zesthours-help-tab-active {
					display: block;
				}
			</style>
		
			<script>
				document.addEventListener("DOMContentLoaded", function() {
					const tabLinks = document.querySelectorAll(".zesthours-help-tab-links a");
					const tabContents = document.querySelectorAll(".zesthours-help-tab-content .zesthours-help-tab");
		
					tabLinks.forEach((link) => {
						link.addEventListener("click", function (e) {
							e.preventDefault();
							tabLinks.forEach((l) => l.parentElement.classList.remove("zesthours-help-tab-active"));
							this.parentElement.classList.add("zesthours-help-tab-active");
		
							const targetTab = document.querySelector(this.getAttribute("href"));
							tabContents.forEach((tab) => tab.classList.remove("zesthours-help-tab-active"));
							targetTab.classList.add("zesthours-help-tab-active");
						});
					});
				});
			</script>
		
			<?php
		}
		
		
	}
}

new ZestHoursMenuHelpPage();
