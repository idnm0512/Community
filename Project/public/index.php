<?php
    use Common\EntryPoint;
    use Community\CommunityRoutes;

    try {
        include __DIR__ . '/../includes/Autoload.php';

        $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

        $entryPoint = new EntryPoint($route, $_SERVER['REQUEST_METHOD'], new CommunityRoutes());

        $entryPoint -> run();
    } catch (PDOException $e) {
        $title = 'Error';

        $output = 'Error'
            . '<br>내용: ' . $e -> getMessage()
            . '<br>위치: ' . $e -> getFile()
            . '<br>라인: ' . $e -> getLine();
        
        include __DIR__ . '/../templates/layout.html.php';
    }