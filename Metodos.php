<?php 

require_once('Conexion.php');

class Metodos extends Conexion{

	public function __construct(){
		// CORRECCIÓN: Llamar correctamente al constructor padre
		parent::__construct();
	}

	public function getMaterias(){
		$rows = []; // CORRECCIÓN: Inicializar como array vacío
		$statement = $this->db->prepare("SELECT * FROM materias");
		$statement->execute();
		while($result = $statement->fetch()){
			$rows[] = $result;
		}
		return $rows;
	}

	public function getDocentes(){
		$rows = []; // CORRECCIÓN: Inicializar como array vacío
		$statement = $this->db->prepare("SELECT * FROM usuarios WHERE PERFIL = 'Docente'");
		$statement->execute();
		while($result = $statement->fetch()){
			$rows[] = $result;
		}
		return $rows;
	}
}

?>