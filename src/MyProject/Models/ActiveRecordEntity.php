<?php

namespace MyProject\Models;

use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $createdAt;

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);

        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    /**
     * @return static[]
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();

        return $db->query(
            'SELECT * FROM `' . static::getTableName() . '`;',
            [],
            static::class);
    }

    abstract protected static function getTableName(): string;

    public static function getById(int $id): static|null
    {
        $db = Db::getInstance();

        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id = :id;',
            [':id' => $id],
            static::class
        );

        return $entities ? $entities[0] : null;
    }

    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );

        if ($result === []){
            return null;
        }

        return $result[0];

    }

    public static function findAllByColumn(string $columnName, $value): null|array
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` = :value;',
            [':value' => $value],
            static::class
        );

        if ($result === []){
            return null;
        }

        return $result;

    }

    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();

        if (isset($this->id)) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    private function insert(array $mappedProperties)
    {
        $mappedProperties = array_filter($mappedProperties, function ($value) {
            return $value !== null;
        });

        $columns = [];
        $paramsNames = [];
        $params2values = [];
        foreach ($mappedProperties as $columnName => $value) {
            $columns[] = '`' . $columnName . '`'; // `name`
            $paramName = ':' . $columnName; // :name
            $paramsNames[] = $paramName;
            $params2values[$paramName] = $value; // :name => Новое название статьи
        }

        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);

        $this->id = $db->getLastInsertId();

        $this->refreshDataAfterNewRowInDb();
    }


    public function delete(): void
    {
        // DELETE FROM `articles` WHERE id = :id
        $sql = 'DELETE FROM `' . static::getTableName() . '` WHERE id = :id;';

        $db = Db::getInstance();
        $db->query($sql, [':id' => $this->id], static::class);

        $this->id = null;
    }


    private function update(array $mappedProperties)
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;

        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
        }

        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;

        $db = Db::getInstance();

        $db->query($sql, $params2values, static::class);
    }


    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    /**
     * takes string in camelCase like "authorId" and returns string
     * in snake_case like "author_id"
     * @param string $source
     * @return string
     *
     */
    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }


    private function refreshDataAfterNewRowInDb(): void
    {
        $dbObjArr = static::getById($this->id);

        foreach ($dbObjArr as $property => $value) {
            $this->$property = $value;
        }
    }
}