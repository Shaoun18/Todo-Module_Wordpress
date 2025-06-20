<?php
global $wpdb;
$tasks = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}todo_tasks");
?>

<div class="todo-container">
    <h2>To-Do List</h2>
    <form id="add-task-form">
        <input type="text" name="title" placeholder="Task Title" required>
        <input type="text" name="description" placeholder="Description">
        <button type="submit">Add Task</button>
    </form>

    <ul id="task-list">
        <?php foreach ($tasks as $task): ?>
            <li data-id="<?= $task->id ?>" class="<?= $task->is_done ? 'done' : '' ?>">
                <input type="checkbox" class="toggle-done" <?= $task->is_done ? 'checked' : '' ?>>
                <span class="task-title"><?= esc_html($task->title) ?></span>
                <span class="task-desc"><?= esc_html($task->description) ?></span>
                <button class="edit-task">Edit</button>
                <button class="delete-task">Delete</button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<!-- Edit Task Side Panel -->
<div id="edit-panel">
    <h3>Edit Task</h3>
    <form id="edit-task-form">
        <input type="hidden" name="id">
        <input type="text" name="title" placeholder="Task Title" required>
        <input type="text" name="description" placeholder="Description">
        <button type="submit">Save</button>
        <button type="button" id="close-edit-panel">Cancel</button>
    </form>
</div>