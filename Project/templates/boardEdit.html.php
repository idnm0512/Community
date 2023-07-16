<h2>BOARD EDIT</h2>

<?php if (!empty($errors)) : ?>
    <p>아래 내용을 확인해주세요.</p>

    <ul>
        <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (empty($board -> id) || $user -> id == $board -> userId) : ?>
    <form action="" method="post">
        <input type="hidden" name="board[id]" value="<?= $board -> id ?? '' ?>">

        <label for="title">Title:</label>
        <input type="text" id="title" name="board[title]" value="<?= $board -> title ?? '' ?>"><br>

        <label for="contents">Contents:</label>
        <textarea id="contents" name="board[contents]" rows="3" cols="40"><?= $board -> contents ?? '' ?></textarea><br>
        
        <input type="submit" value="WRITE">
    </form>
<?php else : ?>
    <p>자신의 글만 수정할 수 있습니다.</p>
<?php endif; ?>

<p><a href="/board/list">BOARD LIST</a></p>