jQuery(document).ready(function ($) {
    // Add Task
    $('#add-task-form').on('submit', function (e) {
        e.preventDefault();
        $.post(todo_ajax.ajax_url, {
            action: 'add_task',
            title: $('input[name="title"]').val(),
            description: $('input[name="description"]').val(),
            _ajax_nonce: todo_ajax.nonce
        }, function (res) {
            if (res.success) location.reload();
        });
    });

    // Toggle Task
    $('.toggle-done').on('change', function () {
        const li = $(this).closest('li');
        $.post(todo_ajax.ajax_url, {
            action: 'toggle_task',
            id: li.data('id'),
            is_done: $(this).is(':checked') ? 1 : 0,
            _ajax_nonce: todo_ajax.nonce
        }, function () {
            li.toggleClass('done');
        });
    });

    // Delete Task
    $('.delete-task').on('click', function () {
        if (!confirm('Delete this task?')) return;
        const li = $(this).closest('li');
        $.post(todo_ajax.ajax_url, {
            action: 'delete_task',
            id: li.data('id'),
            _ajax_nonce: todo_ajax.nonce
        }, function () {
            li.remove();
        });
    });

    // Open Edit Panel
    $('.edit-task').on('click', function () {
        const li = $(this).closest('li');
        const id = li.data('id');
        const title = li.find('.task-title').text();
        const description = li.find('.task-desc').text();

        $('#edit-task-form [name="id"]').val(id);
        $('#edit-task-form [name="title"]').val(title);
        $('#edit-task-form [name="description"]').val(description);

        $('#edit-panel').addClass('open');
    });

    // Save Edited Task
    $('#edit-task-form').on('submit', function (e) {
        e.preventDefault();

        const id = $(this).find('[name="id"]').val();
        const title = $(this).find('[name="title"]').val();
        const description = $(this).find('[name="description"]').val();

        $.post(todo_ajax.ajax_url, {
            action: 'edit_task',
            id,
            title,
            description,
            _ajax_nonce: todo_ajax.nonce
        }, function () {
            $('#edit-panel').removeClass('open');
            location.reload();
        });
    });

    // Close Edit Panel
    $('#close-edit-panel').on('click', function () {
        $('#edit-panel').removeClass('open');
    });
});
