<?php
    namespace Common;

    class DatabaseTable {
        private $pdo;
        private $table;
        private $primaryKey;
        private $className;
        private $constructorArgs;

        public function __construct(\PDO $pdo, string $table, string $primaryKey,
                                        string $className = '\stdClass', array $constructorArgs = []) {
            $this -> pdo = $pdo;
            $this -> table = $table;
            $this -> primaryKey = $primaryKey;
            $this -> className = $className;
            $this -> constructorArgs = $constructorArgs;
        }

        public function query($sql, $parameters = []) {
            $query = $this -> pdo -> prepare($sql);

            $query -> execute($parameters);

            return $query;
        }

        public function findAll() {
            $query = 'SELECT * FROM `' . $this -> table . '`';

            $result = $this -> query($query);

            return $result -> fetchAll(\PDO::FETCH_CLASS, $this -> className, $this -> constructorArgs);
        }

        public function find($column, $value) {
            $query = 'SELECT * FROM `' . $this -> table . '` WHERE `' . $column . '` = :value';

            $parameters = [
                ':value' => $value
            ];

            $result = $this -> query($query, $parameters);

            return $result -> fetchAll(\PDO::FETCH_CLASS, $this -> className, $this -> constructorArgs);
        }

        public function findById($value) {
            $query = 'SELECT * FROM `' . $this -> table . '` WHERE `' . $this -> primaryKey . '` = :value';

            $parameters = [
                ':value' => $value
            ];

            $result = $this -> query($query, $parameters);

            return $result -> fetchObject($this -> className, $this -> constructorArgs);
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