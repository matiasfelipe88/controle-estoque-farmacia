<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'farmacia_estoque');
<<<<<<< HEAD
define('DB_USER', 'root');
define('DB_PASS', 'root');
=======
define('DB_USER', 'Murilo'); // Seu usuário do MySQL
define('DB_PASS', 'root');     // Sua senha do MySQL
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        try {
            $this->conn = new PDO($dsn, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erro de Conexão com o Banco de Dados: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
