<?php 

require_once('../../Conexion.php');

class Periodos extends Conexion {

	public function __construct(){
    parent::__construct(); // ✅ CORRECTO
}

	public function add($NombrePeriodo, $FechaInicio, $FechaFin, $Descripcion){
		$statement = $this->db->prepare("INSERT INTO periodos (NOMBRE_PERIODO, FECHA_INICIO, FECHA_FIN, DESCRIPCION, ESTADO) VALUES (:NombrePeriodo, :FechaInicio, :FechaFin, :Descripcion, 'Activo')");
		$statement->bindParam(':NombrePeriodo', $NombrePeriodo);
		$statement->bindParam(':FechaInicio', $FechaInicio);
		$statement->bindParam(':FechaFin', $FechaFin);
		$statement->bindParam(':Descripcion', $Descripcion);
		if($statement->execute()){
			header('Location: ../Pages/index.php');
		}else{
			header('Location: ../Pages/add.php');
		}
	}

	public function get(){
		$rows = [];
		$statement = $this->db->prepare("SELECT * FROM periodos");
		$statement->execute();
		while ($result = $statement->fetch()) {
			$rows[] = $result;
		}
		return $rows;
	}

	public function getById($Id){
		$rows = null;
		$statement = $this->db->prepare("SELECT * FROM periodos WHERE ID_PERIODO = :Id");
		$statement->bindParam(':Id', $Id);
		$statement->execute();
		while ($result = $statement->fetch()) {
			$rows[] = $result;
		}
		return $rows;
	}

	public function update($Id, $NombrePeriodo, $FechaInicio, $FechaFin, $Descripcion, $Estado){
		$statement = $this->db->prepare("UPDATE periodos SET NOMBRE_PERIODO = :NombrePeriodo, FECHA_INICIO = :FechaInicio, FECHA_FIN = :FechaFin, DESCRIPCION = :Descripcion, ESTADO = :Estado WHERE ID_PERIODO = :Id");
		$statement->bindParam(':Id', $Id);
		$statement->bindParam(':NombrePeriodo', $NombrePeriodo);
		$statement->bindParam(':FechaInicio', $FechaInicio);
		$statement->bindParam(':FechaFin', $FechaFin);
		$statement->bindParam(':Descripcion', $Descripcion);
		$statement->bindParam(':Estado', $Estado);
		if($statement->execute()){
			header('Location: ../Pages/index.php');
		}else{
			header('Location: ../Pages/edit.php?Id=' . $Id);
		}
	}

	public function delete($Id){
		$statement = $this->db->prepare("DELETE FROM periodos WHERE ID_PERIODO = :Id");
		$statement->bindParam(':Id', $Id);
		if($statement->execute()){
			header('Location: ../Pages/index.php');
		}else{
			header('Location: ../Pages/delete.php');
		}
	}

}

?>