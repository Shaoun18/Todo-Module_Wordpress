<?php

add_action('admin_menu', 'todo_module_menu');

function todo_module_menu()
{
    add_menu_page(
        'To-Do Module',
        'To-Do Module',
        'manage_options',
        'todo-module',
        'todo_module_page'
    );
}

function todo_module_page()
{
    include plugin_dir_path(__FILE__) . '/../templates/todo-admin-page.php';
}
