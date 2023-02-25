<?php 
class Tabla
{		
	protected static $nombre_tabla;
	protected static $campos_tabla;

	public static function buscar_por_id($id)
	{
		global $bd;
		$matriz = static::buscar_por_sql("SELECT * FROM " . 
		static::$nombre_tabla . " WHERE id = ($id)");
		return (!empty($matriz)) ? array_shift($matriz) : false ;
	}

	public static function buscar_todos()
	{
		global $bd;
		return  static::buscar_por_sql("SELECT * FROM " . 
		static::$nombre_tabla);
	}

	public static function buscar_por_sql($sql)
	{
		global $bd;
		$resultado = $bd->enviar_consulta($sql);
		$matriz = array();
		while($registro = $bd->fetch_array($resultado))
		{
			array_push($matriz, static::instancia($registro));
		}
		return $matriz;
	}


	public function propiedad_existe($propiedad)
	{
		$propiedades = get_object_vars($this);
		return array_key_exists($propiedad, $propiedades);

	} 

	public function propiedades()
	{
		$campos_prop = array();
		foreach(static::$campos_tabla as $campo)
		{
			$campos_prop[$campo] = $this->$campo;
		}
		return $campos_prop;
	}

	public function guardar()
	{
		if(!isset($this->id))
		{
			$this->crear();
		}
		else
		{
			$this->actualizar();
		}
	}

	public function eliminar()
	{
		global $bd;
		$sql = "DELETE FROM " . static::$nombre_tabla . " ";
		$sql .= "WHERE id = " . $this->id;
		$bd->enviar_consulta($sql);
		if($bd->affected_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function crear()
	{
		global $bd;
		$propiedades = $this->propiedades();
		$sql = "INSERT INTO " . static::$nombre_tabla . " (";
		$sql .= implode(", ", array_keys($propiedades));
		$sql .= ") VALUES ('";
		$sql .= implode("' , '", array_values($propiedades)) . "')";
		if($bd->enviar_consulta($sql))
		{
			$this->id = $bd->insert_id();
			return true;
		}
		else
		{
			return false;
		}
	}

	public function actualizar()
	{
		global $bd;
		$propiedades = $this->propiedades();
		$prop_format = array();
		foreach($propiedades as $propiedad => $valor)
		{
			array_push($prop_format, "{$propiedad} =' {$valor}'");
		}
		$sql = "UPDATE " . static::$nombre_tabla . " SET ";
		$sql .= implode(",", $prop_format);
		$sql .= " WHERE id = " . $this->id;
		$bd->enviar_consulta($sql);

		if($bd->affected_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}


?>