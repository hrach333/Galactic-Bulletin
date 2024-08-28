<?php

namespace Core;
use PDO;
abstract class Model {
    protected $db;
    protected $table;
    protected $query;
    protected $params = [];


    public function __construct() {
        $this->db = (new Database())->connect();
    }

    /***
     * Метод выполняет запрос для получения одного записи по id
     * @param $id
     * @return array
     */
    public function find($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Получаем все записи из таблицы
     * @return array|false
     */
    public function all() {
        $sql = "SELECT * FROM " . $this->table;
        $statement = $this->db->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Создание нового записи в таблицу
     * @param $data
     * @return bool
     */
    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO " . $this->table . " ($columns) VALUES ($placeholders)";
        $statement = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        return $statement->execute();
    }

    /**
     * Метод обновляет запись в таблице
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data) {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=:' . $key . ', ';
        }
        $fields = rtrim($fields, ', ');

        $sql = "UPDATE " . $this->table . " SET $fields WHERE id = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id);

        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        return $statement->execute();
    }

    /**
     * Удаление данных из таблицы
     * @param $id
     * @return bool
     */
    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

    public function query() {
        $this->query = "SELECT * FROM {$this->table}";
        return $this;
    }

    //Методы where, join, orderBy предназначены для составление конструкцию запросов
    public function where($column, $operator, $value) {
        $this->query .= " WHERE {$column} {$operator} :{$column}";
        $this->params[":{$column}"] = $value;
        return $this;
    }

    public function join($table, $firstColumn, $operator, $secondColumn) {
        $this->query .= " JOIN {$table} ON {$firstColumn} {$operator} {$secondColumn}";
        return $this;
    }

    public function orderBy($column, $direction = 'ASC') {
        $this->query .= " ORDER BY {$column} {$direction}";
        return $this;
    }
    public function limit($limit) {
        $this->query .= " LIMIT {$limit} ";
        return $this;
    }

    public function offset($offset) {
        $this->query .= " OFFSET {$offset} ";
        return $this;
    }

    public function count()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM {$this->table}");
        return $stmt->fetchColumn();
    }
    public function execute() {
        $statement = $this->db->prepare($this->query);
        foreach ($this->params as $param => $value) {
            $statement->bindValue($param, $value);
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}