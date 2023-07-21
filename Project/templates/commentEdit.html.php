<h2>COMMENT EDIT</h2>

<?php if (!empty($errors)) : ?>
    <p>아래 내용을 확인해주세요.</p>

    <ul>
        <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (empty($comment -> id) || $user -> id == $comment -> user_id) : ?>
    <form action="" method="post">
        <input type="hidden" name="comment[board_id]" value="<?= $board_id ?>">

        <label for="contents">Contents:</label>
        <textarea id="contents" name="comment[contents]" rows="3" cols="40"><?= $comment -> contents ?? '' ?></textarea><br>
        
        <input type="submit" value="WRITE">
    </form>
<?php else : ?>
    <p>자신의 글만 수정할 수 있습니다.</p>
<?php endif; ?>

<p><a href="/board/list">BOARD LIST</a></p>