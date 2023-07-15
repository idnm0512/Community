<?php
    namespace Community\Controllers;

    use Common\Authentication;

    class Login {
        private $authentication;
        
        public function __construct(Authentication $authentication) {
            $this -> authentication = $authentication;
        }

        public function loginForm() {
            return [
                'template' => 'login.html.php',
                'title' => 'LOGIN'
            ];
        }

        public function loginSuccessForm() {
            return [
                'template' => 'loginSuccess.html.php',
                'title' => 'LOGIN SUCCESS'
            ];
        }

        public function loginProcess() {
            $user = $_POST['user'];

            if ($this -> authentication -> login($user['email'], $user['password'])) {
                header('location: /user/login/success');
            } else {
                return [
                    'template' => 'login.html.php',
                    'title' => 'LOGIN',
                    'variables' => [
                        'error' => '이메일 주소/패스워드가 유효하지 않습니다.'
                    ]
                ];
            }
        }

        public function logout() {
            session_unset();

            header('location: /');
        }
    }