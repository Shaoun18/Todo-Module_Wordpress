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
require_once plugin_dir_path(__FILE__) . 'db/install.php';
register_activation_hook(__FILE__, 'todo_module_create_table');

// Enqueue assets
add_action('admin_enqueue_scripts', 'todo_module_enqueue');
add_action('wp_enqueue_scripts', 'todo_module_enqueue');

function todo_module_enqueue() {
    wp_enqueue_style('todo-style', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('todo-script', plugin_dir_url(__FILE__) . 'assets/script.js', ['jquery'], null, true);

    wp_localize_script('todo-script', 'todo_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('todo_nonce'),
    ]);
}

// Admin menu
require_once plugin_dir_path(__FILE__) . 'includes/admin-menu.php';

// AJAX Handlers
require_once plugin_dir_path(__FILE__) . 'includes/ajax-handlers.php';



            ///   Frontend View the page Code  /////


// Register shortcode to display tasks on frontend
add_shortcode('todo_task_list', 'todo_show_tasks_frontend');

function todo_show_tasks_frontend() {
    global $wpdb;
    $tasks = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}todo_tasks");

    ob_start();
    ?>
    <div class="frontend-todo">
        <h2>ToDo Module</h2>
        <table class="todo-table">
            <thead>
                <tr>
                    <th>Task Number</th>
                    <th>Task Name</th>
                    <th>Task Description</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($tasks as $task): ?>
                    <tr class="<?= $task->is_done ? 'done' : '' ?>">
                        <td><?= $i++ ?>.</td>
                        <td><?= esc_html($task->title) ?></td>
                        <td><?= esc_html($task->description) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    return ob_get_clean();
}


