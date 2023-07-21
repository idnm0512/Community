<?php
    namespace Community\Entity;

    use Common\DatabaseTable;

    class Comment {
        public $id;
        public $user_id;
        public $board_id;
        public $contents;
        public $user;
        private $userTable;

        public function __construct(DatabaseTable $userTable) {
            $this -> userTable = $userTable;
            $this -> user = $this -> getUser();
        }

        public function getUser() {
            if (empty($this -> user)) {
                $this -> user = $this -> userTable -> findById($this -> user_id);
            }

            return $this -> user;
        }
    }