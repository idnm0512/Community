<?php
    namespace Community\Entity;

    use Common\DatabaseTable;

    class User {
        public $id;
        public $name;
        public $email;
        public $password;
        public $boardTable;

        public function __construct(DatabaseTable $boardTable) {
            $this -> boardTable = $boardTable;
        }

        public function addBoard($board) {
            $board['userId'] = $this -> id;

            return $this -> boardTable -> save($board);
        }
    }