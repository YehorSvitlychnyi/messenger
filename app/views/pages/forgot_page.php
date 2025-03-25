<h1>Forgot password: "Name your teacher from the Level Up course?"</h1>
<div class="errors-list">
    <?php include_once  '../app/views/errors.php'?>
</div>
<form method="post" action="<?= $action ?>">
    <label for="login">Your login:</label>
    <input type="text" name="login" id="login" placeholder="Your login" autofocus>

    <label for="answer">Secret answer:</label>
    <input type="text" name="answer" id="answer" placeholder="Secret answer">

    <button type="submit">Submit</button>
</form>