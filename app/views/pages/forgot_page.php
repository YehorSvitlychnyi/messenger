<a href="<?= \app\core\Route::url('auth','signin')?>" class="header-navigation">Go to login page</a>
<h1>Forgot password: "Name your favorite film"</h1>
<div class="errors-list">
    <?php include_once  '../app/views/errors.php'?>
</div>
<form method="post" action="<?= $action ?>">
    <label for="login">Your login:</label>
    <input type="text" name="login" id="login" placeholder="Your login" value="<?= \app\core\Validation::getOld()['login'] ?? '' ?>" autofocus>

    <label for="secret_answer">Secret answer:</label>
    <input type="text" name="secret_answer" id="secret_answer" placeholder="Secret answer">

    <button type="submit">Submit</button>
</form>