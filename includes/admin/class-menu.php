<?php

// Menu and submenu creation
function zesthours_add_menu() {
    add_menu_page(
        __('ZestHours', 'zesthours'),
        __('ZestHours', 'zesthours'),
        'manage_options',
        'zesthours_menu',
        'zesthours_menu_manage_page',
		'dashicons-clock'
    );
    
    add_submenu_page(
        'zesthours_menu',
        __('Settings', 'zesthours'),
        __('Settings', 'zesthours'),
        'manage_options',
        'zesthours_menu_settings',
        'zesthours_menu_settings_page'
    );
    add_submenu_page(
        'zesthours_menu',
        __('Help', 'zesthours'),
        __('Help', 'zesthours'),
        'manage_options',
        'zesthours_menu_help',
        'zesthours_menu_help_page'
    );
    remove_submenu_page( 'zesthours_menu', 'zesthours_menu' );
}
add_action( 'admin_menu', 'zesthours_add_menu' );