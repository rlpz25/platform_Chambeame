<?php 

require "../globales.php";

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
            <?php if (isset($_SESSION['id_usuario'])) { ?>
            <i class="fas fa-bars" id="btn_open"></i>
            <?php } else { ?>
            <a href="../"><i class="fa-solid fa-arrow-left"></i></a>
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
                <?php if(isset($_SESSION['id_usuario'])) {?>
                    <div class="perfil_container">
                        <div class="container">
                            <?php if($_SESSION['imagen'] == "") {?>
                                <div class="nofoto"></div>
                            <?php } else { ?>
                                <img  class="foto_perfil" src="<?php echo $_SESSION['imagen'] ?>" alt="">
                            <?php } ?>
                        </div>
                        <br><br>
                        <div class="clearfix"></div>
                        <label for="name">Nombre: </label>
                        <h4><?php echo $_SESSION['nombre'] ?></h4>
                        <br>
                        <label for="cel">Teléfono: </label>
                        <h4><?php echo $_SESSION['telefono'] ?></h4>
                        <br>
                        <label for="rfc">RFC: </label>
                        <h4><?php echo $_SESSION['rfc'] ?></h4>
                        <br>
                        <label for="mail">Correo electronico: </label>
                        <h4><?php echo $_SESSION['correo'] ?></h4>
                        <br>
                    </div>
                    <a href="./pantalla_editar-perfil.php"><button class="boton2">Editar Perfil</button></a>
                    <form action="../metodos.php" method="POST">
                        <button class="boton3" name="cerrar_sesion" type="submit">Cerrar Sesion</button>
                    </form>
                <?php } else { ?>
                    <a href="./pantalla_inicio-sesion.php"><button class="boton2">Iniciar Sesión</button></a>
                    <a href="./pantalla_registro.php"><button class="boton2">Registrarse</button></a>
                <?php } ?>
            

        </div>
    </main>
    <script src="../js/script.js"></script>
</body>

</html>