<div class="d-flex justify-content-center auth-container">
    <div class="bg-secondary text-light p-4 min-max-w auth-card">
        <h1 class="text-center mb-4">Welcome to messenger</h1>
        <div class="mb-3 text-warning">
            <?php include_once '../app/views/errors.php' ?>
        </div>
        <form action="<?= $action ?>" method="post" novalidate>
            <div class="mb-3">
                <label for="login" class="form-label">Login</label>
                <input type="text" class="form-control bg-dark text-light border-0" name="login" id="login"
                       value="<?= \app\core\Validation::getOld()['login'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input type="password" class="form-control bg-dark text-light border-0" name="password" id="pass" required>
            </div>
            <button type="submit" class="btn btn-outline-light w-100">Go</button>
        </form>
        <div class="mt-3 d-flex justify-content-between">
            <a href="<?= \app\core\Route::url('auth','signup') ?>" class="link-light">Register</a>
            <a href="<?= \app\core\Route::url('auth','forgot') ?>" class="link-light">Forgot password</a>
        </div>
    </div>
</div>
