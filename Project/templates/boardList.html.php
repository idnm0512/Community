<h2>BOARD LIST</h2>

<?php if (!empty($boards)) : ?>
    <p><?= $totalBoard ?>개의 게시글이 있습니다.</p>
    <?php foreach ($boards as $board) : ?>
        <ul>
            <li>Title: <?= htmlspecialchars($board -> title) ?></li>
            <li>Contents: <?= htmlspecialchars($board -> contents) ?></li>
            <li>InsertDate: <?= $board -> insert_date ?></li>
            <li>UpdateDate: <?= $board -> update_date ?></li>
            <li>Name: <?= htmlspecialchars($board -> getUser() -> name) ?></li>
            <li>Email: <?= htmlspecialchars($board -> getUser() -> email) ?></li>
            <?php if ($user -> id == $board -> userId) : ?>
                <li><a href="/board/edit?id=<?= $board -> id ?>">수정</a></li>
                <li>
                    <form action="/board/delete" method="post">
                        <input type="hidden" name="id" value="<?= $board -> id ?>">
                        <input type="submit" value="삭제">
                    </form>
                </li>
            <?php endif; ?>
        </ul>
    <?php endforeach; ?>
<?php else : ?>
    <p>게시글이 없습니다.</p>
<?php endif; ?>

<?php if (!empty($_SESSION['userEmail'])) : ?>
    <p><a href="/board/edit">BOARD EDIT</a></p>
<?php endif; ?>

<p><a href="/">HOME</a></p>