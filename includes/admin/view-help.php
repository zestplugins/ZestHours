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
			<section style="background-color: white; margin-right: 15px; margin-top: 15px; min-height: 100svh;">
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
							<div style="background-color: #ecf0f1; padding: 20px; margin: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
								<h3 style="color: #3498db;"><?php esc_html_e( '💐 Thank You For choosing ZestHours.', 'zesthours' ); ?></h3>
								<p><?php esc_html_e( 'Better, beautiful, and flexible business hours management and display. ZestHours offers you a better way to manage and display your business hours. With a beautiful and flexible design, you can customize your opening and closing hours to fit your needs. Make a great first impression on your customers with ZestHours.', 'zesthours' ); ?></p>
							</div>

							
							<div style="background-color: #ecf0f1; padding: 20px; margin: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
								<h3 style="color: #3498db;"><?php esc_html_e( 'Configure Your Business Hours', 'zesthours' ); ?></h3>								
								<p><?php esc_html_e( 'With ZestHours, you have the flexibility to set up your business hours exactly the way you want. You can customize the appearance of your business hours display and the messages to be shown when you are open or closed.', 'zesthours' ); ?></p>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=zesthours_menu_settings' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Configure Hours Now', 'zesthours' ); ?></a>
							</div>

							<div style="background-color: #ecf0f1; padding: 20px; margin: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
								<h3 style="color: #3498db;"><?php esc_html_e( 'Display Your Business Hours', 'zesthours' ); ?></h3>
								<p><?php esc_html_e( 'Use the [ZestHours] shortcode to display your business hours on any page or post. Simply insert the shortcode where you want your business hours to appear.', 'zesthours' ); ?></p>
							</div>
						</div>
			
						<div id="zesthours-support-tab" class="zesthours-help-tab">
							<h3><?php esc_html_e( '🚑 Require assistance? Our support team is ready to assist you.', 'zesthours' ); ?></h3>
							<div class="zesthours-supp">								
								<p><a href=""><?php esc_html_e( 'ZestHours Documentation => ', 'zesthours' ); ?></a>Our documentation comprehensively covers all you require, from installation instructions and hours management to troubleshooting common issues and expanding functionality.</p>
							</div>
							<div class="zesthours-supp">								
								<p><a href=""><?php esc_html_e( 'ZestHours Bug Report => ', 'zesthours' ); ?></a>Stumbled upon an issue or a bug? We appreciate your help in making our product better. Please take a moment to report it, and we'll work diligently to address it.</p>
							</div>
							<div class="zesthours-supp">								
								<p><a href=""><?php esc_html_e( 'ZestHours Feature Request => ', 'zesthours' ); ?></a>Have a great idea for a new feature or improvement? We'd love to hear your suggestions! Share your thoughts with us, and we'll consider implementing it to enhance our product.</p>
							</div>
						</div>
					</div>
				</div>
			</section>
					
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
