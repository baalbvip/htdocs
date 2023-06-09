<?php
$ftpServer = 'achieveprocessingcenter.com';
$ftpUsername = 'integraciondig';
$ftpPassword = '9ov%1y72DIG#';

$remoteDirectory = 'https://achieveprocessingcenter.com/ACRepository/';

$year = "2021";

// Comando FTP para obtener la lista de archivos
$command = "ftp -n $ftpServer <<END_SCRIPT
quote USER $ftpUsername
quote PASS $ftpPassword
ls -p
quit
END_SCRIPT";

// Ejecutar el comando y capturar la salida
$output = shell_exec($command);

// Imprimir la salida
$arr = explode("\n", $output);

$months = ["01" => [], "02" => [], "03" => [], "04" => [], "05" => [], "06" => [], "07" => [], "08" => [], "09" => [], "10" => [], "11" => [], "12" => []];


foreach ($arr as $file) {
    $str = "ED_";
    $pos = strpos($file, "ED_");

    if ($pos !== false) {
        $filename = substr($file, $pos + 3);  // Obtener la porción de la cadena después de "EC_"
        $filename = $str . $filename;
        $fileName = basename($filename);
        $archivoTipo = substr($fileName, 0, 3);
        $archivoMes = substr($fileName, 5, 2);
        $archivoAnio = substr($fileName, 7, 4);
        $archivoPortafolio = substr($fileName, 16, 5);

        if ($archivoAnio == $year) {
            $urlArchivo = $remoteDirectory . $fileName;
            $months[$archivoMes][] = ['url_download' => $urlArchivo];
        }
    }
}

print_r($months);
