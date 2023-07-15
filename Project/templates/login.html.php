<h2>LOGIN</h2>

<?php if(isset($error)) : ?>
    <p>아래 내용을 확인해주세요.</p>

    <ul>
        <li><?= $error ?></li>
    </ul>
<?php endif; ?>

<form action="" method="post">
    <label for="email">Email:</label>
    <input type="text" id="email" name="user[email]"><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="user[password]"><br>

    <input type="submit" value="LOGIN">
</form>

<p><a href="/">HOME</a></p>