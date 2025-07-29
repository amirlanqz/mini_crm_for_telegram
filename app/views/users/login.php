<?php
$title = 'Login';
ob_start();
?>
    <h1>Login</h1>

    <form method="POST" action="?page=auth&action=authenticate">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label for="remember" class="form-check-label">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>

        <div class="mt-4">
            <p>You don't have an account? <a href="?page=register">Register here</a></p>
        </div>
    </form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
