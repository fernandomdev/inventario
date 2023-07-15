<div class="container is-fluid mb-6">
    <h1 class="title">Proveedores</h1>
    <h2 class="subtitle">Buscar proveedor</h2>
</div>

<div class="container pb-6 pt-6">
<?php 
    require_once("./php/main.php");

    if(isset($_POST["modulo_buscador"])){
        require_once("./php/buscador.php");

    }

    if(!isset($_SESSION["busqueda_proveedor"]) && empty($_SESSION["busqueda_proveedor"]) ){


?>

    <div class="columns">
        <div class="column">
            <form action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="proveedor">   
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" autofocus >
                    </p>
                    <p class="control">
                        <button class="button is-info is-rounded" type="submit" >Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php   
        } else { 
    ?>
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="proveedor"> 
                <input type="hidden" name="eliminar_buscador" value="proveedor">
                <p>Estas buscando <strong><?php echo $_SESSION["busqueda_proveedor"]; ?></strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
            </form>
        </div>
    </div>
    <?php
    
        if(isset($_GET["prov_id_del"])){
            require_once("./php/prov_eliminar.php");
        }

        if(!isset($_GET["page"])){
            $pagina = 1;
        } else {
            $pagina = (int)$_GET["page"];
            if($pagina<=1){
                $pagina = 1;//controlar que siempre sea 1
            }
        }
    
        $pagina = limpiar_cadena($pagina);
        $url= "index.php?vista=provee_search&page=";
        $registros=15;//cantidad de registros por pagina
        $busqueda=$_SESSION['busqueda_proveedor'];//de proveedores

        require_once("./php/provee_lista.php");

        }//line 33
    ?>

</div>