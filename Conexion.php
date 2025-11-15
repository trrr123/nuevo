<?php 
// config/Conexion.php

class Conexion {
    private static $instance = null;
    protected $db;
    
    private $driver = "mysql";
    private $host = "localhost";
    private $dbname = "sistema_notas_escolar";
    private $usuario = "root";
    private $password = "";
    private $charset = "utf8mb4";

    private function __construct() {
        try {
            $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $this->db = new PDO($dsn, $this->usuario, $this->password, $options);
            
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Singleton pattern para evitar múltiples conexiones
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->db;
    }

    // Prevenir clonación
    private function __clone() {}
    
    // Prevenir unserialize
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}