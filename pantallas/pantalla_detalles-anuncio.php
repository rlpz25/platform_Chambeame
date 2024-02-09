<?php 
    require "../database.php";
    require "../globales.php";

    session_start();

    $db = new Database();
    $con = $db->conectar();

    $id_anuncio = $_GET['id'];

    $comando = $con->prepare('SELECT * FROM anuncio WHERE id_anuncio = :id_anuncio');
    $comando->execute([
        "id_anuncio"=>$id_anuncio,
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    $anuncio = $result[0];

    $titulo = $anuncio['titulo'];
    $descripcion = $anuncio['descripcion'];
    $fecha = $anuncio['fecha'];
    $telefono = $anuncio['telefono'];
    $id_usuario = $anuncio['id_usuario'];

    $comando = $con->prepare('SELECT * FROM usuario WHERE id_usuario = :id_usuario');
    $comando->execute([
        "id_usuario"=>$id_usuario,
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    $usuario = $result[0];

    $nombre = $usuario['nombre_completo'];
    $correo = $usuario['correo'];
    $imagen = $usuario['imagen'];

    
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
        <a href="#" class="selected">
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
            <div class="perfil_container">
                <div class="container">
                <img  class="foto_perfil" src="<?php echo $imagen ?>" alt="">
                </div>
                <br>
                <div class="cleafix"></div>
                <label for="name">Titulo: </label>
                <h4><?php echo $titulo ?></h4>
                <br>
                <label for="name">Nombre del trabajador: </label>
                <h4><?php echo $nombre ?></h4>
                <br>
                <label for="cel">Teléfono: </label>
                <a href="<?php echo "tel://".$telefono ?>"><h4><?php echo $telefono ?></h4></a>
                <br>
                <label for="mail">Correo electronico: </label>
                <h4><?php echo $correo ?></h4>
                <br>
                <label for="rfc">Descripcion: </label>
                <h4><?php echo $descripcion ?></h4>
                <br>
            </div>
            <a href="./pantalla_opinion.php<?php echo '?id='.$id_anuncio?>"><button class="boton2">Ver Opiniones</button></a>
            <a href="../index.php"><button class="boton3">Volver</button></a>
        </div>
    </main>

    <script src="../js/script.js"></script>
</body>

</html>