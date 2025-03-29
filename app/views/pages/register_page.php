<div class="d-flex justify-content-center align-items-center auth-container">
    <div class="bg-secondary px-5 py-4 w-100 auth-card">
        <h1 class="text-center mb-4">Register form</h1>
        <div class="text-warning mb-3">
            <?php include_once '../app/views/errors.php' ?>
        </div>
        <form action="<?= $action ?>" method="post" novalidate>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control bg-dark text-light border-0" name="name" id="name"
                       value="<?= \app\core\Validation::getOld()['name'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="login" class="form-label">Login</label>
                <input type="text" class="form-control bg-dark text-light border-0" name="login" id="login"
                       value="<?= \app\core\Validation::getOld()['login'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control bg-dark text-light border-0" name="password" id="password" required>
            </div>
            <div class="mb-3">
                <label for="password_repeat" class="form-label">Repeat password</label>
                <input type="password" class="form-control bg-dark text-light border-0" name="password_repeat" id="password_repeat" required>
            </div>
            <div class="mb-4">
                <label for="secret_answer" class="form-label">Name your favorite film</label>
                <input type="text" class="form-control bg-dark text-light border-0" name="secret_answer" id="secret_answer" required>
            </div>
            <button type="submit" class="btn btn-outline-light w-100">Go</button>
        </form>
        <div class="mt-3 text-center">
            <a href="<?= \app\core\Route::url('auth','signin') ?>" class="link-light">Log in</a>
        </div>
    </div>
</div>
