<?php 

class Conexion {
    protected $db;
    
    private $driver = "mysql";
    private $host;
    private $dbname;
    private $usuario;
    private $password;
    private $charset = "utf8mb4";

    public function __construct() {
        try {
            // Detectar si estamos en Railway (variables de entorno)
            if (getenv('MYSQL_HOST')) {
                // Configuración para Railway
                $this->host = getenv('MYSQL_HOST');
                $this->dbname = getenv('MYSQL_DATABASE');
                $this->usuario = getenv('MYSQL_USER');
                $this->password = getenv('MYSQL_PASSWORD');
            } else {
                // Configuración local (desarrollo)
                $this->host = "localhost";
                $this->dbname = "notas";
                $this->usuario = "root";
                $this->password = "";
            }
            
            $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $this->db = new PDO($dsn, $this->usuario, $this->password, $options);
            
        } catch (PDOException $e) {
            if (getenv('MYSQL_HOST')) {
                die("Error de conexión a la base de datos. Por favor, contacta al administrador.");
            } else {
                die("Error de conexión: " . $e->getMessage());
            }
        }
    }
}

?>