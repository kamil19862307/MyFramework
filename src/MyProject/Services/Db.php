<?php

namespace MyProject\Services;

class Db
{
    /** @var \PDO */
    private $pdo;

    public function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../db_settings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['db_name'],
            $dbOptions['user'],
            $dbOptions['password']
        );

        $this->pdo->exec('SET NAMES UTF8');
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);

        $result = $sth->execute($params);

        if ($result === false)
            return null;

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }
}