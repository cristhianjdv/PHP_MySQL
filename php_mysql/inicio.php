<?php
include_once './data/exec_query.php'; /* agregamos por unica vez la libreria */


/* IMPORTANTE : todo Query debe terminar con punto y coma ";" con eso le indicas que es el fin del query */
$sql = " 
        SELECT id, text, option FROM mytable;
        ";
$db_prd = []; /* aqui puedes usarlo para el caso que la consulta sea a otra base de datos */
$rws = run_exec($sql,3,0,$db_prd); /* le enviamos a la funcion ( Query , 3 = numero permanente y no lo cambies, 0 = sin depurar 1 = depurar "te mostrara el query", conexion a Base de datos  ) */
$rows = $rws[1];  /* En el array colocamos 1 porque es el primer query si tenemos otros pues lo colocarias*/

foreach($rows as $columna){
    echo $columna['id'].'-----'.$columna['text'].'-----'.$columna['option'].'<br />';
}

/* ================================================================ */
/* USANDO VARIOS QUERYS */
/* ================================================================ */

/* IMPORTANTE : todo Query debe terminar con punto y coma ";" con eso le indicas que es el fin del query */
$sql = " 
        SELECT id, text, option FROM mytable;
        SELECT id, estacion FROM estaciones;
        SELECT id, lista FROM vehiculos;
        ";
$db_prd = []; /* aqui puedes usarlo para el caso que la consulta sea a otra base de datos */
$rws = run_exec($sql,3,0,$db_prd); /* le enviamos a la funcion ( Query , 3 = numero permanente y no lo cambies, 0 = sin depurar 1 = depurar "te mostrara el query", conexion a Base de datos  ) */
$rows_a = $rws[1];  /* 1 = mytable*/
$rows_b = $rws[2];  /* 2 = estaciones*/
$rows_c = $rws[3];  /* 3 = vehiculos*/


foreach($rows_a as $columna){
    echo $columna['id'].'-----'.$columna['text'].'-----'.$columna['option'].'<br />';
}

foreach($rows_b as $columna){
    echo $columna['id'].'-----'.$columna['estacion'].'<br />';
}

foreach($rows_c as $columna){
    echo $columna['id'].'-----'.$columna['lista'].'<br />';
}

/* ================================================================ */
/* ME CONECTO A OTRA BD */
/* ================================================================ */

/* IMPORTANTE : todo Query debe terminar con punto y coma ";" con eso le indicas que es el fin del query */
$sql = " 
        SELECT id, colores FROM semaforo;
        ";

           /*$servidor,      $usuario_db, $password_db,     $bd*/
$db_prd = ['192.168.1.101', 'developer', 'mipassword', 'chavo_del_8']; /* este query se conectara a esta base de datos */

$rws = run_exec($sql,3,0,$db_prd); /* le enviamos a la funcion ( Query , 3 = numero permanente y no lo cambies, 0 = sin depurar 1 = depurar "te mostrara el query", conexion a Base de datos  ) */
$rows = $rws[1];  /* 1 = mytable*/



foreach($rows as $columna){
    echo $columna['id'].'-----'.$columna['colores'].'<br />';
}


?>
