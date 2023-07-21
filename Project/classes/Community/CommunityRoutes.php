<?php
    namespace Community;

    use Common\Routes;
    use Common\DatabaseTable;
    use Common\Authentication;
    use Community\Controllers\Home;
    use Community\Controllers\Join;
    use Community\Controllers\Login;
    use Community\Controllers\Board;
    use Community\Controllers\Comment;

    class CommunityRoutes implements Routes {
        private $userTable;
        private $boardTable;
        private $commentTable;
        private $authentication;
        
        public function __construct() {
            include __DIR__ . '/../../includes/DatabaseConnection.php';

            $this -> userTable = new DatabaseTable($pdo, 'user', 'id', 'Community\Entity\User', [&$this -> boardTable,
                                                                                                 &$this -> commentTable]);
            $this -> boardTable = new DatabaseTable($pdo, 'board', 'id', 'Community\Entity\Board', [&$this -> userTable]);
            $this -> commentTable = new DatabaseTable($pdo, 'comment', 'id', 'Community\Entity\Comment', [&$this -> userTable]);
            $this -> authentication = new Authentication($this -> userTable, 'email', 'password');
        }

        public function getRoutes(): Array {
            $homeController = new Home();
            $joinController = new Join($this -> userTable);
            $loginController = new Login($this -> authentication);
            $boardController = new Board($this -> boardTable, $this -> commentTable, $this -> authentication);
            $commentController = new Comment($this -> commentTable, $this -> authentication);

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
                'user/login/error' => [
                    'GET' => [
                        'controller' => $loginController,
                        'action' => 'loginError'
                    ]
                ],
                'user/logout' => [
                    'GET' => [
                        'controller' => $loginController,
                        'action' => 'logout'
                    ]
                ],
                'board/list' => [
                    'GET' => [
                        'controller' => $boardController,
                        'action' => 'boardList'
                    ]
                ],
                'board/edit' => [
                    'GET' => [
                        'controller' => $boardController,
                        'action' => 'boardEditForm'
                    ],
                    'POST' => [
                        'controller' => $boardController,
                        'action' => 'saveBoard'
                    ],
                    'login' => true
                ],
                'board/delete' => [
                    'POST' => [
                        'controller' => $boardController,
                        'action' => 'deleteBoard'
                    ],
                    'login' => true
                ],
                'comment/edit' => [
                    'POST' => [
                        'controller' => $commentController,
                        'action' => 'saveComment'
                    ],
                    'GET' => [
                        'controller' => $commentController,
                        'action' => 'commentEditForm'
                    ]
                ]
            ];

            return $routes;
        }

        public function getAuthentication(): Authentication {
            return $this -> authentication;
        }
    }