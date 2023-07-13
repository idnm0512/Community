<?php
    namespace Common;

    class DatabaseTable {
        private $pdo;
        private $table;
        private $primaryKey;

        public function __construct(\PDO $pdo, string $table, string $primaryKey) {
            $this -> pdo = $pdo;
            $this -> table = $table;
            $this -> primaryKey = $primaryKey;
        }

        public function query($sql, $parameters = []) {
            $query = $this -> pdo -> prepare($sql);

            $query -> execute($parameters);

            return $query;
        }

        public function insert($fields) {
            $query = 'INSERT INTO `' . $this -> table . '` (';

            foreach ($fields as $key => $value) {
                $query .= '`' . $key . '`,';
            }

            $query = rtrim($query, ',');
            $query .= ') VALUES (';

            foreach ($fields as $key => $value) {
                $query .= ':' . $key . ',';
            }

            $query = rtrim($query, ',');
            $query .= ')';

            $this -> query($query, $fields);

            return $this -> pdo -> lastInsertId();
        }
    }