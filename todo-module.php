<?php

/**
 * Plugin Name: Todo Module
 * Description: A simple To-Do List managed via WordPress Admin using AJAX.
 * Version: 1.0.0
 * Author: Shaoun Chandra Shill
 */

if (!defined('ABSPATH')) {
    exit;
}

// Activation hook
require_once plugin_dir_path(__FILE__) . 'db/database.php';
register_activation_hook(__FILE__, 'todo_module_create_table');

// Enqueue assets
add_action('admin_enqueue_scripts', 'todo_module_enqueue');
add_action('wp_enqueue_scripts', 'todo_module_enqueue');

function todo_module_enqueue()
{
    wp_enqueue_style('todo-style', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('todo-script', plugin_dir_url(__FILE__) . 'assets/script.js', ['jquery'], null, true);

    wp_localize_script('todo-script', 'todo_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('todo_nonce'),
    ]);
}

// Admin menu
require_once plugin_dir_path(__FILE__) . 'includes/admin-menu.php';

// AJAX HandlersPP
require_once plugin_dir_path(__FILE__) . 'includes/ajax-handlers.php';

// Frontend ShortCode
require_once plugin_dir_path(__FILE__) . 'front/shortcode.php';
