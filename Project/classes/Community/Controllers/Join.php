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

            $valid = true;
            $errors = [];

            if (empty($user['name'])) {
                $valid = false;
                $errors[] = '이름을 입력해야 합니다.';
            }

            if (empty($user['password'])) {
                $valid = false;
                $errors[] = '패스워드를 입력해야 합니다.';
            }

            if (empty($user['email'])) {
                $valid = false;
                $errors[] = '이메일을 입력해야 합니다.';
            } else if (filter_var($user['email'], FILTER_VALIDATE_EMAIL) == false) {
                $valid = false;
                $errors[] = '유효하지 않은 이메일 주소입니다.';
            } else {
                $user['email'] = strtolower($user['email']);

                if (count($this -> userTable -> find('email', $user['email'])) > 0) {
                    $valid = false;
                    $errors[] = '이미 가입된 이메일 주소입니다.';
                }
            }

            if ($valid == true) {
                $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

                $this -> userTable -> save($user);

                header('location: /user/join/success');
            } else {
                return [
                    'template' => 'join.html.php',
                    'title' => 'JOIN',
                    'variables' => [
                        'errors' => $errors,
                        'user' => $user
                    ]
                ];
            }
        }
    }