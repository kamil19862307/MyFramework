<?php

namespace MyProject\Services;

class Db
{
    /** @var \PDO */
    private \PDO $pdo;

    private static ?Db $instance;

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../db_settings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['db_name'],
            $dbOptions['user'],
            $dbOptions['password']
        );

        $this->pdo->exec('SET NAMES UTF8');
    }

    public static function getInstance (): self
    {
        if (!isset(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);

        $result = $sth->execute($params);

        if ($result === false)
            return null;

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}