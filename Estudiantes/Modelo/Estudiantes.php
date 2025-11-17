<?php 

require_once('../../Conexion.php');

class Estudiantes extends Conexion {

    public function __construct(){
        parent::__construct();
    }

    public function add($Nombre, $Apellido, $Documento, $Correo, $Materia, $Docente, $Promedio, $Fecha){
        $statement = $this->db->prepare("INSERT INTO estudiantes 
            (NOMBRE, APELLIDO, DOCUMENTO, CORREO, MATERIA, DOCENTE, PROMEDIO, FECHA_REGISTRO) 
            VALUES (:Nombre, :Apellido, :Documento, :Correo, :Materia, :Docente, :Promedio, :Fecha)");
        
        $statement->bindParam(':Nombre', $Nombre);
        $statement->bindParam(':Apellido', $Apellido);
        $statement->bindParam(':Documento', $Documento);
        $statement->bindParam(':Correo', $Correo);
        $statement->bindParam(':Materia', $Materia);
        $statement->bindParam(':Docente', $Docente);
        $statement->bindParam(':Promedio', $Promedio);
        $statement->bindParam(':Fecha', $Fecha);

        if($statement->execute()){
            header('Location: ../Pages/index.php');
        } else {
            header('Location: ../Pages/add.php');
        }
    }

    public function update($Id, $Nombre, $Apellido, $Documento, $Correo, $Materia, $Docente, $Promedio, $Fecha){
        $statement = $this->db->prepare("UPDATE estudiantes SET NOMBRE = :Nombre, APELLIDO = :Apellido, DOCUMENTO = :Documento, CORREO = :Correo, MATERIA = :Materia, DOCENTE = :Docente, PROMEDIO = :Promedio, FECHA_REGISTRO = :Fecha WHERE ID_ESTUDIANTE = :Id");
        $statement->bindParam(':Id', $Id);
        $statement->bindParam(':Nombre', $Nombre);
        $statement->bindParam(':Apellido', $Apellido);
        $statement->bindParam(':Documento', $Documento);
        $statement->bindParam(':Correo', $Correo);
        $statement->bindParam(':Materia', $Materia);
        $statement->bindParam(':Docente', $Docente);
        $statement->bindParam(':Promedio', $Promedio);
        $statement->bindParam(':Fecha', $Fecha);
        if($statement->execute()){
            header('Location: ../Pages/index.php');
        }else{
            header('Location: ../Pages/edit.php');
        }
    }

    public function delete($Id){
        $statement = $this->db->prepare("DELETE FROM estudiantes WHERE ID_ESTUDIANTE = :Id");
        $statement->bindParam(':Id', $Id);
        if($statement->execute()){
            header('Location: ../Pages/index.php');
        }else{
            header('Location: ../Pages/delete.php');
        }
    }

    public function get(){
        $rows = [];
        $statement = $this->db->prepare("SELECT * FROM estudiantes");
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function getById($Id){
        $rows = null;
        $statement = $this->db->prepare("SELECT ID_ESTUDIANTE, NOMBRE, APELLIDO, DOCUMENTO, CORREO, MATERIA, DOCENTE, PROMEDIO, FECHA_REGISTRO FROM estudiantes WHERE ID_ESTUDIANTE = :Id");
        $statement->bindParam(':Id', $Id);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function search($search){
        $rows = null;
        $statement = $this->db->prepare("SELECT ID_ESTUDIANTE, NOMBRE, APELLIDO, DOCUMENTO, CORREO, MATERIA, DOCENTE, PROMEDIO, FECHA_REGISTRO FROM estudiantes WHERE NOMBRE LIKE CONCAT('%', :Search, '%') OR APELLIDO LIKE CONCAT('%', :Search, '%') OR DOCUMENTO LIKE CONCAT('%', :Search, '%') OR CORREO LIKE CONCAT('%', :Search, '%') OR MATERIA LIKE CONCAT('%', :Search, '%') OR DOCENTE LIKE CONCAT('%', :Search, '%')");
        $statement->bindParam(':Search', $search);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function obtenerCursosEstudiante($IdEstudiante){
        $rows = null;
        $statement = $this->db->prepare("SELECT c.ID_CURSO, c.NOMBRE_CURSO, c.NIVEL FROM estudiante_cursos ec 
                                         INNER JOIN cursos c ON ec.ID_CURSO = c.ID_CURSO 
                                         WHERE ec.ID_ESTUDIANTE = :IdEstudiante AND ec.ESTADO = 'Activo'
                                         ORDER BY c.NIVEL");
        $statement->bindParam(':IdEstudiante', $IdEstudiante);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function obtenerNotasEstudiante($IdEstudiante, $IdPeriodo = null){
        $query = "SELECT n.*, m.MATERIA, e.NOMBRE, e.APELLIDO, p.NOMBRE_PERIODO 
                  FROM notas n 
                  INNER JOIN materias m ON n.ID_MATERIA = m.ID_MATERIA 
                  INNER JOIN estudiantes e ON n.ID_ESTUDIANTE = e.ID_ESTUDIANTE 
                  INNER JOIN periodos p ON n.ID_PERIODO = p.ID_PERIODO 
                  WHERE n.ID_ESTUDIANTE = :IdEstudiante";
        
        if ($IdPeriodo) {
            $query .= " AND n.ID_PERIODO = :IdPeriodo";
        }
        
        $statement = $this->db->prepare($query);
        $statement->bindParam(':IdEstudiante', $IdEstudiante);
        if ($IdPeriodo) {
            $statement->bindParam(':IdPeriodo', $IdPeriodo);
        }
        $statement->execute();
        
        $rows = [];
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function getEstudiantesCurso($IdCurso){
        $rows = null;
        $statement = $this->db->prepare("SELECT e.ID_ESTUDIANTE, e.NOMBRE, e.APELLIDO, e.DOCUMENTO FROM estudiante_cursos ec 
                                         INNER JOIN estudiantes e ON ec.ID_ESTUDIANTE = e.ID_ESTUDIANTE 
                                         WHERE ec.ID_CURSO = :IdCurso AND ec.ESTADO = 'Activo'
                                         ORDER BY e.NOMBRE");
        $statement->bindParam(':IdCurso', $IdCurso);
        $statement->execute();
        while ($result = $statement->fetch()) {
            $rows[] = $result;
        }
        return $rows;
    }
}

?>