<?php 
    require "../database.php";

    session_start();

    $db = new Database();
    $con = $db->conectar();

    $comando = $con->prepare('SELECT * FROM anuncio WHERE id_usuario = :id_usuario ORDER BY id_anuncio DESC');
    $comando->execute(["id_usuario"=>$_SESSION['id_usuario']]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chambea-me</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="shortcut icon" href="../images/Chambea-me.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/e332ecfdb8.js" crossorigin="anonymous"></script>
</head>

<body id="body">

    <header>
        <?php if (isset($_SESSION['id_usuario'])) { ?>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
        <?php } ?>
        <div class="header__title">
            <h4>Chambea-me</h4>
        </div>
        <div class="icon__profile">
            <a href="./pantalla_perfil.php"><i class="fa-regular fa-circle-user" id="btn_open"></i></a>
            <a href="#" class="selected" hidden=true><i class="fa-regular fa-circle-user" id="btn_open"></i></a>
        </div>
    </header>

    <?php if (isset($_SESSION['id_usuario'])) { ?>
    <div class="menu__side" id="menu_side">
        <a href="../index.php">
            <div class="name__page">
                <i class="fas fa-home" title="Inicio"></i>
                <h4>Inicio</h4>
            </div>
        </a>
        <div class="options__menu">
            <a href="#"  class="selected">
                <div class="option">
                    <i class="far fa-address-card" title="Mis anuncios"></i>
                    <h4>Mis anuncios</h4>
                </div>
            </a>
        </div>
    </div>
    <?php } ?>

    <main>
        <div class="busqueda">
            <div class="campos">
                <form action="./pantalla_busqueda-mis.php" method="POST">
                    <input type="text" name="parametro" id="parametro" class="txtsh">
                    <button type="submit" name="buscar" visible>Buscar<i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="resumen">
            <?php
            foreach($result as $anuncio){
                $id_anuncio = $anuncio['id_anuncio'];
                $titulo = $anuncio['titulo'];
                $descripcion = $anuncio['descripcion'];
                $telefono = $anuncio['telefono'];
                $id_usuario = $anuncio['id_usuario'];

                $comando2 = $con->prepare('SELECT * FROM etiqueta_anuncio WHERE id_anuncio = :id_anuncio ORDER BY id_etiqueta DESC');
                $comando2->execute(["id_anuncio"=>$id_anuncio]);
                $result2 = $comando2->fetchAll(PDO::FETCH_ASSOC);

                $comando3 = $con->prepare('SELECT * FROM usuario WHERE id_usuario = :id_usuario');
                $comando3->execute(["id_usuario"=>$id_usuario]);
                $result3 = $comando3->fetchAll(PDO::FETCH_ASSOC);

                $imagen = "";
                $nombre = "";
                foreach($result3 as $usuario){
                    $nombre = $usuario['nombre_completo'];
                    $imagen = $usuario['imagen'];
                }
                
            ?>
            <div class="tarjeta__contacto">
                <img src=<?php echo $imagen; ?> alt="">
                <div class="tarjeta__centro">
                    <h3><?php echo $titulo; ?></h3>
                    <h4><?php echo $nombre; ?></h4>
                    <a href=<?php echo 'tel://'.$telefono; ?>><h5><i class="fa-solid fa-phone"></i><?php echo $telefono; ?></h5></a>
                    <div class="etiquetas">
                        <?php 
                        foreach($result2 as $etiqueta_anuncio){
                            $id_etiqueta = $etiqueta_anuncio['id_etiqueta'];
                        ?>
                        <h6><?php 
                            $comando4 = $con->prepare('SELECT * FROM etiqueta WHERE id_etiqueta = :id_etiqueta');
                            $comando4->execute(["id_etiqueta"=>$id_etiqueta]);
                            $result4 = $comando4->fetchAll(PDO::FETCH_ASSOC);
                            foreach($result4 as $etiqueta){
                                echo $etiqueta['valor'];
                            }
                        ?></h6>
                        <?php } ?>
                    </div>
                </div>
                <div class="botones">
                    <a href="./pantalla_modificar-anuncio.php<?php echo '?id='.$id_anuncio.'&t='.$id_etiqueta?>"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="../metodos.php<?php echo '?id='.$id_anuncio.'&dlt=tr'?>"><i class="fa-solid fa-trash" value="<?php echo $id_etiqueta?>" id="eliminar"></i></a>
                </div>
            </div>
            <?php } ?>
            <br><br><br>
            <div class="flotante">
                <a href="./pantalla_agregar-anuncio.php" class="btn_flt"><i class="fa-solid fa-plus"></i></a>
            </div>
        </div>
    </main>
    <script src="../js/script.js"></script>
</body>

</html>