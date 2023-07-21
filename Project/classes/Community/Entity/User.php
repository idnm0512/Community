<?php
    namespace Community\Entity;

    use Common\DatabaseTable;

    class User {
        public $id;
        public $name;
        public $email;
        public $password;
        public $boardTable;
        public $commentTable;

        public function __construct(DatabaseTable $boardTable, DatabaseTable $commentTable) {
            $this -> boardTable = $boardTable;
            $this -> commentTable = $commentTable;
        }

        public function addBoard($board) {
            $board['userId'] = $this -> id;

            return $this -> boardTable -> save($board);
        }

        public function addComment($comment) {
            $comment['user_id'] = $this -> id;

            return $this -> commentTable -> save($comment);
        }
    }