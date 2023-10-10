<?php
if (!class_exists('ZestHours_Shortcode')) {
    /**
     * Class ZestHours_Shortcode
     *
     * This class handles the creation of menus and submenus for the ZestHours plugin.
     */
    class ZestHours_Shortcode
    {

        /**
         * ZestHours_Shortcode constructor.
         *
         * Adds an action hook to register the shortcode.
         */
        public function __construct()
        {
            add_action('init', array($this, 'register_shortcode'));
        }

        /**
         * Register the shortcode.
         */
        public function register_shortcode()
        {
            add_shortcode('zesthours', array($this, 'zesthours_shortcode'));
        }

        public function zesthours_shortcode($atts)
        {
            $atts = shortcode_atts(array(), $atts);

            // Retrieve saved settings.
            $title = get_option('zesthours_title', 'Business Hours');
            $opening_message = get_option('zesthours_opening_message', 'We are currently open!');
            $open_label = get_option('zesthours_open_label', 'open');
            $closing_message = get_option('zesthours_closing_message', 'Sorry, we are currently closed!');
            $close_label = get_option('zesthours_close_label', 'closed');
            $bg_color                   = get_option( 'zesthours_bg_color', '#ecf0f1' );
			$header_bg_color            = get_option( 'zesthours_header_bg_color', '#3498db' );
            $text_color = get_option('zesthours_text_color', '#000000');
            $font_size = get_option('zesthours_font_size', '14px');
            $time_format = get_option('zesthours_time_format', '12-hour');

            $display_timezone_message = get_option('zesthours_display_timezone_message', 'off');
            $display_local_time_message = get_option('zesthours_display_local_time_message', 'off');

            $selected_timezone = get_option('zesthours_selected_timezone', 'UTC');
            date_default_timezone_set($selected_timezone);

            $current_day = date_i18n('l');
            $current_time = date('H:i', current_time('timestamp', true));

            $opening_hours = get_option("zesthours_opening_hours_$current_day", '');
            $closing_hours = get_option("zesthours_closing_hours_$current_day", '');

            // Calculate whether the business is open or closed.
            $is_open = (!empty($opening_hours) && !empty($closing_hours) && $current_time >= $opening_hours && $current_time <= $closing_hours);

            // Get current day and date.
            $current_day = date_i18n('l');
            $current_date = date_i18n('F j, Y');

            // Convert hours to selected time format for display only.
            if ($time_format === '12-hour') {
                $opening_hours_display = !empty($opening_hours) ? date('h:i A', strtotime($opening_hours)) : 'Closed';
                $closing_hours_display = !empty($closing_hours) ? date('h:i A', strtotime($closing_hours)) : '';
            } else {
                $opening_hours_display = !empty($opening_hours) ? $opening_hours : 'Closed';
                $closing_hours_display = !empty($closing_hours) ? $closing_hours : '';
            }

            // Create the HTML output.
            $output = '<div class="zesthours-business-hours" style="border: 1px solid ' . esc_attr($header_bg_color) . '; width: 300px; font-size: ' . esc_html($font_size) . '">';
            $output .= '<div class="zesthours-header" style="padding: 2px; display: flex; flex-direction: column; justify-content: space-around; align-items: center; background-color: ' . esc_attr($header_bg_color) . '; color: ' . esc_attr($text_color) . ';">';
            $output .= '<h4 style="margin: 0;">' . esc_html($title) . '</h4>';
            $output .= '<div class="zesthours-day-date" style="margin: 0;">';
            $output .= '<p style="margin: 0;">' . esc_html($current_day) . ', ' . esc_html($current_date) . '</p>';
            $output .= '</div>';
            if ($is_open) {
                $output .= '<span class="open-label" style="background-color: ' . esc_attr($header_bg_color) . '; color: ' . esc_attr($text_color) . ';">' . esc_html($open_label) . '</span>';
            } else {
                $output .= '<span class="close-label" style="padding: 4px; border-radius: 5px; background-color: ' . esc_attr($header_bg_color) . '; color: ' . esc_attr($text_color) . ';">' . esc_html($close_label) . '</span>';
            }
            $output .= '</div>';

            $output .= '<div style="background-color: ' . esc_attr($bg_color) . '; padding: 3px 5px">';
            // Display opening and closing hours for each day.
            $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
            $output .= '<ul class="zesthours-opening-hours-list " style="margin-bottom: 0;">';
            foreach ($days as $day) {
                $opening_hours = get_option("zesthours_opening_hours_$day", '08:00');
                $closing_hours = get_option("zesthours_closing_hours_$day", '17:00');

                // Convert hours to selected time format for display only.
                if ($time_format === '12-hour') {
                    $opening_hours_display = !empty($opening_hours) ? date('h:i A', strtotime($opening_hours)) : 'Closed';
                    $closing_hours_display = !empty($closing_hours) ? date('h:i A', strtotime($closing_hours)) : '';
                } else {
                    $opening_hours_display = !empty($opening_hours) ? $opening_hours : 'Closed';
                    $closing_hours_display = !empty($closing_hours) ? $closing_hours : '';
                }

                $output .= '<li style="list-style: none;"><strong>' . esc_html(ucfirst($day)) . ':</strong> ' . esc_html($opening_hours_display);
                if (!empty($closing_hours_display)) {
                    $output .= ' - ' . esc_html($closing_hours_display);
                }
                $output .= '</li>';
            }
            $output .= '</ul>';

            $output .= '<div class="zesthours-display-message" style="margin-top: 20px; text-align: left;" style="margin: 0;">';
            if ($is_open) {
                $output .= '<p>' . esc_html($opening_message) . '</p>';
            } else {
                $output .= '<p>' . esc_html($closing_message) . '</p>';
            }
            $output .= '</div>';

            // Display timezone message if enabled.
            if ($display_timezone_message === 'on') {
                $output .= '<div class="">';
                $output .= '<p style="margin: 0;">Our hours are displayed in ' . esc_html($selected_timezone) . ' timezone.</p>';
                $output .= '</div>';
            }

            // Display local time message if enabled.
            if ($display_local_time_message === 'on') {
                $output .= '<div class="">';
                if ($time_format === '12-hour') {
                    $current_local_time = date('h:i A l', current_time('timestamp', true));
                    $output .= '<p style="margin: 0;">Our local time is ' . esc_html($current_local_time) . '.</p>';
                } else {
                    $current_local_time = date('H:i l', current_time('timestamp', true));
                    $output .= '<p style="margin: 0;">Our local time is ' . esc_html($current_local_time) . '.</p>';
                }
                $output .= '</div>';
            }

            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }
    }
}

new ZestHours_Shortcode();
