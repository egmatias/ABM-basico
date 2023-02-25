<?php 
class Empleado extends Tabla
{
	public $id;
	public $Nombre;
	public $Apellido;
	public $Edad;
	public $email;
	public $Telefono;
	public $Estado_civil;
	public $Activo;
	public $DNI;
	protected static $nombre_tabla = "empleados";
	protected static $campos_tabla = array("id", "Nombre", "Apellido", "Edad", "email", "Telefono", "Estado_civil", "Activo", "DNI");

	

	public static function instancia($registro)
	{
		$empleado = new Empleado();

		foreach($registro as $propiedad => $valor)
		{
			if($empleado->propiedad_existe($propiedad))
			{
				$empleado->$propiedad = $valor;
			}
		}
		return $empleado;
	}

	public function nombre_completo()
	{
		if(isset($this->Nombre) && isset($this->Apellido))
		{
			return $this->Nombre . " " . $this->Apellido;
		}
		else
		{
			return "";
		}
	}

}



?>