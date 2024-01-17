<?php

// Funcion de LECTURA/ESCRITURA recibe archivo.txt lo muestra por Html en agenda.php

function lectura(): string
{
    $archivoTxt = fopen("fichero/fichero.txt", "r"); //abrimos lectura
    $output = "";

    if ($archivoTxt) { //si existe archivo, continuamos

        while (($linea = fgets($archivoTxt)) !== false) {

            $datos = explode(", ", trim($linea)); //separamos los elementos por su separador, en este caso ",

            if (count($datos) == 5) { // el 5 son los elementos del txt, pueden ser menos o mas

                $output .= "<p>" . $datos[0] . " " . $datos[1] . " " . $datos[2] . " " . $datos[3] . " " . $datos[4] . "</p>";
            }
        }
        fclose($archivoTxt);
    } else {
        $output .= "<p>Error al abrir el archivo.</p>";
    }


    return $output;
}


// Funcion de BORRADO un elemento en el .txt  previamente pasado por post



function delete(): void
{
    $select = isset($_POST["datoPost"]) ? $_POST["datoPost"] : ""; //datos select por $_POST u de otra manera


    //LECTURA


    $archivoTxt = fopen("fichero/fichero.txt", "r"); //Abrimos para lectura

    $nuevasLineas = array(); //array para meter la nueva linea

    while (($linea = fgets($archivoTxt)) !== false) {

        $datos = explode(", ", trim($linea)); //separamos los elementos por su separador, en este caso ","

        if (count($datos) == 5 && $datos[0] == $select) {

            //La coincidencia no la guardamos

        } else {

            $nuevasLineas[] = $linea; //guardamos la coincidencia
        }
    }

    fclose($archivoTxt); //cerramos lectura



    //ESCRITURA


    $archivoTxt = fopen("fichero/fichero.txt", "w"); //abrimos para escritura

    foreach ($nuevasLineas as $linea) {

        fputs($archivoTxt, trim($linea) . PHP_EOL); //Introducimos todas las lineas con fputs
    }

    fclose($archivoTxt); //cerramos escritura

}


//Funcion que CREA UN SELECT con los nombres de los contactos para tratarlos en printSelect.php

function printSelect(): string
{
    $archivoTxt = fopen("fichero/fichero.txt", "r"); //Abrimos para lectura

    //Creamos el select

    $output = "";

    $output .= "<select name='select'>";
    $output .= "<option selected>Mas informacion</option>";

    while (($linea = fgets($archivoTxt)) !== false) {
        $datos = explode(", ", trim($linea));
        if (count($datos) == 5) {
            $output .= "<option value=" . $datos[0] . ">" . $datos[0] . " " . $datos[1] . "</option>"; //Imprimimos options a gusto
        }
    }

    $output .= "</select>";

    fclose($archivoTxt); //cerramos archivo

    return $output;
}


// INSERTAR LINEA EN .TXT

function nuevaLinea()
{
    //Tratamos los datos para que no nos muestre mensaje de error el formulario

    $nombre = isset($_POST["nombre"]) ? strip_tags(trim($_POST["nombre"])) : "";
    $apellido1 = isset($_POST["apellido1"]) ? strip_tags(trim($_POST["apellido1"])) : "";

    if ($nombre != "" && $apellido1 != "") { //comprobamos que no estan vacios

        $nuevaLinea = "$nombre, $apellido1"; //Creamos la linea

        $archivoTxt = fopen("fichero/fichero.txt", "a"); //abrimos escritura append

        fputs($archivoTxt, trim($nuevaLinea) . PHP_EOL); // Insertamos, quitamos espacios en blanco (trim) Agregamos un salto de línea (PHP_EOL)

        fclose($archivoTxt); //cerramos
    }
}
