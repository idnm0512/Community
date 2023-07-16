<?php
    namespace Community\Entity;

    use Common\DatabaseTable;

    class Board {
        public $id;
        public $title;
        public $contents;
        public $insert_date;
        public $update_date;
        public $userId;
        private $userTable;
        private $user;

        public function __construct(DatabaseTable $userTable) {
            $this -> userTable = $userTable;
        }

        public function getUser() {
            if (empty($this -> user)) {
                $this -> user = $this -> userTable -> findById($this -> userId);
            }

            return $this -> user;
        }
    }