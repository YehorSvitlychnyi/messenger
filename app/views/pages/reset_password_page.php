<div class="reset-container">
    <h1 class="login-h1">Reset password</h1>

    <form action="<?= \app\core\Route::url('auth', 'resetpassword') ?>" method="post">
        <div class="form-group">
            <label for="new_password">New password</label>
            <input type="password" name="new_password" id="new_password"/>
        </div>

        <div class="form-group">
            <label for="repeat_password">Repeat password</label>
            <input type="password" name="repeat_password" id="repeat_password"/>
        </div>

        <button type="submit">Go</button>
    </form>

    <div class="login-links">
        <a href="<?= \app\core\Route::url('auth', 'signup') ?>">Register</a>
        <a href="<?= \app\core\Route::url('auth', 'forgot') ?>">Forgot password</a>
    </div>
</div>