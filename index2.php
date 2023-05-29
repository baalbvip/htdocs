<?php
$ftpServer = 'achieveprocessingcenter.com';
$ftpUsername = 'integraciondig';
$ftpPassword = '9ov%1y72DIG#';


$tipo = 'ED_';
$mes = '12';
$anio = '2022';
$portafolio = '00364';

// Comando FTP para obtener la lista de archivos
$command = "ftp -n $ftpServer <<END_SCRIPT
quote USER $ftpUsername
quote PASS $ftpPassword
ls
quit
END_SCRIPT";

// Ejecutar el comando y capturar la salida
$output = shell_exec($command);

// Imprimir la salida
$arr = explode("\n", $output);


foreach ($arr as $file) {
    $fileName = basename($file);
    $archivoTipo = substr($fileName, 0, 3);
    $archivoMes = substr($fileName, 5, 2);
    $archivoAnio = substr($fileName, 7, 4);
    $archivoPortafolio = substr($fileName, 16, 5);

    // Filtrar archivos basado en las variables
    if (
        $archivoTipo === $tipo &&
        $archivoMes === $mes &&
        $archivoAnio === $anio &&
        $archivoPortafolio === $portafolio
    ) {

        // Generar URL del archivo FTP
        $urlArchivo = $remoteDirectory . $fileName;

        // Mostrar el nombre del archivo como hipervínculo
        echo '<a href="' . $urlArchivo . '" target="_blank">' . $fileName . '</a><br>';
    }
}