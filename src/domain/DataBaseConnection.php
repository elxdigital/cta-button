<?php

namespace Elxdigital\CtaButton\Domain;

use PDO;
use PDOException;

class DataBaseConnection
{
    private PDO $connection;
    private string $host;
    private string $dbname;
    private string $user;
    private string $password;
    private int $port;

    public function __construct() 
    {
        $this->host = \CONF_DB_HOST ?? 'localhost';
        $this->dbname = \CONF_DB_NAME ?? '';
        $this->user = \CONF_DB_USER ?? 'root';
        $this->password = \CONF_DB_PASS ?? '';
        $this->port = \CONF_DB_PORT ?? 3306;
    }

    /**
     * ######################
     * ### PUBLIC METHODS ###
     * ######################
     */

    public function connect(?bool $createTable = true): void
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4",
                $this->user,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );

            if ($createTable) {
                $this->createTableIfNotExists();
            }
        } catch (PDOException $e) {
            throw new \RuntimeException("Erro ao conectar no banco: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * #######################
     * ### PRIVATE METHODS ###
     * #######################
     */

    private function createTableIfNotExists()
    {
        if (!isset($this->connection)) {
            throw new \RuntimeException("Conexão com banco de dados não iniciada.");
        }

        $sql = "
            CREATE TABLE IF NOT EXISTS cta_button (
              id INT AUTO_INCREMENT PRIMARY KEY,
              tipo_cta ENUM('lead', 'whatsapp', 'externo') NOT NULL,
              btn_identificador VARCHAR(255) NOT NULL,
              btn_titulo VARCHAR(255) NOT NULL,
              form_lead TEXT DEFAULT NULL,
              contato_wpp VARCHAR(20) DEFAULT NULL,
              link_redir TEXT DEFAULT NULL,
              cliques INT UNSIGNED NOT NULL DEFAULT 0,
              data_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              data_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        ";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute();
    }
}
