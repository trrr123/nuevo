<?php 

class Conexion {

    protected $db;
    private $driver = "mysql";
    private $host = "localhost";
    private $bd = "notas";
    private $usuario = "root";
    private $contraseña = "";

    public function __construct() {
        try {
            $this->db = new PDO("{$this->driver}:host={$this->host};dbname={$this->bd}", $this->usuario, $this->contraseña);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $this->db;
        
        } catch (PDOException $e) {
            echo "Ha surgido un error al conectarse a la base de datos: " . $e->getMessage(); 
            
            return null;

        }
    }
}
?>