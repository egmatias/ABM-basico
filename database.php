<?php

class Base
{
	const DB_SERVER = "localhost";
	const DB_NAME = "empresa";
	const DB_USERNAME = "root";
	const DB_PASSWORD = "";

	private $conexion;
	private $ultima_consulta;
	
	public function __construct()
	{
		$this->abrir_conexion();
	}

	public function __destruct()
	{
		$this->cerrar_conexion();
	}


	private function abrir_conexion()
	{
		
		$this->conexion = mysqli_connect(Base::DB_SERVER, Base::DB_USERNAME, Base::DB_PASSWORD, Base::DB_NAME);
		if(!$this->conexion)
		{
			unset($this->conexion);
			die("No hemos podido conectarnos a la base de datos: " . mysqli_connect_errno());
		}
	}

	private function cerrar_conexion()
	{
		
		if(isset($this->conexion))
		{
			mysqli_close($this->conexion);
			unset($this->conexion);
		}
	}
	public function buscar_por_sql($sql)
	{
		$resultado = $this->enviar_consulta($sql);
		return $resultado;
	}

	public function enviar_consulta($sql)
	{
		$this->ultima_consulta = $sql;
		$resultado= mysqli_query($this->conexion, $sql);
		$this->verificar_consulta($resultado);
		return $resultado;
	}

	public function verificar_consulta($consulta)
	{
		if(!$consulta)
		{
			$salida = "No se ha podido realizar la consulta: " . mysqli_error() . "<br>";
			$salida .= "Ultima consulta SQL: " . $this->ultima_consulta;
			die($salida);
		}
	}

	public function mostrar($resultado)
	{
		while($fila = $bd->fetch_array($resultado))
		{
			for($c=0; $c< mysqli_num_fields($resultado); $c++)
			{
				echo $fila[$c] . " ";
			}
			echo "<br>";
		}
	}

	public function fetch_array($resultado)
	{
		return mysqli_fetch_array($resultado);
	}

	public function affected_rows()
	{
		return mysqli_affected_rows($this->conexion);
	}

	public function insert_id()
	{
		return mysqli_insert_id($this->conexion);
	}

	public function num_rows($resultado)
	{
		return mysqli_num_rows($resultado);
	}
}

$bd= new Base();

?>