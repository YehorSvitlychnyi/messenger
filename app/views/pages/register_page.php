<div class="register-body">
    <h1 class="h1">Register page</h1>
    <div class="errors-list">
        <?php include_once  '../app/views/errors.php'?>
    </div>
    <form action="<?= $action ?>" method="post" class="register-form">
        <div class="input">
            <label for="name">Name</label>
            <input type="text" name="name" id="name"/>
        </div>
        <div class="input">
            <label for="login">Login</label>
            <input type="text" name="login" id="login"/>
        </div>
        <div class="input">
            <label for="password">Password</label>
            <input type="password" name="password" id="password"/>
        </div>
        <div class="input">
            <label for="password_repeat">Repeat password</label>
            <input type="password" name="password_repeat" id="password_repeat"/>
        </div>
        <div class="input">
            <label for="secret_answer">Secret question</label>
            <input type="text" name="secret_answer" id="secret_answer"/>
        </div>
        <input type="submit" value="Go"/>
    </form>
</div>
