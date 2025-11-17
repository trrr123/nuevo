<?php 

require_once('../../Conexion.php');

class Notas extends Conexion {

	public function __construct(){
		// CORRECCIÓN: Llamar correctamente al constructor padre
		parent::__construct();
	}

	public function add($IdEstudiante, $IdMateria, $IdCurso, $IdPeriodo, $IdDocente, $Valor){
		$statement = $this->db->prepare("INSERT INTO notas (ID_ESTUDIANTE, ID_MATERIA, ID_CURSO, ID_PERIODO, ID_DOCENTE, VALOR_NOTA, FECHA_REGISTRO) VALUES (:IdEstudiante, :IdMateria, :IdCurso, :IdPeriodo, :IdDocente, :Valor, NOW())");
		$statement->bindParam(':IdEstudiante', $IdEstudiante);
		$statement->bindParam(':IdMateria', $IdMateria);
		$statement->bindParam(':IdCurso', $IdCurso);
		$statement->bindParam(':IdPeriodo', $IdPeriodo);
		$statement->bindParam(':IdDocente', $IdDocente);
		$statement->bindParam(':Valor', $Valor);
		return $statement->execute();
	}

	public function get(){
		$rows = [];
		$statement = $this->db->prepare("SELECT * FROM notas");
		$statement->execute();
		while ($result = $statement->fetch()) {
			$rows[] = $result;
		}
		return $rows;
	}

	public function getById($Id){
		$rows = [];
		$statement = $this->db->prepare("SELECT * FROM notas WHERE ID_NOTA = :Id");
		$statement->bindParam(':Id', $Id);
		$statement->execute();
		while ($result = $statement->fetch()) {
			$rows[] = $result;
		}
		return $rows;
	}

	public function obtenerNotasEstudiante($IdEstudiante, $IdPeriodo = null){
		$query = "SELECT n.*, m.MATERIA, e.NOMBRE, e.APELLIDO, p.NOMBRE_PERIODO FROM notas n 
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

	public function obtenerNotasCursoDocente($IdCurso, $IdDocente, $IdPeriodo){
		$rows = [];
		$statement = $this->db->prepare("SELECT n.*, e.NOMBRE, e.APELLIDO, m.MATERIA FROM notas n 
										 INNER JOIN estudiantes e ON n.ID_ESTUDIANTE = e.ID_ESTUDIANTE 
										 INNER JOIN materias m ON n.ID_MATERIA = m.ID_MATERIA 
										 WHERE n.ID_CURSO = :IdCurso AND n.ID_DOCENTE = :IdDocente AND n.ID_PERIODO = :IdPeriodo 
										 ORDER BY e.NOMBRE, m.MATERIA");
		$statement->bindParam(':IdCurso', $IdCurso);
		$statement->bindParam(':IdDocente', $IdDocente);
		$statement->bindParam(':IdPeriodo', $IdPeriodo);
		$statement->execute();
		
		while ($result = $statement->fetch()) {
			$rows[] = $result;
		}
		return $rows;
	}

	public function update($Id, $Valor){
		$statement = $this->db->prepare("UPDATE notas SET VALOR_NOTA = :Valor WHERE ID_NOTA = :Id");
		$statement->bindParam(':Id', $Id);
		$statement->bindParam(':Valor', $Valor);
		return $statement->execute();
	}

	public function delete($Id){
		$statement = $this->db->prepare("DELETE FROM notas WHERE ID_NOTA = :Id");
		$statement->bindParam(':Id', $Id);
		return $statement->execute();
	}

	public function verificarNotaExistente($IdEstudiante, $IdMateria, $IdCurso, $IdPeriodo, $IdDocente){
		$statement = $this->db->prepare("SELECT ID_NOTA FROM notas WHERE ID_ESTUDIANTE = :IdEstudiante AND ID_MATERIA = :IdMateria AND ID_CURSO = :IdCurso AND ID_PERIODO = :IdPeriodo AND ID_DOCENTE = :IdDocente");
		$statement->bindParam(':IdEstudiante', $IdEstudiante);
		$statement->bindParam(':IdMateria', $IdMateria);
		$statement->bindParam(':IdCurso', $IdCurso);
		$statement->bindParam(':IdPeriodo', $IdPeriodo);
		$statement->bindParam(':IdDocente', $IdDocente);
		$statement->execute();
		
		if ($statement->rowCount() > 0) {
			$result = $statement->fetch();
			return $result['ID_NOTA'];
		}
		return null;
	}
}

?>
