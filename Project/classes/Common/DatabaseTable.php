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

        public function total() {
            $query = 'SELECT COUNT(*) FROM `' . $this -> table . '`';

            $result = $this -> query($query);

            $row = $result -> fetch();

            return $row[0];
        }

        public function dateProcess($fields) {
            foreach ($fields as $key => $value) {
                if ($value instanceof \DateTime) {
                    $fields[$key] = $value -> format('Y-m-d H:i:s');
                }
            }

            return $fields;
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

        public function save($record) {
            $entity = new $this -> className(...$this -> constructorArgs);

            try {
                if ($record[$this -> primaryKey] == '') {
                    $record[$this -> primaryKey] = null;
                }

                $lastInsertId = $this -> insert($record);

                $entity -> {$this -> primaryKey} = $lastInsertId;
            } catch(\PDOException $e) {
                $this -> update($record);
            }

            foreach ($record as $key => $value) {
                if (!empty($value)) {
                    $entity -> $key = $value;
                }
            }

            return $entity;
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

            $fields = $this -> dateProcess($fields);

            $this -> query($query, $fields);

            return $this -> pdo -> lastInsertId();
        }

        public function update($fields) {
            $query = 'UPDATE `' . $this -> table . '` SET ';

            foreach ($fields as $key => $value) {
                $query .= '`' . $key . '` = :' . $key . ',';
            }

            $query = rtrim($query, ',');
            $query .= ' WHERE `' . $this -> primaryKey . '` = :primaryKey';

            $fields['primaryKey'] = $fields['id'];

            $fields = $this -> dateProcess($fields);

            $this -> query($query, $fields);
        }

        public function delete($id) {
            $query = 'DELETE FROM `' . $this -> table . '` WHERE `' . $this -> primaryKey . '` = :id';

            $parameters = [
                ':id' => $id
            ];

            $this -> query($query, $parameters);
        }
    }