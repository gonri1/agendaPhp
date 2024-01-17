<?php


//Tratamos los datos para que no nos muestre mensaje de error el formulario

$nombre = isset($_POST["nombre"]) ? strip_tags(trim($_POST["nombre"])) : "";
$apellido1 = isset($_POST["apellido1"]) ? strip_tags(trim($_POST["apellido1"])) : "";



