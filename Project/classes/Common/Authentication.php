<?php
    namespace Common;

    class Authentication { // 인증
        private $userTable;
        private $userIdColumn;
        private $userPwdColumn;

        public function __construct(DatabaseTable $userTable, $userIdColumn, $userPwdColumn) {
            session_start();
            
            $this -> userTable = $userTable;
            $this -> userIdColumn = $userIdColumn;
            $this -> userPwdColumn = $userPwdColumn;
        }

        public function login($userId, $userPwd) {
            $user = $this -> userTable -> find($this -> userIdColumn, $userId);

            if (!empty($user) && password_verify($userPwd, $user[0] -> {$this -> userPwdColumn})) {
                session_regenerate_id();

                $_SESSION['userId'] = $userId;
                $_SESSION['userPwd'] = $user[0] -> {$this -> userPwdColumn};

                return true;
            } else {
                return false;
            }
        }
    }