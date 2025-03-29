<div class="d-flex justify-content-center align-items-center auth-container">
    <div class="bg-secondary text-light px-5 py-4 w-100 auth-card">
        <h1 class="text-center mb-4">Give an answer: "Name your favorite film"</h1>
        <div class="text-warning mb-3">
            <?php include_once '../app/views/errors.php' ?>
        </div>
        <form method="post" action="<?= $action ?>" autocomplete="off">
            <div class="mb-3">
                <label for="login" class="form-label">Your login</label>
                <input type="text" class="form-control bg-dark text-light border-0" name="login" id="login"
                       placeholder="Your login" value="<?= \app\core\Validation::getOld()['login'] ?? '' ?>" autofocus required>
            </div>
            <div class="mb-4">
                <label for="secret_answer" class="form-label">Secret answer</label>
                <input type="text" class="form-control bg-dark text-light border-0" name="secret_answer" id="secret_answer"
                       placeholder="Secret answer" required>
            </div>
            <button type="submit" class="btn btn-outline-light w-100">Submit</button>
        </form>
        <div class="mt-3 text-center">
            <a href="<?= \app\core\Route::url('auth','signin') ?>" class="link-light">Log in</a>
        </div>
    </div>
</div>
