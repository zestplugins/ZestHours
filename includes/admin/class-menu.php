<?php

if ( ! class_exists( 'ZestHoursMenu' ) ) {
    /**
     * Class ZestHoursMenu
     *
     * This class handles the creation of menus and submenus for the ZestHours plugin.
     */
    class ZestHoursMenu {

        /**
         * ZestHoursMenu constructor.
         *
         * Adds an action hook to create the admin menu.
         */
        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_menu' ) );
        }

        /**
         * Adds the main menu and submenus for the ZestHours plugin.
         */
        public function add_menu() {
            // Add the main menu
            add_menu_page(
                __('ZestHours', 'zesthours'),
                __('ZestHours', 'zesthours'),
                'manage_options',
                'zesthours_menu',
                'zesthours_menu_manage_page',
                'dashicons-clock'
            );
        }
    }
}

new ZestHoursMenu();
