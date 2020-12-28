<h1>Login</h1>
<form action="/admin/login" method="post">
    <?php include __DIR__ . "/../../_errors.php" ?>
    <label for="email">Email</label>
    <input id="email" name="email" type="email" required>
    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>
    <input type="submit" value="Login">
</form>