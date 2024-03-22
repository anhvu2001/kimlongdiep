<?php
/*
Plugin Name: KLD custom Plugin
*/
function My_Custom_Plugin_Start() {
    require_once(__DIR__ . '/includes/plugin.php');
    \KLD_Elementor_Addon\Plugin::instance();
}
add_action('plugins_loaded', 'My_Custom_Plugin_Start');
