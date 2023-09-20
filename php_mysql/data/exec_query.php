<?php

function run_exec($sql,$op, $debug,$db){

if(count($db)>=1){
    $servidor       = $db[0];
    $usuario_db     = $db[1];
    $password_db    = $db[2];
    $bd             = $db[3];
}else{
    include $_SERVER['DOCUMENT_ROOT'] . '/data/config.php';
}

$mysqli = new mysqli($servidor, $usuario_db, $password_db, $bd);

/* comprobar conexión */
if (mysqli_connect_errno()) {
    printf("Conexión fallida: %s\n", mysqli_connect_error());
    exit();
}

//mysqli_set_charset( $mysqli, 'utf8');

$query  = " START TRANSACTION; "."\n";
$query .= $sql;
$query .= " COMMIT;"."\n"; 

if($debug == 1){
    echo "<pre>";
        print_r($query);
    echo "<pre>";
}

/* ejecutar multi consulta */
$count = 0;
$datas = [];
if ($mysqli->multi_query($query)) {
    $error_posi = 0;
    do {
        /* almacenar primer juego de resultados */
        if ($result = $mysqli->store_result())  {
            //$datas[] = $result;
            //$datas[] = $result->fetch_row();
            //$datas[] = $result->fetch_array();
            
            //while ($row = $result->fetch_array()) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                //printf("%s\n", $row[0]);
                $datas[$count][] = $row;
            }
            $result->free();
            
        }
        /* mostrar divisor */
        if ($mysqli->more_results()) {
            //printf("-----------------\n");
        }
        /*if (!$mysqli->next_result(e)) {
          echo "error:".e;
          //break;
        }*/
        $count++;
        $error_posi++;
    } while ($mysqli->next_result());
}

if ($mysqli->errno) {

    echo "Batch execution prematurely ended on statement $i.\n";

    var_dump($statements[$error_posi], $mysqli->error);

}

/* cerrar conexión */
$mysqli->close();

switch($op){
    case 1:
        return '';
    break;
    case 2:
        return '';
    break;
    case 3:

        if($debug == 1){
            echo "<pre>";
                print_r($datas);
            echo "<pre>";
        }

        return $datas;
    break;
}

}

?>