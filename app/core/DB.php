<?php
namespace Application\Core;

use PDO;
use RuntimeException;

class DB {
    const HOST = 'mysql:dbname=test;host=db';
    const USERNAME = 'root';
    const PASSWORD = 'qwerty';
    private $db;

    /**
     * Производит подключение к базе данных
     */
    public function __construct()
    {
        $db = new PDO(self::HOST, self::USERNAME, self::PASSWORD);
        $this->db = $db;
    }

    /**
     * Метод делает запрос к БД и возвращает столбцы $fields из таблицы $table,
     * учитывая условия массива $whereConditions.
     *
     * @param string $table
     * @param array|string $fields default = '*'
     * @param array $whereConditions default = [], associative array: [field => value, ...]
     * @return array
     */
    public function select($table, $fields = '*', $whereConditions = [])
    {
        $fieldsStr = is_array($fields) ? implode(', ', $fields) : $fields;
        $query = "SELECT $fieldsStr FROM $table";
        if (count($whereConditions) > 0) {
            $query .= " WHERE ";
            $fields = array_keys($whereConditions);
            foreach ($fields as $field) {
                $query .= "$field = :$field";
                # если это не последний ключ - добавляем AND
                if (array_search($field, $fields) + 1 < count($fields)) {
                    $query .= " AND ";
                }
            }
        }
        return $this->prepareAndExecuteQuery($query, $whereConditions);
    }

    /**
     * Метод вставляет запись с данными $data в таблицу $table.
     *
     * @param string $table
     * @param array $data associative array: [field => value, ...]
     * @return void
     */
    public function insert($table, $data)
    {
        if (!is_array($data) || count($data) == 0) {
            throw new RuntimeException('Data to insert must not be empty');
        }
        
        $placeholders = '';
        $fields = array_keys($data);
        $fieldsStr = implode(', ',$fields);
        foreach ($fields as $field) {
            $placeholders .= ':' . $field;
            # если это не последний ключ - добавляем запятую
            if (array_search($field, $fields) + 1 < count($fields)) {
                $placeholders .= ', ';
            }
        }
        
        $query = "INSERT INTO $table ($fieldsStr) VALUES ($placeholders)";

        return $this->prepareAndExecuteQuery($query, $data);
    }

    /**
     * Обновляет запись (или записи) в таблице $table данными из $data, учитывая условия $whereConditions
     *
     * @param string $table
     * @param array|string $data associative array: [field => value, ...]
     * @param array $whereConditions default = [], associative array: [field => value, ...]
     * @return bool
     */
    public function update($table, $data, $whereConditions = [])
    {
        if (!is_array($data) || count($data) == 0) {
            throw new RuntimeException('Data to update must not be empty');
        }

        $query = "UPDATE $table SET ";

        $mappedDataForSetPartOfQuery = [];
        foreach ($data as $key => $value) {
            $mappedDataForSetPartOfQuery["set_$key"] = $value;
        }

        $mappedDataForWherePartOfQuery = [];
        if (count($whereConditions) > 0) {
            foreach ($whereConditions as $key => $value) {
                $mappedDataForWherePartOfQuery["where_$key"] = $value;
            }
        }

        $dataFields = array_keys($data);
        foreach ($dataFields as $field) {
            $query .= "$field = :set_$field";
            if (array_search($field, $dataFields) + 1 < count($dataFields)) {
                $query .= ", ";
            }
        }

        if (count($whereConditions) > 0) {
            $query .= " WHERE ";
            $whereFields = array_keys($whereConditions);
            foreach ($whereFields as $field) {
                $query .= "$field = :where_$field";
                if (array_search($field, $whereFields) + 1 < count($whereFields)) {
                    $query .= " AND ";
                }
            }
        }

        $mergedDataToBind = array_merge($mappedDataForSetPartOfQuery, $mappedDataForWherePartOfQuery);
        $this->prepareAndExecuteQuery($query, $mergedDataToBind);
    }
    
    /**
     * Подготавливает и выполняет запрос, используя данные из $data
     *
     * @param string $query
     * @param array $data
     * @return void
     */
    private function prepareAndExecuteQuery($query, $data = [])
    {
        $statement = $this->db->prepare($query);
        foreach ($data as $field => $value) {
            $statement->bindValue(":$field", $value);
        }
        
        if (!$statement->execute()) {
            throw new RuntimeException("Error executing statement: $query");
        }
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}