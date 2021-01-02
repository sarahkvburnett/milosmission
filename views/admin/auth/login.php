<div id="admin-login" class="w-50 bg-white mx-auto my-5 p-5">
    <h1 class="text-center mb-5">Login</h1>
    <form action="/admin/login" method="post" class="w-50 mx-auto">
        <?php include __DIR__ . "/../../_errors.php" ?>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
        <div class="text-center">
            <input type="submit" value="Login" class="btn btn-primary">
        </div>
    </form>
</div>
<!-- TODO validation for this -->
