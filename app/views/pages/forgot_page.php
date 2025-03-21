<h1>Forgot password: "Name your teacher from the Level Up course."</h1>
<form method="post" action="/auth/forgot">
    <label for="your_login">Your login:</label>
    <input type="text" name="your_login" id="your_login" placeholder="Your login" autofocus>

    <label for="secret_answer">Secret answer:</label>
    <input type="text" name="secret_answer" id="secret_answer" placeholder="Secret answer">

    <button type="submit">Submit</button>

    <a href="<?= \app\core\Route::url('auth', 'resetpassword') ?>">Reset password</a>
    <a href="<?= \app\core\Route::url('auth', 'signup') ?>">Register</a>
</form>