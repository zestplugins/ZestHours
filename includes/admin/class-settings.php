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

			function zesthours_get_timezones() {
				$timezones = DateTimeZone::listIdentifiers( DateTimeZone::ALL );
				$timezones_list = array();
	
				foreach ( $timezones as $timezone ) {
					$timezones_list[$timezone] = $timezone;
				}
	
				return $timezones_list;
			}

			// Save Settings
			if ( isset( $_POST['submit'] ) ) {

				$days = array( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' );
				foreach ( $days as $day ) {
					update_option( "zesthours_opening_hours_$day", sanitize_text_field( $_POST["opening_hours_$day"] ) );
					update_option( "zesthours_closing_hours_$day", sanitize_text_field( $_POST["closing_hours_$day"] ) );
				}
		
				update_option( 'zesthours_title', sanitize_text_field( $_POST['title'] ) );
				update_option( 'zesthours_opening_message', sanitize_text_field( $_POST['opening_message'] ) );
				update_option( 'zesthours_open_label', sanitize_text_field( $_POST['open_label'] ) );
				update_option( 'zesthours_closing_message', sanitize_text_field( $_POST['closing_message'] ) );
				update_option( 'zesthours_close_label', sanitize_text_field( $_POST['close_label'] ) );
		
				$time_format = isset( $_POST['time_format'] ) ? sanitize_text_field( $_POST['time_format'] ) : '12-hour';
				update_option( 'zesthours_time_format', $time_format );
		
				$selected_timezone = sanitize_text_field( $_POST['selected_timezone'] );
				update_option( 'zesthours_selected_timezone', $selected_timezone );
		 
				update_option( 'zesthours_bg_color', sanitize_hex_color( $_POST['bg_color'] ) );
				update_option( 'zesthours_header_bg_color', sanitize_hex_color( $_POST['header_bg_color'] ) );
				update_option( 'zesthours_text_color', sanitize_hex_color( $_POST['text_color'] ) );
				update_option( 'zesthours_font_size', sanitize_text_field( $_POST['font_size'] ) );
		
				$display_timezone_message = isset( $_POST['display_timezone_message'] ) ? 'on' : 'off';
				update_option( 'zesthours_display_timezone_message', $display_timezone_message );
		
				$display_local_time_message = isset( $_POST['display_local_time_message'] ) ? 'on' : 'off';
				update_option( 'zesthours_display_local_time_message', $display_local_time_message );
			}
		
			// Retrieve settings
			$time_format                = get_option( 'zesthours_time_format', '12-hour' );
			$opening_hours              = get_option( 'zesthours_opening_hours', '08:00' );
			$closing_hours              = get_option( 'zesthours_closing_hours', '17:00' );
			$display_timezone_message   = get_option( 'zesthours_display_timezone_message', 'on' );
			$display_local_time_message = get_option( 'zesthours_display_local_time_message', 'on' );
			$title                      = get_option( 'zesthours_title', 'Business Hours' );
			$opening_message            = get_option( 'zesthours_opening_message', 'We are currently open!' );
			$open_label                 = get_option( 'zesthours_open_label', 'open' );
			$closing_message            = get_option( 'zesthours_closing_message', 'Sorry we are currently closed!' );
			$close_label                = get_option( 'zesthours_close_label', 'closed' );
			$bg_color                   = get_option( 'zesthours_bg_color', '#ecf0f1' );
			$header_bg_color            = get_option( 'zesthours_header_bg_color', '#3498db' );
			$text_color                 = get_option( 'zesthours_text_color', '#000000' );
			$font_size                  = get_option( 'zesthours_font_size', '14px');
			$selected_timezone          = get_option( 'zesthours_selected_timezone', 'UTC' );
			$available_timezones        = zesthours_get_timezones();
			?>
			<div class="wrap" style="background-color: white; margin-right: 15px; margin-top: 15px; min-height: 100svh; border: 1px solid #3498db;">
	
				<div class="zesthours-settings-main">
					<h1 style="color: whitesmoke;"><?php esc_html_e( 'ZestHours', 'zesthours' ); ?></h1>
				</div>

				<div class="zesthours-settings-tabs">
					<div class="zesthours-settings-tab" id="zesthours-settings-tab-general"><?php esc_html_e( 'General', 'zesthours' ); ?></div>
					<div class="zesthours-settings-tab" id="zesthours-settings-tab-messages"><?php esc_html_e( 'Messages', 'zesthours' ); ?></div>
					<div class="zesthours-settings-tab" id="zesthours-settings-tab-advanced"><?php esc_html_e( 'Advanced', 'zesthours' ); ?></div>
					<div class="zesthours-settings-tab" id="zesthours-settings-tab-appearance"><?php esc_html_e( 'Appearance', 'zesthours' ); ?></div>
				</div>
	
				<form method="post" class="settings-content">
					<!-- start of tab -->
					<div id="content-zesthours-settings-tab-general" class="zesthours-settings-tab-content" style="display: block;">
	
						<?php
						$current_local_time = date( 'H:i', current_time( 'timestamp', true ) );
						echo '<p>Enter time hours in 24-hour format e.g ' . esc_html( $current_local_time ) . '</p>';
						?>
	
						<?php
						$days = array( 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' );
						echo '<div style="display: grid; grid-template-columns: repeat( 7, 1fr ); grid-gap: 20px;">';
	
						// Days row
						echo '<div style="display: flex; flex-direction: column; text-align: left;">';
						echo '<label style="margin-bottom: 20px;"></label>';
						foreach ( $days as $day ) {
							echo '<p style="margin-top: 5.5px; margin-bottom: 5.5px;">' . esc_html( ucfirst( $day ) ) . '</p>';
						}
						echo '</div>';
	
						// Opening Hours row
						echo '<div style="display: flex; flex-direction: column; align-items: center;">';
						echo '<label style="margin-bottom: 5px;">' . esc_html__( 'Opening Hours', 'zesthours' ) . '</label>';
						foreach ( $days as $day ) {
							echo '<input type="text" name="opening_hours_' . $day . '" value="' . esc_attr( get_option( "zesthours_opening_hours_$day", '' ) ) . '" />';
						}
						echo '</div>';
	
						// Closing Hours row
						echo '<div style="display: flex; flex-direction: column; align-items: center;">';
						echo '<label style="margin-bottom: 5px;">' . esc_html__( 'Closing Hours', 'zesthours' ) . '</label>';
						foreach ( $days as $day ) {
							echo '<input type="text" name="closing_hours_' . $day . '" value="' . esc_attr( get_option( "zesthours_closing_hours_$day", '' ) ) . '" />';
						}
						echo '</div>';
	
						echo '</div>';
	
						?>
					</div>
					
					<!-- end of tab  -->
	
					<!-- start of tab -->
					<div id="content-zesthours-settings-tab-messages" class="zesthours-settings-tab-content">
						<section class="zesthours-settings-inputs" style="display: flex; flex-direction: column; max-width: 520px; margin-top: 30px;">               
	
						<div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 10px;">
							<label for="title" style="width: 26%;"><?php esc_html_e( 'Title:', 'zesthours' ); ?></label>
							<input type="text" style="width: 74%;" name="title" id="title" value="<?php echo esc_attr( $title ); ?>" />
						</div>
	
						<div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 10px;">
							<label for="opening_message" style="width: 26%;"><?php esc_html_e( 'Opening Message:', 'zesthours' ); ?></label>
							<input type="text" style="width: 74%; min-height: 50px;" name="opening_message" id="opening_message" value="<?php echo esc_attr( $opening_message ); ?>" />
						</div>
	
						<div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 10px;">
						<label for="open_label" style="width: 26%;"><?php esc_html_e( 'Opening label:', 'zesthours' ); ?></label>
						<input type="text" style="width: 74%;" name="open_label" id="open_label" value="<?php echo esc_attr( $open_label ); ?>" />
						</div>
	
						<div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 10px;">
						<label for="closing_message" style="width: 26%;"><?php esc_html_e( 'Closing Message:', 'zesthours' ); ?></label>
						<input type="text" style="width: 74%; min-height: 50px;" name="closing_message" id="closing_message" value="<?php echo esc_attr( $closing_message ); ?>" />
						</div>
	
						<div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 10px;">
						<label for="close_label" style="width: 26%;"><?php esc_html_e( 'Closing label:', 'zesthours' ); ?></label>
						<input type="text" style="width: 74%;" name="close_label" id="close_label" value="<?php echo esc_attr( $close_label ); ?>" />
						</div>
	
						</section>
					</div>           
	
					<!-- End of Tab -->
	
					<!-- start of tab  -->
	
					<div id="content-zesthours-settings-tab-advanced" class="zesthours-settings-tab-content">
						<h3><?php esc_html_e( 'Time Format', 'zesthours' ); ?></h3>
						<div>
							<label>
								<input type="radio" name="time_format" value="12-hour" <?php checked( $time_format, '12-hour' ); ?>>
								<?php esc_html_e( '12-hour Format', 'zesthours' ); ?>
							</label>
							<label>
								<input type="radio" name="time_format" value="24-hour" <?php checked( $time_format, '24-hour' ); ?>>
								<?php esc_html_e( '24-hour Format', 'zesthours' ); ?>
							</label>
						</div>
	
						<h3><?php esc_html_e( 'Timezone', 'zesthours' ); ?></h3>
						<label for="selected_timezone"><?php esc_html_e( 'Select Timezone:', 'zesthours' ); ?></label>
						<select name="selected_timezone" id="selected_timezone">
							<?php foreach ( $available_timezones as $timezone_value => $timezone_label ) {
								echo '<option value="' . esc_attr( $timezone_value ) . '" ' . selected( $selected_timezone, $timezone_value, false ) . '>' . esc_html( $timezone_label ) . '</option>';
							} ?>
						</select>
	
	
						<h3><?php esc_html_e( 'Display Messages', 'zesthours' ); ?></h3>
						<div  style="display: flex; flex-direction:column;">
							<label style="margin-bottom: 10px;">
								<input type="checkbox" class="checkbox" name="display_timezone_message" <?php checked( $display_timezone_message, 'on' ); ?>>
								<?php esc_html_e( 'Display Timezone Message', 'zesthours' ); ?>
							</label>
							<label>
								<input type="checkbox" name="display_local_time_message" <?php checked( $display_local_time_message, 'on' ); ?>>
								<?php esc_html_e( 'Display Local Time Message', 'zesthours' ); ?>
							</label>
						</div>               
	
					</div>
	
					<!-- End of tab -->
	
					<!-- start of tab -->
					<div id="content-zesthours-settings-tab-appearance" class="zesthours-settings-tab-content">
						<div style="display: flex;">
							<div class="zesthours-settings-column">
								<div class="zesthours-settings-row-label">
									<label for="bg_color"><?php esc_html_e( 'Background Color:', 'zesthours' ); ?></label>
								</div>

								<div class="zesthours-settings-row-label">
									<label for="header_bg_color"><?php esc_html_e( 'Header Background Color:', 'zesthours' ); ?></label>
								</div>

								<div class="zesthours-settings-row-label">
									<label for="text_color"><?php esc_html_e( 'Text Color:', 'zesthours' ); ?></label>
								</div>

								<div class="zesthours-settings-row-label">
									<label for="font_size"><?php esc_html_e( 'Font Size:', 'zesthours' ) ?></label>
								</div>
							</div>
							<div class="zesthours-settings-column">
								<div class="zesthours-settings-row">
									<input type="color" name="bg_color" id="bg_color" value="<?php echo esc_attr( $bg_color ); ?>" />
								</div>

								<div class="zesthours-settings-row">
									<input type="color" name="header_bg_color" id="header_bg_color" value="<?php echo esc_attr( $header_bg_color ); ?>" />
								</div>

								<div class="zesthours-settings-row">
									<input type="color" name="text_color" id="text_color" value="<?php echo esc_attr( $text_color ); ?>" />
								</div>

								<div class="zesthours-settings-row">
									<input type="text" name="font_size" id="font_size" value="<?php echo esc_attr( $font_size ); ?>" />
								</div>
							</div>
						</div>
						
					</div>

					<style>
					.zesthours-settings-column {
						display: flex;
						flex-direction: column;
						margin-right: 20px;
					}

					/* Style for the labels in the left column */
					.zesthours-settings-row {
						margin-bottom: 10px;
					}
					.zesthours-settings-row-label{
						margin-bottom: 20px;
						font-weight: bold;
					}

					/* Style for the input elements in the right column */
					.zesthours-settings-row input[type="color"],
					.zesthours-settings-row input[type="text"] {
						width: 100%;
					}

					</style>
	
					<p class="submit">
						<input type="submit" name="submit" id="submit" class="button" style="margin-left: 5px; border: 2px solid #fff; color: black; background-color:  #3498db;" value="<?php esc_attr_e( 'Save Changes', 'zesthours' ); ?>">
					</p>
	
				</form>

			</div>

			<script>
				document.addEventListener('DOMContentLoaded', function () {
					const tabs = document.querySelectorAll('.zesthours-settings-tab');
					const tabContents = document.querySelectorAll('.zesthours-settings-tab-content');

					tabs.forEach((tab, index) => {
						tab.addEventListener('click', () => {
							tabs.forEach(t => t.classList.remove('zesthours-settings-active-tab'));
							tab.classList.add('zesthours-settings-active-tab');

							tabContents.forEach(content => content.style.display = 'none');
							tabContents[index].style.display = 'block';
						});
					});

					tabContents.forEach((content, index) => {
						if (index !== 0) {
							content.style.display = 'none';
						}
					});
					
					tabs[0].classList.add('zesthours-settings-active-tab');
				});
			</script>
			<?php
		}
	}
}

new ZestHours_Menu_Settings_Page();
