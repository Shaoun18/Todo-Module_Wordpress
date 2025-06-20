<?php

function todo_module_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'todo_tasks';

    // Check if table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
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
}
