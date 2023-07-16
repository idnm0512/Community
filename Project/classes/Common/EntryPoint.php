<?php
    namespace Common;

    use Common\Routes;

    class EntryPoint {
        private $route;
        private $method;
        private $routes;
        
        public function __construct(string $route, string $method, Routes $routes) {
            $this -> route = $route;
            $this -> method = $method;
            $this -> routes = $routes;
            $this -> checkUrl();
        }

        public function checkUrl() {
            if ($this -> route !== strtolower($this -> route)) {
                http_response_code(301);
                header('location: ') . strtolower($this -> route);
            }
        }

        public function loadTemplate($templateName, $variables = []) {
            extract($variables);

            ob_start();

            include __DIR__ . '/../../templates/' . $templateName;

            return ob_get_clean();
        }

        public function run() {
            $routes = $this -> routes -> getRoutes();

            $authentication = $this -> routes -> getAuthentication();

            if (isset($routes[$this -> route]['login']) && $routes[$this -> route]['login'] && !$authentication -> loginCheck()) {
                header('location: /user/login/error');
            } else {
                $controller = $routes[$this -> route][$this -> method]['controller'];
                $action = $routes[$this -> route][$this -> method]['action'];
    
                $page = $controller -> $action();
    
                if (isset($page['variables'])) {
                    $output = $this -> loadTemplate($page['template'], $page['variables']);
                } else {
                    $output = $this -> loadTemplate($page['template']);
                }
    
                echo $this -> loadTemplate('layout.html.php', [
                    'title' => $page['title'],
                    'output' => $output
                ]);
            }
        }
    }