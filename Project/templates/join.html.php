<h2>JOIN</h2>

<?php if (!empty($errors)) : ?>
    <p>아래 내용을 확인해주세요.</p>

    <ul>
        <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="user[name]" value="<?= $user['name'] ?? '' ?>"><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="user[email]" value="<?= $user['email'] ?? '' ?>"><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="user[password]" value="<?= $user['password'] ?? '' ?>"><br>
    
    <input type="submit" value="JOIN">
</form>

<p><a href="/">HOME</a></p>