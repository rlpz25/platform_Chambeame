<?php 
    require "../database.php";

    session_start();

    $db = new Database();
    $con = $db->conectar();
    $id_anuncio = $_GET['id'];

    $comando = $con->prepare('SELECT * FROM anuncio WHERE id_anuncio = :id_anuncio ORDER BY id_anuncio DESC');
    $comando->execute([
        "id_anuncio"=>$id_anuncio,
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    $id_anuncio = "";
    $titulo = "";
    $descripcion = "";
    $telefono = "";
    $id_usuario = "";
    foreach($result as $anuncio){
        $id_anuncio = $anuncio['id_anuncio'];
        $titulo = $anuncio['titulo'];
        $descripcion = $anuncio['descripcion'];
        $telefono = $anuncio['telefono'];
        $id_usuario = $anuncio['id_usuario'];
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
        <div class="resumen">
            <br>
            <form action="../metodos.php<?php echo '?id='.$id_anuncio ?>" method="POST">
				<label for="anuncio">Titulo del anuncio: </label>
				<input type="text" id="titleanu" value="<?php echo $titulo ?>" name="titulo" placeholder="Climas" class="txt__fld">
				
				<label for="cel">Teléfono de contacto: </label>
				<input type="text" id="celu" value="<?php echo $telefono ?>" name="telefono" placeholder="9371522589" class="txt__fld">
				
				<label for="des">Descripción: </label>
			    <textarea id="subject" name="descripcion" placeholder="Descripción del anuncio.." style="height:200px;" class="txt__fld"><?php echo $descripcion ?></textarea>
				
				<label for="pro">Profesión: </label>
				<select id="profesion" name="etiqueta">
                    <?php 
                    $comando = $con->prepare('SELECT * FROM etiqueta ORDER BY id_etiqueta DESC');
                    $comando->execute();
                    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $etiqueta) {
                        if ($etiqueta['id_etiqueta'] == $_GET['t']) {?>
                            <option value="<?php echo $etiqueta['id_etiqueta'];?>" selected="selected"><?php echo $etiqueta['valor'];?></option>
                        <?php } else {?>
                            <option value="<?php echo $etiqueta['id_etiqueta'];?>"><?php echo $etiqueta['valor'];?></option>
                        <?php }
                    }?>
                </select>
				<input type="submit" value="Editar anuncio" name="modificar_anuncio" class="boton2">
			</form>
			<a href="./pantalla_mis-anuncios.php"> <button class="boton3">Cancelar</button> </a>
        </div>
    </main>

    <footer>
        <div class="">

        </div>
    </footer>

    <script src="../js/script.js"></script>
</body>

</html>