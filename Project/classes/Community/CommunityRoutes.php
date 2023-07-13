<?php
    namespace Community;

    use Common\Routes;
    use Common\DatabaseTable;
    use Community\Controllers\Home;
    use Community\Controllers\Join;

    class CommunityRoutes implements Routes {
        private $userTable;
        
        public function __construct() {
            include __DIR__ . '/../../includes/DatabaseConnetion.php';

            $this -> userTable = new DatabaseTable($pdo, 'user', 'id');
        }

        public function getRoutes() {
            $homeController = new Home();
            $joinController = new Join($this -> userTable);

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
                ]
            ];

            return $routes;
        }
    }