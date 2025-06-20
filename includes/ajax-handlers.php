<?php

add_action('wp_ajax_add_task', 'todo_add_task');
add_action('wp_ajax_toggle_task', 'todo_toggle_task');
add_action('wp_ajax_delete_task', 'todo_delete_task');
add_action('wp_ajax_edit_task', 'todo_edit_task');

function todo_add_task()
{
    check_ajax_referer('todo_nonce');
    global $wpdb;
    $wpdb->insert($wpdb->prefix . 'todo_tasks', [
        'title' => sanitize_text_field($_POST['title']),
        'description' => sanitize_text_field($_POST['description'])
    ]);
    wp_send_json_success();
}

function todo_toggle_task()
{
    check_ajax_referer('todo_nonce');
    global $wpdb;
    $wpdb->update($wpdb->prefix . 'todo_tasks', [
        'is_done' => intval($_POST['is_done'])
    ], ['id' => intval($_POST['id'])]);
    wp_send_json_success();
}

function todo_delete_task()
{
    check_ajax_referer('todo_nonce');
    global $wpdb;
    $wpdb->delete($wpdb->prefix . 'todo_tasks', ['id' => intval($_POST['id'])]);
    wp_send_json_success();
}

function todo_edit_task()
{
    check_ajax_referer('todo_nonce');
    global $wpdb;
    $wpdb->update($wpdb->prefix . 'todo_tasks', [
        'title' => sanitize_text_field($_POST['title']),
        'description' => sanitize_text_field($_POST['description'])
    ], ['id' => intval($_POST['id'])]);
    wp_send_json_success();
}
