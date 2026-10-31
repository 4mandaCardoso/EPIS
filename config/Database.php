<?php
// /config/Database.php

class Database {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $ssl_ca;
    public $conn;

    public function __construct() {
        // Na nuvem os valores vêm das variáveis de ambiente (Render).
        // Se elas não existirem, usa os valores do XAMPP local.
        $this->host     = getenv('DB_HOST') ?: 'localhost';
        $this->port     = getenv('DB_PORT') ?: '3306';
        $this->db_name  = getenv('DB_NAME') ?: 'epis';
        $this->username = getenv('DB_USER') ?: 'root';
        $password       = getenv('DB_PASSWORD');
        $this->password = ($password !== false) ? $password : '';
        $this->ssl_ca   = getenv('DB_SSL_CA') ?: '';
    }

    // Método para obter a ligação e devolver a conexão ativa
    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8";

            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            // Conexão SSL (obrigatória no Aiven): usa o certificado CA, se informado
            if ($this->ssl_ca !== '' && file_exists($this->ssl_ca)) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = $this->ssl_ca;
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
            }

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $exception) {
            echo "Erro na ligação à base de dados: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
