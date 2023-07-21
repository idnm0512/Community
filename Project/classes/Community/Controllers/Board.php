<?php
    namespace Community\Controllers;

use Common\Authentication;
use Common\DatabaseTable;

    class Board {
        public $commentTable;
        private $boardTable;
        private $authentication;

        public function __construct(DatabaseTable $boardTable, DatabaseTable $commentTable, Authentication $authentication) {
            $this -> boardTable = $boardTable;
            $this -> commentTable = $commentTable;
            $this -> authentication = $authentication;
        }

        public function boardList() {
            $boards = $this -> boardTable -> findAll();

            $totalBoard = $this -> boardTable -> total();

            $user = $this -> authentication -> getUser();

            $comments = $this -> commentTable -> findAll();

            return [
                'template' => 'boardList.html.php',
                'title' => 'BOARD LIST',
                'variables' => [
                    'totalBoard' => $totalBoard,
                    'boards' => $boards,
                    'user' => $user,
                    'comments' => $comments
                ]
            ];
        }

        public function boardEditForm() {
            $user = $this -> authentication -> getUser();

            if (isset($_GET['id'])) {
                $board = $this -> boardTable -> findById($_GET['id']);
            }

            return [
                'template' => 'boardEdit.html.php',
                'title' => 'BOARD EDIT',
                'variables' => [
                    'user' => $user,
                    'board' => $board ?? null
                ]
            ];
        }

        public function saveBoard() {
            $user = $this -> authentication -> getUser();

            $board = $_POST['board'];

            if (!empty($board['id'])) {
                $board['update_date'] = new \DateTime();
            } else {
                $board['insert_date'] = new \DateTime();
                $board['update_date'] = new \DateTime();
            }

            $boardEntity = $user -> addBoard($board);

            header('location: /board/list');
        }

        public function deleteBoard() {
            $user = $this -> authentication -> getUser();

            $board = $this -> boardTable -> findById($_POST['id']);

            if ($user -> id != $board -> userId) {
                return;
            }

            $this -> boardTable -> delete($_POST['id']);

            header('location: /board/list');
        }
    }