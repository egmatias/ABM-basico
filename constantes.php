<?php 
	require('database.php');

	$base = new Base();
	$listado = $base->buscar_por_sql("SELECT * FROM empleados");
	$base->mostrar($listado);

	
?>