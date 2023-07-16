<h2>HOME</h2>

<?php if(isset($_SESSION['userEmail'])) : ?>
    <p><a href="/user/logout">LOGOUT</a></p>
<?php else : ?>
    <p><a href="/user/login">LOGIN</a></p>
    <p><a href="/user/join">JOIN</a></p>
<?php endif; ?>

<p><a href="/board/list">BOARD LIST</a></p>