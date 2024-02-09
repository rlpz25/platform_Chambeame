<?php

include "../globales.php";

session_start();

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
            <?php if ($GLOBALS['logged_in']) { ?>
            <i class="fas fa-bars" id="btn_open"></i>
            <?php } else { ?>
            <a href="./pantalla_perfil.php"><i class="fa-solid fa-arrow-left"></i></a>
            <?php } ?>
        </div>
        <div class="header__title">
            <h4>Chambea-me</h4>
        </div>
        <div class="icon__profile">
            <a href="#" class="selected"><i class="fa-regular fa-circle-user"></i></a>
            <a href="#" class="selected" hidden=true><i class="fa-regular fa-circle-user" id="btn_open"></i></a>
        </div>
    </header>

    <div class="menu__side" id="menu_side">
        <a href="../index.php">
            <div class="name__page">
                <i class="fas fa-home" title="Inicio"></i>
                <h4>Inicio</h4>
            </div>
        </a>
        <div class="options__menu">
            <a href="./pantalla_mis-anuncios.php">
                <div class="option">
                    <i class="far fa-address-card" title="Mis anuncios"></i>
                    <h4>Mis anuncios</h4>
                </div>
            </a>
        </div>

    </div>

    <main>
        <div class="resumen">
            <br>
            <form action="../metodos.php" method="POST">
				<label for="name">Nombre completo: </label>
				<input type="text" id="name" name="nombre" placeholder="Jesus Perez.." class="txt__fld">
				
				<label for="cel">Teléfono: </label>
				<input type="text" id="cel" name="telefono" placeholder="9371522589" class="txt__fld">
				
				<label for="rfc">RFC: </label>
				<input type="text" id="rfc" name="rfc" placeholder="JOSS020593UF3" class="txt__fld">
				
				<label for="mail">Correo electronico: </label>
				<input type="text" id="correo" name="correo" placeholder="algo@gmail.com" class="txt__fld">
				
				<label for="pass">Contraseña: </label>
				<input type="password" id="pass" name="pass" class="txt__fld">
				
				<label for="pass2">Confirmar contraseña: </label>
				<input type="password" id="pass2" name="pass" class="txt__fld">
				
				<input type="submit" value="Registrarse" class="boton2" name="registrar">
			 </form>
			 <a href="./pantalla_perfil.php"> <button class="boton3">Cancelar</button> </a>
        </div>
    </main>

    <script src="../js/script.js"></script>
</body>

</html>