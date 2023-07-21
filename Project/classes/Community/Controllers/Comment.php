<?php
    namespace Community\Controllers;

    use Common\Authentication;
    use Common\DatabaseTable;

    class Comment {
        public $commentTable;
        public $authentication;

        public function __construct(DatabaseTable $commentTable, Authentication $authentication) {
            $this -> commentTable = $commentTable;
            $this -> authentication = $authentication;
        }

        public function commentEditForm() {
            $user = $this -> authentication -> getUser();

            $board_id = $_GET['board_id'];

            if (isset($_GET['id'])) {
                $comment = $this -> commentTable -> findById($_GET['id']);
            }

            return [
                'template' => 'commentEdit.html.php',
                'title' => 'COMMENT EDIT',
                'variables' => [
                    'user' => $user,
                    'comment' => $comment ?? null,
                    'board_id' => $board_id
                ]
            ];
        }
        
        public function saveComment() {
            $user = $this -> authentication -> getUser();

            $comment = $_POST['comment'];

            $commentEntity = $user -> addComment($comment);

            header('location: /board/list');
        }
    }