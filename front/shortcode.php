<?php
// Register shortcode to display tasks on frontend
add_shortcode('todo_task_list', 'todo_show_tasks_frontend');

function todo_show_tasks_frontend()
{
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
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($tasks as $task): ?>
                    <tr class="<?= $task->is_done ? 'done' : '' ?>">
                        <td><?= $i++ ?>.</td>
                        <td><?= esc_html($task->title) ?></td>
                        <td><?= esc_html($task->description) ?></td>
                        <td>
                            <?= $task->is_done ? '<span class="done-status">Done</span>' : '<span class="not-done-status">Not Done</span>' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php
    return ob_get_clean();
}
