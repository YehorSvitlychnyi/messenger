<div class="login-body">
    <h1 class="login-h1">Welcome to messenger</h1>
    <div class="errors-list">
        <?php include_once  '../app/views/errors.php'?>
    </div>

    <form action="<?= $action ?>" method="post" class="login-form" autocomplete="off">
        <label for="login">login</label>
        <input type="text" name="login" id="login" value="<?= \app\core\Validation::getOld()['login'] ?? '' ?>"/>
        <label for="pass">password</label>
        <input type="password" name="password" id="pass"/>
        <input type="submit" value="Go"/>
    </form>

    <div class="login-buttons">
        <div class="login-register-button">
            <a href="<?= \app\core\Route::url('auth','signup')?>">Register</a>
        </div>

        <div class="login-forgot-button">
            <a href="<?= \app\core\Route::url('auth','forgot')?>">Forgot password</a>
        </div>
    </div>

</div>