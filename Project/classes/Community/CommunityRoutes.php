<?php
    namespace Community;

    use Common\Routes;
    use Common\DatabaseTable;
    use Common\Authentication;
    use Community\Controllers\Home;
    use Community\Controllers\Join;
    use Community\Controllers\Login;

    class CommunityRoutes implements Routes {
        private $userTable;
        private $authentication;
        
        public function __construct() {
            include __DIR__ . '/../../includes/DatabaseConnection.php';

            $this -> userTable = new DatabaseTable($pdo, 'user', 'id', 'Community\Entity\User', [&$this -> userTable]);
            $this -> authentication = new Authentication($this -> userTable, 'email', 'password');
        }

        public function getRoutes() {
            $homeController = new Home();
            $joinController = new Join($this -> userTable);
            $loginController = new Login($this -> authentication);

            $routes = [
                '' => [
                    'GET' => [
                        'controller' => $homeController,
                        'action' => 'home'
                    ]
                ],
                'user/join' => [
                    'GET' => [
                        'controller' => $joinController,
                        'action' => 'joinForm'
                    ],
                    'POST' => [
                        'controller' => $joinController,
                        'action' => 'saveUser'
                    ]
                ],
                'user/join/success' => [
                    'GET' => [
                        'controller' => $joinController,
                        'action' => 'joinSuccessForm'
                    ]
                ],
                'user/login' => [
                    'GET' => [
                        'controller' => $loginController,
                        'action' => 'loginForm'
                    ],
                    'POST' => [
                        'controller' => $loginController,
                        'action' => 'loginProcess'
                    ]
                ],
                'user/login/success' => [
                    'GET' => [
                        'controller' => $loginController,
                        'action' => 'loginSuccessForm'
                    ]
                ],
                'user/logout' => [
                    'GET' => [
                        'controller' => $loginController,
                        'action' => 'logout'
                    ]
                ]
            ];

            return $routes;
        }
    }