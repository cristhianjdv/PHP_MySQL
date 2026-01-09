<?php
/*
====================================================
 EJEMPLO DE USO DE run_exec()
====================================================

Este archivo muestra cómo usar la función run_exec()
para ejecutar uno o varios queries MySQL desde PHP,
obtener los resultados y trabajar con ellos de forma
ordenada.

CARACTERÍSTICAS:
- Permite ejecutar múltiples queries en una sola llamada
- Retorna los resultados indexados por orden de ejecución
- Permite conectarse a distintas bases de datos

NOTA IMPORTANTE:
Todo query DEBE terminar con punto y coma ";"
Esto indica el final de cada consulta.
====================================================
*/

include_once './data/exec_query.php'; 
/* Se incluye la librería una sola vez */

/*==================================================
 1) EJECUTANDO UN SOLO QUERY
==================================================*/

/* Definimos el query (termina obligatoriamente en ;) */
$sql = "
    SELECT id, text, option FROM mytable;
";

/*
$db_prd:
- Array vacío indica que se usará la conexión por defecto
- Puede definirse para conectarse a otra base de datos
*/
$db_prd = [];

/*
run_exec( query, opcion, debug, conexion_db )

query        : uno o varios queries separados por ;
opcion       : valor fijo (3) - NO modificar
debug        : 0 = sin depuración
               1 = muestra el query ejecutado
conexion_db : datos de conexión o array vacío
*/
$rws = run_exec($sql, 3, 0, $db_prd);

/*
El índice [1] corresponde al primer query ejecutado
*/
$rows = $rws[1];

/* Recorremos los resultados */
foreach ($rows as $columna) {
    echo $columna['id'].'-----'.$columna['text'].'-----'.$columna['option'].'<br/>';
}

/*==================================================
 2) EJECUTANDO VARIOS QUERIES
==================================================*/

/*
Cada query debe terminar con ;
El orden define el índice de los resultados
*/
$sql = "
    SELECT id, text, option FROM mytable;
    SELECT id, estacion FROM estaciones;
    SELECT id, lista FROM vehiculos;
";

$db_prd = [];

/* Ejecutamos todos los queries en una sola llamada */
$rws = run_exec($sql, 3, 0, $db_prd);

/*
Acceso a los resultados:
[1] = primer query  (mytable)
[2] = segundo query (estaciones)
[3] = tercer query  (vehiculos)
*/
$rows_a = $rws[1];
$rows_b = $rws[2];
$rows_c = $rws[3];

/* Resultados del primer query */
foreach ($rows_a as $columna) {
    echo $columna['id'].'-----'.$columna['text'].'-----'.$columna['option'].'<br/>';
}

/* Resultados del segundo query */
foreach ($rows_b as $columna) {
    echo $columna['id'].'-----'.$columna['estacion'].'<br/>';
}

/* Resultados del tercer query */
foreach ($rows_c as $columna) {
    echo $columna['id'].'-----'.$columna['lista'].'<br/>';
}

/*==================================================
 3) CONECTÁNDOSE A OTRA BASE DE DATOS
==================================================*/

/* Definimos el query */
$sql = "
    SELECT id, colores FROM semaforo;
";

/*
Datos de conexión personalizados:
[
  servidor,
  usuario_db,
  password_db,
  base_de_datos
]
*/
$db_prd = [
    '192.168.1.101',
    'developer',
    'mipassword',
    'chavo_del_8'
];

/* Ejecutamos el query en la nueva base de datos */
$rws = run_exec($sql, 3, 0, $db_prd);

/* Primer query ejecutado */
$rows = $rws[1];

/* Recorremos los resultados */
foreach ($rows as $columna) {
    echo $columna['id'].'-----'.$columna['colores'].'<br/>';
}

/*
====================================================
 RECOMENDACIONES FINALES
====================================================

- Usar debug = 1 solo para pruebas
- Validar siempre los datos antes de ejecutar queries
- No exponer credenciales en producción
- Este ejemplo es intencionalmente simple y directo
====================================================
*/
?>

