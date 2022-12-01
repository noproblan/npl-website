<?php

declare(strict_types=1);

namespace Npl\Infrastructure\Persistence;

use Aura\SqlQuery\QueryFactory;
use Exception;
use PDO;
use PDOStatement;

abstract class MariaDBRepository
{
    private PDO $pdo;

    public function __construct(protected QueryFactory $factory, string $dsn, ?string $username, ?string $password, ?array $options = null)
    {
        $this->pdo = new PDO(
            $dsn,
            $username,
            $password,
            $options
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    protected function getConnection(): PDO
    {
        return $this->pdo;
    }

    protected function execute(string $sql, array $parameters = null): false|PDOStatement
    {
        $statement = $this->pdo->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($parameters);

        return $statement;
    }

    /**
     * @throws Exception
     */
    protected function executeAtomically(callable $callable): mixed
    {
        $this->pdo->beginTransaction();

        try {
            $return = call_user_func(
                $callable,
                $this
            );
            $this->pdo->commit();

            return $return ?: true;
        } catch (Exception $exception) {
            $this->pdo->rollBack();
            throw $exception;
        }
    }
}
