<?php
    namespace Community\Controllers;

    use Common\DatabaseTable;

    class Join {
        private $userTable;
        
        public function __construct(DatabaseTable $userTable) {
            $this -> userTable = $userTable;
        }

        public function joinForm() {
            return [
                'template' => 'join.html.php',
                'title' => 'JOIN'
            ];
        }

        public function joinSuccessForm() {
            return [
                'template' => 'joinSuccess.html.php',
                'title' => 'JOIN SUCCESS'
            ];
        }

        public function saveUser() {
            $user = $_POST['user'];

            $this -> userTable -> insert($user);

            header('location: /user/join/success');
        }
    }