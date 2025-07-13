<?php require_once 'app/views/templates/header.php'; ?>
<div class="container mt-4">
    <h2>Edit Reminder</h2>
    <form method="post">
        <div class="mb-3">
            <label for="subject" class="form-label">Reminder</label>
            <input type="text" name="subject" id="subject" class="form-control" value="<?= htmlspecialchars($data['subject']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<?php require_once 'app/views/templates/footer.php'; ?>
