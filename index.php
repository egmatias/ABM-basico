<?php 
	require_once('database.php');
	require_once('table1.php');
	require_once('student.php');


	$empleado = new Empleado();

	$empleados = Empleado::buscar_todos();
	foreach($empleados as $empleado)
	{
		echo $empleado->nombre_completo() . "<br>";
	}
	

?>