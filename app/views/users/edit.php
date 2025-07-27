<?php

$title = 'Eidt user';
ob_start();
?>
<h1>Edit user</h1>


<form method="POST" action="?page=users&&action=update&&id=<?php echo $user['id']; ?>">
    <div class="form-group">
        <label for="username"></label>
        <input type="text" class="form-control" id="login" name="username" value="<?php echo $user['username']?>" required>
    </div>
    <div class="form-group">
        <label for="email"></label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']?>" required>
    </div>
    <label for="role_id" class="form-label">Role</label>
    <select name="role_id" id="role_id" class="form-control">
        <option value="1" <?php echo $user['role_id'] === 1 ? 'selected' : ''?>>Admin</option>
        <option value="2" <?php echo $user['role_id'] === 2 ? 'selected' : ''?>>Content creator</option>
    </select>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>
?>