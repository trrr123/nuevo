<?php 

require_once('../../Conexion.php');

class Docentes extends Conexion {

    public function __construct(){
        parent::__construct();
    }

    public function add($Nombre, $Apellido, $Usuario, $Password){
        $statement = $this->db->prepare("INSERT INTO usuarios (NOMBRE, APELLIDO, USUARIO, PASSWORD, PERFIL, ESTADO) VALUES (:Nombre, :Apellido, :Usuario, :Password, 'Docente', 'Activo')");
        $statement->bindParam(':Nombre', $Nombre);
        $statement->bindParam(':Apellido', $Apellido);
        $statement->bindParam(':Usuario', $Usuario);
        $statement->bindParam(':Password', $Password);
        if($statement->execute()){
            header('Location: ../Pages/index.php');
        }else{
            header('Location: ../Pages/add.php');
        }
    }

    public function get(){
        $rows = null;
        $statement = $this->db->prepare("SELECT * FROM usuarios WHERE PERFIL = 'Docente' ORDER BY NOMBRE");
        $statement->execute();	
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function getById($Id){
        $rows = null;
        $statement = $this->db->prepare("SELECT * FROM usuarios WHERE PERFIL = 'Docente' AND ID_USUARIO = :Id");
        $statement->bindParam(':Id', $Id);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function update($Id, $Nombre, $Apellido, $Usuario, $Password, $Estado){
        $statement = $this->db->prepare("UPDATE usuarios SET NOMBRE = :Nombre, APELLIDO = :Apellido, USUARIO = :Usuario, PASSWORD = :Password, ESTADO = :Estado WHERE ID_USUARIO = :Id");
        $statement->bindParam(':Id', $Id);
        $statement->bindParam(':Nombre', $Nombre);
        $statement->bindParam(':Apellido', $Apellido);
        $statement->bindParam(':Usuario', $Usuario);
        $statement->bindParam(':Password', $Password);
        $statement->bindParam(':Estado', $Estado);
        if($statement->execute()){
            header('Location: ../Pages/index.php');
        }else{
            header('Location: ../Pages/edit.php?Id=' . $Id);
        }
    }

    public function delete($Id){
        $statement = $this->db->prepare("DELETE FROM usuarios WHERE ID_USUARIO = :Id");
        $statement->bindParam(':Id', $Id);
        if($statement->execute()){
            header('Location: ../Pages/index.php');
        }else{
            header('Location: ../Pages/delete.php');
        }
    }

    public function asignarMateria($IdDocente, $IdMateria, $IdCurso){
        try {
            $statement = $this->db->prepare("INSERT INTO docente_materias (ID_DOCENTE, ID_MATERIA, ID_CURSO) VALUES (:IdDocente, :IdMateria, :IdCurso)");
            $statement->bindParam(':IdDocente', $IdDocente);
            $statement->bindParam(':IdMateria', $IdMateria);
            $statement->bindParam(':IdCurso', $IdCurso);
            return $statement->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function obtenerMateriasDocente($IdDocente){
        $rows = null;
        $statement = $this->db->prepare("SELECT dm.ID, m.ID_MATERIA, m.MATERIA, c.ID_CURSO, c.NOMBRE_CURSO, c.NIVEL 
                                         FROM docente_materias dm 
                                         INNER JOIN materias m ON dm.ID_MATERIA = m.ID_MATERIA 
                                         INNER JOIN cursos c ON dm.ID_CURSO = c.ID_CURSO 
                                         WHERE dm.ID_DOCENTE = :IdDocente 
                                         ORDER BY c.NIVEL, m.MATERIA");
        $statement->bindParam(':IdDocente', $IdDocente);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function eliminarMateriaDocente($Id){
        $statement = $this->db->prepare("DELETE FROM docente_materias WHERE ID = :Id");
        $statement->bindParam(':Id', $Id);
        return $statement->execute();
    }

    public function obtenerCursosDocente($IdDocente){
        $rows = null;
        $statement = $this->db->prepare("SELECT DISTINCT c.ID_CURSO, c.NOMBRE_CURSO, c.NIVEL 
                                         FROM cursos c 
                                         INNER JOIN docente_materias dm ON c.ID_CURSO = dm.ID_CURSO 
                                         WHERE dm.ID_DOCENTE = :IdDocente 
                                         ORDER BY c.NIVEL");
        $statement->bindParam(':IdDocente', $IdDocente);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }
}

?>