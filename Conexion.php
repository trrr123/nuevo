<?php 

class Conexion {
    protected $db;
    
    // Configuración para InfinityFree
    private $driver = "mysql";
    private $host = "sql100.infinityfree.com";
    private $dbname = "if0_40450257_XXX"; 
    private $usuario = "if0_40450257";
    private $password = "3104531285Tt-";
    private $charset = "utf8mb4";

    public function __construct() {
        try {
            $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $this->db = new PDO($dsn, $this->usuario, $this->password, $options);
            
        } catch (PDOException $e) {
            // En producción, no mostrar detalles del error
            die("Error de conexión a la base de datos. Por favor, contacta al administrador.");
        }
    }
}

?>