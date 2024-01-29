<?php

// Funcion, recibe archivo.txt lo muestra por Html en agenda.php

function printAgenda(): string
{
    $archivoTxt = fopen("fichero/fichero.txt", "r"); //abrimos lectura
    $output = "";

    if ($archivoTxt) { //si existe archivo, continuamos

        while (($linea = fgets($archivoTxt)) !== false) {

            $datos = explode(", ", trim($linea));

            if (count($datos) == 5) {
                $output .= "<div class='contacto'>";
                $output .= "<h5 class='bg-light text-black text-center'>" . $datos[0] . " " . $datos[1] . " " . $datos[3] . "</h5>";
                $output .= "</div>";
            }
        }
        fclose($archivoTxt);
    } else {
        $output .= "<p>Error al abrir el archivo.</p>";
    }
    return $output;
}

//Funcion que crea un select con los nombres de los contactos para tratarlos en printSelect.php

function printSelect(): string
{
    $archivoTxt = fopen("fichero/fichero.txt", "r"); //Abrimos para lectura

    //Creamos el select

    $output = "";

    $output .= "<select name='select' class='form-select mb-4' aria-label='Default select example'>";
    $output .= "<option selected>Mas informacion</option>";

    while (($linea = fgets($archivoTxt)) !== false) {
        $datos = explode(", ", trim($linea));
        if (count($datos) == 5) {
            $output .= "<option value=" . $datos[0] . ">" . $datos[0] . " " . $datos[1] . "</option>"; //Imprimimos options a gusto
        }
    }

    $output .= "</select>";

    fclose($archivoTxt);

    return $output;
}

//Funcion que crea un select con los nombres de los contactos para borrarlos en con delete() en printSelect.php

function printSelectDetete(): string
{
    $archivoTxt = fopen("fichero/fichero.txt", "r"); //abrimos lectura

    // imprimimos en el html

    $output = "";
    $output .= "<select name='selectDelete' class='form-select mb-4' aria-label='Default select example'>";
    $output .= "<option selected>Mas informacion</option>";

    while (($linea = fgets($archivoTxt)) !== false) {
        $datos = explode(", ", trim($linea));
        if (count($datos) == 5) {
            $output .= "<option value=" . $datos[0] . ">" . $datos[0] . " " . $datos[1] . "</option>";
        }
    }

    $output .= "</select>";

    fclose($archivoTxt); //cerramos lectura

    delete(); //Llamamos a la funcion borrar

    return $output;
}


// Funcion que imprime una card con toda la info del contacto seleccionado, en printSelect.php

function printSelectOption(): string
{
    $select = isset($_POST["select"]) ? $_POST["select"] : ""; //Tratamos datos del select venido por $_POST

    $archivoTxt = fopen("fichero/fichero.txt", "r"); //Abrimos lectura

    // Imprimimos datos en Html
    $output = "";

    while (($linea = fgets($archivoTxt)) !== false) {

        $datos = explode(", ", trim($linea));

        if (count($datos) == 5  && $datos[0] == $select) {

            $output .= "<div class='card' style='width: 18rem;'>";
            $output .= "<div class='card-body'>";
            $output .= "<h5 class='card-title'>" . $datos[0] . " " . $datos[1] . " " . $datos[2] . "</h5>";
            $output .= "<p class='card-text'>telefono " . $datos[3] . " email:" . $datos[4] . "</p>";
            $output .= "<a href='#' class='btn btn-primary'></a>";
            $output .= "</div>";
            $output .= "</div>";
        }
    }
    fclose($archivoTxt); //cerramos lectura

    return $output;
}



// Funcion que borra un elemento en el .txt  previamente pasado por post

function delete(): void
{
    $select = isset($_POST["selectDelete"]) ? $_POST["selectDelete"] : ""; //datos select por $_POST

    $archivoTxt = fopen("fichero/fichero.txt", "r");

    $nuevasLineas = array(); //array para meter la nueva linea

    while (($linea = fgets($archivoTxt)) !== false) {
        $datos = explode(", ", trim($linea));

        if (count($datos) == 5 && $datos[0] == $select) {

            //La coincidencia no la guardamos

        } else {

            $nuevasLineas[] = $linea; //guardamos la coincidencia
        }
    }

    fclose($archivoTxt); //cerramos lectura


    $archivoTxt = fopen("fichero/fichero.txt", "w"); //abrimos para escritura

    foreach ($nuevasLineas as $linea) {

        fputs($archivoTxt, trim($linea) . PHP_EOL); //Introducimos todas las lineas con fputs
    }

    fclose($archivoTxt); //cerramos escritura

}
