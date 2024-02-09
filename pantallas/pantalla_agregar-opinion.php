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

    $comando = $con->prepare('SELECT * FROM etiqueta_anuncio WHERE id_anuncio = :id_anuncio');
    $comando->execute([
        "id_anuncio"=>$id_anuncio,
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    $etiqueta_anuncio = $result[0];

    $id_etiqueta = $etiqueta_anuncio['id_etiqueta'];

    $comando = $con->prepare('SELECT * FROM etiqueta WHERE id_etiqueta = :id_etiqueta');
    $comando->execute([
        "id_etiqueta"=>$id_etiqueta,
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    $etiqueta = $result[0];

    $valor = $etiqueta['valor'];

    $comando = $con->prepare('SELECT * FROM opinion WHERE id_anuncio = :id_anuncio ORDER BY id_opinion');
    $comando->execute([
        "id_anuncio"=>$id_anuncio,
    ]);
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
            <form action="../metodos.php<?php echo '?id='.$id_anuncio?>" method="POST">
				<label for="comentario">Comentario: </label>
                <textarea id="comentario" name="comentario" placeholder="Comentario del anuncio.." style="height:200px;" class="txt__fld"></textarea>
				
				<label for="estrellas">Calificar: </label>
				<select id="estrellas" name="estrellas">
                    <option value="0">0 estrellas</option>
                    <option value="1">1 estrella</option>
                    <option value="2">2 estrellas</option>
                    <option value="3">3 estrellas</option>
                    <option value="4">4 estrellas</option>
                    <option value="5">5 estrellas</option>
                </select>

                <label for="es_anonimo">¿Quieres que tu opinión sea anónima?: </label>
				<select id="es_anonimo" name="es_anonimo">
                    <option value="1" selected="selected">Si</option>
                    <option value="0">No</option>
                </select>
				<input type="submit" value="Añadir opinión" name="agregar_opinion" class="boton2">
			</form>
            <a href="./pantalla_opinion.php<?php echo '?id='.$id_anuncio?>"><button class="boton3">Cancelar</button></a>
        </div>
    </main>

    <script src="../js/script.js"></script>
</body>

</html>