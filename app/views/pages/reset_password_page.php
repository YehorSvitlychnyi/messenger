<div class="reset-container">
    <h1 class="login-h1">Reset password</h1>
    <form action="<?= $action ?>" method="post">
        <div class="form-group">
            <label for="password">New password</label>
            <input type="password" name="password" id="password"/>
        </div>
        <div class="form-group">
            <label for="repeat_password">Repeat password</label>
            <input type="password" name="repeat_password" id="repeat_password"/>
        </div>
        <button type="submit">Go</button>
    </form>
</div>