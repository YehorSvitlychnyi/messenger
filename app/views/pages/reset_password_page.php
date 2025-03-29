<div class="auth-container d-flex justify-content-center">
    <div class="bg-secondary text-light px-5 py-4 w-100 auth-card">
        <h1 class="text-center mb-2">Reset password</h1>
        <h2 class="text-center mb-4">Your login: "<?= \app\core\Session::getItem('login_change') ?>"</h2>
        <div class="text-warning mb-3">
            <?php include_once '../app/views/errors.php' ?>
        </div>
        <form action="<?= $action ?>" method="post" autocomplete="off">
            <div class="mb-3">
                <label for="password" class="form-label">New password</label>
                <input type="password" class="form-control bg-dark text-light border-0" name="password" id="password" required>
            </div>
            <div class="mb-4">
                <label for="repeat_password" class="form-label">Repeat password</label>
                <input type="password" class="form-control bg-dark text-light border-0" name="repeat_password" id="repeat_password" required>
            </div>
            <button type="submit" class="btn btn-outline-light w-100">Go</button>
        </form>
        <div class="mt-3 text-center">
            <a href="<?= \app\core\Route::url('auth','signin') ?>" class="link-light">Log in</a>
        </div>
    </div>
</div>
