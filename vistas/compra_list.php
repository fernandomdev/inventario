<?php // Verificar los permisos del usuario para esta página
	include("./inc/check_rol.php");
	if (isset($_SESSION['rol']) && isset($_GET['vista'])) {
		$vistaSolicitada = $_GET['vista'];
		$rolUsuario = $_SESSION['rol'];
	
		check_rol($vistaSolicitada, $rolUsuario);
		
	} else {
        header("Location: login.php");
        exit();
    }
?>
<div class="container is-fluid mb-6">
    <h1 class="title">Compra</h1>
    <h2 class="subtitle">Lista de compras</h2>
</div>

<div class="container pb-6 pt-6">

<?php 
    require_once("./php/main.php");

    //ELIMINAR PRODUCTOS
    if(isset($_GET["id"])){
        require_once("./php/compra_anular.php");
    }
    
    if(!isset($_GET["page"])){
        $pagina = 1;
    } else {
        $pagina = (int)$_GET["page"];
        if($pagina<=1){
            $pagina = 1;//controlar que siempre sea 1
        }
    }

    $fact_id = (isset($_GET["id"])) ? $_GET["id"] : 0;
    $pagina = limpiar_cadena($pagina);
    $url= "index.php?vista=compra_list&page=";
    $registros=10;//cantidad de registros por pagina
    $busqueda="";//de compras
    require_once("./php/compra_lista.php");

?>


</div>