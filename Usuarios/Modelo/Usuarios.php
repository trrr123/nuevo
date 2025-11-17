<?php 

require_once('../../Conexion.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Usuarios extends Conexion {

    public function __construct(){
        parent::__construct();
    }

    public function login($Usuario, $Password){
        $statement = $this->db->prepare("SELECT * FROM usuarios WHERE USUARIO = :Usuario AND PASSWORD = :Password");
        $statement->bindParam(':Usuario', $Usuario);
        $statement->bindParam(':Password', $Password);
        $statement->execute();
        
        if($statement->rowCount() == 1){
            $result = $statement->fetch();
            $_SESSION['NOMBRE'] = $result["NOMBRE"] . " " . $result['APELLIDO'];
            $_SESSION['ID'] = $result['ID_USUARIO'];
            $_SESSION['PERFIL'] = $result['PERFIL'];
            return true;
        }
        return false;
    }

    public function getNombre(){
        return isset($_SESSION['NOMBRE']) ? $_SESSION['NOMBRE'] : '';
    }

    public function getId(){
        return isset($_SESSION['ID']) ? $_SESSION['ID'] : null;
    }

    public function getPerfil(){
        return isset($_SESSION['PERFIL']) ? $_SESSION['PERFIL'] : '';
    }

    public function validateSession(){
        if(!isset($_SESSION['ID']) || $_SESSION['ID'] == NULL){
            header('Location: ../../index.php');
            exit();
        }
    }

    public function validateSessionAdministrador(){
        if(isset($_SESSION['ID']) && $_SESSION['ID'] != null){
            if($_SESSION['PERFIL'] == 'Docente'){
                header('Location: ../../Estudiantes/Pages/index.php');
                exit();
            }
        }
    }

    public function salir(){
        $_SESSION = array();
        session_destroy();
        header('Location: ../../index.php');
        exit();
    }
}