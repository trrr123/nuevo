<?php 

require_once('../../Conexion.php');

class Cursos extends Conexion {

	public function __construct(){
		$this->db = parent::__construct();
	}

	public function add($NombreCurso, $Nivel, $Descripcion){
		$statement = $this->db->prepare("INSERT INTO cursos (NOMBRE_CURSO, NIVEL, DESCRIPCION, ESTADO, FECHA_CREACION) VALUES (:NombreCurso, :Nivel, :Descripcion, 'Activo', NOW())");
		$statement->bindParam(':NombreCurso', $NombreCurso);
		$statement->bindParam(':Nivel', $Nivel);
		$statement->bindParam(':Descripcion', $Descripcion);
		if($statement->execute()){
			header('Location: ../Pages/index.php');
		}else{
			header('Location: ../Pages/add.php');
		}
	}

	public function get(){
		$rows = [];
		$statement = $this->db->prepare("SELECT * FROM cursos");
		$statement->execute();
		while ($result = $statement->fetch()) {
			$rows[] = $result;
		}
		return $rows;
	}

	public function getById($Id){
		$rows = null;
		$statement = $this->db->prepare("SELECT * FROM cursos WHERE ID_CURSO = :Id");
		$statement->bindParam(':Id', $Id);
		$statement->execute();
		while ($result = $statement->fetch()) {
			$rows[] = $result;
		}
		return $rows;
	}

	public function update($Id, $NombreCurso, $Nivel, $Descripcion, $Estado){
		$statement = $this->db->prepare("UPDATE cursos SET NOMBRE_CURSO = :NombreCurso, NIVEL = :Nivel, DESCRIPCION = :Descripcion, ESTADO = :Estado WHERE ID_CURSO = :Id");
		$statement->bindParam(':Id', $Id);
		$statement->bindParam(':NombreCurso', $NombreCurso);
		$statement->bindParam(':Nivel', $Nivel);
		$statement->bindParam(':Descripcion', $Descripcion);
		$statement->bindParam(':Estado', $Estado);
		if($statement->execute()){
			header('Location: ../Pages/index.php');
		}else{
			header('Location: ../Pages/edit.php?Id=' . $Id);
		}
	}

	public function delete($Id){
		$statement = $this->db->prepare("DELETE FROM cursos WHERE ID_CURSO = :Id");
		$statement->bindParam(':Id', $Id);
		if($statement->execute()){
			header('Location: ../Pages/index.php');
		}else{
			header('Location: ../Pages/delete.php');
		}
	}

	public function asignarMateria($IdCurso, $IdMateria){
		$statement = $this->db->prepare("INSERT INTO curso_materias (ID_CURSO, ID_MATERIA) VALUES (:IdCurso, :IdMateria)");
		$statement->bindParam(':IdCurso', $IdCurso);
		$statement->bindParam(':IdMateria', $IdMateria);
		return $statement->execute();
	}

	public function obtenerMateriaCurso($IdCurso){
		$rows = null;
		$statement = $this->db->prepare("SELECT m.ID_MATERIA, m.MATERIA FROM materias m INNER JOIN curso_materias cm ON m.ID_MATERIA = cm.ID_MATERIA WHERE cm.ID_CURSO = :IdCurso");
		$statement->bindParam(':IdCurso', $IdCurso);
		$statement->execute();
		while ($result = $statement->fetch()) {
			$rows[] = $result;
		}
		return $rows;
	}

	public function eliminarMateriaDelCurso($IdCurso, $IdMateria){
		$statement = $this->db->prepare("DELETE FROM curso_materias WHERE ID_CURSO = :IdCurso AND ID_MATERIA = :IdMateria");
		$statement->bindParam(':IdCurso', $IdCurso);
		$statement->bindParam(':IdMateria', $IdMateria);
		return $statement->execute();
	}

}

?>