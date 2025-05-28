<?php

/**
 * Plugin Name: Todo Module
 * Plugin URI:
 * Description: A simple To-Do List managed via WordPress Admin using AJAX.
 * Version: 1.0.0
 * Author: Shaoun Chandra Shill
 * Author URI: https://programmershaoun.com/
 * Text Domain: 
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// Stops direct access
if (!defined('ABSPATH')) {
    exit;
}

register_activation_hook(__FILE__, 'todo_module_create_table');

function todo_module_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'todo_tasks';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title text NOT NULL,
        description text,
        is_done tinyint(1) DEFAULT 0,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Enqueue assets
add_action('admin_enqueue_scripts', 'todo_module_enqueue');
add_action('wp_enqueue_scripts', 'todo_module_enqueue');

function todo_module_enqueue() {
    wp_enqueue_style('todo-style', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('todo-script', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery'), null, true);

    wp_localize_script('todo-script', 'todo_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('todo_nonce')
    ]);
}

// Admin menu
add_action('admin_menu', 'todo_module_menu');
function todo_module_menu() {
    add_menu_page('To-Do Module', 'To-Do Module', 'manage_options', 'todo-module', 'todo_module_page');
}

function todo_module_page() {
    include plugin_dir_path(__FILE__) . 'templates/todo-admin-page.php';
}

// AJAX Actions
add_action('wp_ajax_add_task', 'todo_add_task');
add_action('wp_ajax_toggle_task', 'todo_toggle_task');
add_action('wp_ajax_delete_task', 'todo_delete_task');
add_action('wp_ajax_edit_task', 'todo_edit_task');

function todo_add_task() {
    check_ajax_referer('todo_nonce');
    global $wpdb;
    $wpdb->insert($wpdb->prefix . 'todo_tasks', [
        'title' => sanitize_text_field($_POST['title']),
        'description' => sanitize_text_field($_POST['description'])
    ]);
    wp_send_json_success();
}

function todo_toggle_task() {
    check_ajax_referer('todo_nonce');
    global $wpdb;
    $wpdb->update($wpdb->prefix . 'todo_tasks',
        ['is_done' => intval($_POST['is_done'])],
        ['id' => intval($_POST['id'])]
    );
    wp_send_json_success();
}

function todo_delete_task() {
    check_ajax_referer('todo_nonce');
    global $wpdb;
    $wpdb->delete($wpdb->prefix . 'todo_tasks', ['id' => intval($_POST['id'])]);
    wp_send_json_success();
}

function todo_edit_task() {
    check_ajax_referer('todo_nonce');
    global $wpdb;
    $wpdb->update($wpdb->prefix . 'todo_tasks', [
        'title' => sanitize_text_field($_POST['title']),
        'description' => sanitize_text_field($_POST['description'])
    ], ['id' => intval($_POST['id'])]);
    wp_send_json_success();
}