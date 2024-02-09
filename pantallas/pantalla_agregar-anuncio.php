<?php 
    require "../database.php";

    session_start();

    $db = new Database();
    $con = $db->conectar();
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
            <form action="../metodos.php" method="POST">
				<label for="anuncio">Titulo del anuncio: </label>
				<input type="text" id="titleanu" name="titulo" placeholder="Climas" class="txt__fld">
				
				<label for="cel">Teléfono de contacto: </label>
				<input type="text" id="celu" name="telefono" placeholder="9371522589" class="txt__fld">
				
				<label for="des">Descripción: </label>
			    <textarea id="subject" name="descripcion" placeholder="Descripción del anuncio.." style="height:200px;" class="txt__fld"></textarea>
				
				<label for="pro">Profesión: </label>
				<select id="profesion" name="etiqueta">
                    <?php 
                    $comando = $con->prepare('SELECT * FROM etiqueta ORDER BY id_etiqueta DESC');
                    $comando->execute();
                    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $etiqueta){ ?>
				    <option value="<?php echo $etiqueta['id_etiqueta'];?>"><?php echo $etiqueta['valor'];?></option>
                    <?php } ?>
                </select>
				<input type="submit" value="Añadir anuncio" name="agregar_anuncio" class="boton2">
			</form>
			<a href="./pantalla_mis-anuncios.php"> <button class="boton3">Cancelar</button> </a>
        </div>
    </main>
    <script src="../js/script.js"></script>
</body>

</html>