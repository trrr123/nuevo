<?php 

class Conexion {
    protected $db;
    
    private $driver = "mysql";
    private $host = "localhost";
    private $dbname = "notas";
    private $usuario = "root";
    private $password = "";
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
            
            // IMPORTANTE: Retornar la conexión para que funcione con parent::__construct()
            return $this->db;
            
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

?>
