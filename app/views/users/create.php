<?php

$title = 'Create user';
ob_start();
?>
<h1>Create user</h1>

<form method="POST" action="?page=users&&action=store">
    <div class="form-group">
        <label for="username">Login</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password" class="form-group">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label for="confirm_password" class="form-group">Confirm password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>
      <button type="submit" class="btn btn-primary">Create</button>
</form>

<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>
?>