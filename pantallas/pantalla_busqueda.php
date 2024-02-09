<?php 
    require "../database.php";
    require "../globales.php";

    session_start();

    $db = new Database();
    $con = $db->conectar();

    $parametro = $_POST['parametro'];
    $sh_res = array();
    $sh_aux = array();

    $comando = $con->prepare("SELECT * FROM etiqueta WHERE UPPER(valor) LIKE UPPER(:valor)");
    $comando->execute([
        "valor"=> $parametro."%",
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $elemento){
        array_push($sh_aux, $elemento);
    }

    $comando = $con->prepare('SELECT * FROM etiqueta WHERE UPPER(valor) LIKE UPPER(:valor)');
    $comando->execute([
        "valor"=>$parametro,
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $elemento){
        array_push($sh_aux, $elemento);
    }

    $comando = $con->prepare("SELECT * FROM etiqueta WHERE UPPER(valor) LIKE UPPER(:valor)");
    $comando->execute([
        "valor"=> "%".$parametro."%",
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $elemento){
        array_push($sh_aux, $elemento);
    }

    $comando = $con->prepare("SELECT * FROM etiqueta WHERE UPPER(valor) LIKE UPPER(:valor)");
    $comando->execute([
        "valor"=> "%".$parametro,
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $elemento){
        array_push($sh_aux, $elemento);
    }

    $id_etiquetas = array();

    foreach($sh_aux as $etiqueta){
        array_push($id_etiquetas, $etiqueta['id_etiqueta']);
    }

    $id_etiquetas = array_unique($id_etiquetas);

    foreach($id_etiquetas as $etiqueta){
        $comando = $con->prepare('SELECT * FROM etiqueta_anuncio WHERE id_etiqueta = :id_etiqueta');
        $comando->execute([
        "id_etiqueta"=>$etiqueta,
        ]);
        $result = $comando->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $etiqueta_anuncio){
            $comando = $con->prepare('SELECT * FROM anuncio WHERE id_anuncio = :id_anuncio');
            $comando->execute([
            "id_anuncio"=>$etiqueta_anuncio['id_anuncio'],
            ]);
            $result = $comando->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $anuncio){
                array_push($sh_res, $anuncio);
            }
        }
    }
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
        <div class="icon__menu">
            <?php if (isset($_SESSION['id_usuario'])) { ?>
            <i class="fas fa-bars" id="btn_open"></i>
            <?php } ?>
        </div>
        <div class="header__title">
            <h4>Chambea-me</h4>
        </div>
        <div class="icon__profile">
            <a href="./pantalla_perfil.php"><i class="fa-regular fa-circle-user"></i></a>
            <a href="#" class="selected" hidden=true><i class="fa-regular fa-circle-user" id="btn_open"></i></a>
        </div>
    </header>

    <div class="menu__side" id="menu_side">
        <a href="../index.php" class="selected">
            <div class="name__page">
                <i class="fas fa-home" title="Inicio"></i>
                <h4>Inicio</h4>
            </div>
        </a>
        <?php if (isset($_SESSION['id_usuario'])) { ?>
        <div class="options__menu">
            <a href="./pantalla_mis-anuncios.php">
                <div class="option">
                    <i class="far fa-address-card" title="Mis anuncios"></i>
                    <h4>Mis anuncios</h4>
                </div>
            </a>
        </div>
        <?php } ?>
        
    </div>

    <main>
        <div class="resumen">
            <br>
        <?php
            foreach($sh_res as $anuncio){
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
                    <!-- <i class="fa-solid fa-check-to-slot"></i> -->
                    <a href="./pantallas/pantalla_detalles-anuncio.php<?php echo '?id='.$id_anuncio?>"><i class="fa-solid fa-circle-info"></i></a>
                    <a href="./pantallas/pantalla_opinion.php<?php echo '?id='.$id_anuncio?>"><i class="fa-solid fa-comments"></i></i></a>
                </div>
            </div>
            <?php } ?>
        </div>
    </main>

    <script src="../js/script.js"></script>
</body>

</html>