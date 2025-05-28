jQuery(document).ready(function ($) {
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

    $('.edit-task').on('click', function () {
        const li = $(this).closest('li');
        const title = prompt('New Title:', li.find('.task-title').text());
        const desc = prompt('New Description:', li.find('.task-desc').text());
        if (!title) return;

        $.post(todo_ajax.ajax_url, {
            action: 'edit_task',
            id: li.data('id'),
            title,
            description: desc,
            _ajax_nonce: todo_ajax.nonce
        }, function () {
            location.reload();
        });
    });
});
