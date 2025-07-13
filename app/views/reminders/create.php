<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h2>Create a New Reminder</h2>
    <form action="/reminders/store" method="post">
        <div class="mb-3">
            <label for="subject" class="form-label">Reminder</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>

