<?php
$inicio = ($pagina>0) ? (($registros*$pagina)-$registros): 0;
$tabla = "";

if(isset($busqueda) && $busqueda != ""){//busqueda especifica por nombre
    $consulta_datos = "SELECT * FROM bienes WHERE bien_nombre LIKE '%$busqueda%' ORDER BY bien_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(bien_id) FROM bienes WHERE bien_nombre LIKE '%$busqueda%'";

} else {//busqueda total
    $consulta_datos = "SELECT * FROM bienes ORDER BY bien_nombre ASC LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(bien_id) FROM bienes";
}

$conexion=con();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int)$total->fetchColumn();//fetch una unica columna
//cantidad paginas para mostrar
$Npaginas = ceil($total/$registros);//redonde hacia arriba

$tabla.='
    <div class="table-container">
    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
        <thead>
            <tr class="has-text-centered">
                <th class="has-text-centered">#</th>
                <th class="has-text-centered">Nombre</th>
                <th class="has-text-centered">Cantidad</th>
                <th class="has-text-centered">Marca</th>
                <th class="has-text-centered">Modelo</th>
                <th class="has-text-centered" colspan="2">Opciones</th>
            </tr>
        </thead>
        <tbody>

';

if($total>=1 && $pagina <= $Npaginas){

    $contador = $inicio+1;//contador de usuarios
    $pag_inicio=$inicio+1;//ej: mostrando usuario 1 al 7

    foreach($datos as $bien){
        $tabla.='
            <tr class="has-text-centered" >
                <td>'.$contador.'</td>
                <td>'.$bien["bien_nombre"].'</td>
                <td>'.$bien["bien_cantidad"].'</td>
                <td>'.$bien["bien_marca"].'</td>
                <td>'.$bien["bien_modelo"].'</td>
                <td>
                    <a href="index.php?vista=bien_update&bien_id_upd='.$bien["bien_id"].'" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="'.$url.$pagina.'&bien_id_del='.$bien["bien_id"].'" class="button is-danger is-rounded is-small btnDanger">Eliminar</a>
                </td>
            </tr>
        ';
        $contador++;
    }
    $pag_final=$contador-1;//ej: mostrando usuario 1 al 7
} else {
    if($total>=1){//si introduce una pagina no existente te muestra boton para llevarte a la pag 1
        $tabla.='
            <tr class="has-text-centered" >
            <td colspan="5">
                <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Haga clic para recargar el listado
                </a>
            </td>
        </tr> 
        ';
    } else {
        $tabla.='
            <tr class="has-text-centered" >
            <td colspan="6">
                No hay registros en el sistema
            </td>
        </tr>
    ';
    }
}



$tabla.='
            </tbody>
        </table>
    </div>';


if($total>=1 && $pagina <= $Npaginas){
    $tabla.='
        <p class="has-text-right">Mostrando bienes <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>
    ';
    }


$conexion=null;
echo $tabla;

if($total>=1 && $pagina <= $Npaginas){
    echo paginador($pagina, $Npaginas, $url, 7);

}