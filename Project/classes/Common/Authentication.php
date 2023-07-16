<?php
    namespace Common;

    class Authentication { // 인증
        private $userTable;
        private $userEmailColumn;
        private $userPwdColumn;

        public function __construct(DatabaseTable $userTable, $userEmailColumn, $userPwdColumn) {
            session_start();
            
            $this -> userTable = $userTable;
            $this -> userEmailColumn = $userEmailColumn;
            $this -> userPwdColumn = $userPwdColumn;
        }

        public function login($userEmail, $userPwd) {
            $user = $this -> userTable -> find($this -> userEmailColumn, $userEmail);

            if (!empty($user) && password_verify($userPwd, $user[0] -> {$this -> userPwdColumn})) {
                session_regenerate_id();

                $_SESSION['userEmail'] = $user[0] -> {$this -> userEmailColumn};
                $_SESSION['userPwd'] = $user[0] -> {$this -> userPwdColumn};

                return true;
            } else {
                return false;
            }
        }

        public function loginCheck() {
            if (empty($_SESSION['userEmail'])) {
                return false;
            }

            $user = $this -> userTable -> find($this -> userEmailColumn, strtolower($_SESSION['userEmail']));

            if (!empty($user) && $user[0] -> {$this -> userPwdColumn} === $_SESSION['userPwd']) {
                return true;
            } else {
                return false;
            }
        }

        public function getUser() {
            if ($this -> loginCheck()) {
                $user = $this -> userTable -> find($this -> userEmailColumn, strtolower($_SESSION['userEmail']));
                
                return $user[0];
            } else {
                return false;
            }
        }
    }