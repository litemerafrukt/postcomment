<?php

namespace litemerafrukt\Database;

/**
 * Raw database connection and querier
 */
class Database
{
    private $pdo;

    /**
     * Connect to db
     */
    public function __construct($dns)
    {
        try {
            $this->pdo = new \PDO($dns);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            // Rethrow to hide connection details, through the original
            // exception to view all connection details.
            // throw $e;
            throw new \PDOException("Could not connect to database.");
        }
    }

    /**
     * Retrieve pdo. For testing.
     *
     * @return \PDO
     */
    public function pdo()
    {
        return $this->pdo;
    }

    /**
     * Execute query and return the PDOStatement
     *
     * @param string
     * @param array
     *
     * @return \PDOStatement
     */
    public function query($sql, $params = [])
    {
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($params);
        } catch (\PDOException $exception) {
            throw new \PDOException("Error in database query execution.");
        }

        return $statement;
    }
}
