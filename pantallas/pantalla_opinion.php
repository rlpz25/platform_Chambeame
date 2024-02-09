<?php 
    require "../database.php";
    require "../globales.php";

    session_start();

    $db = new Database();
    $con = $db->conectar();

    $id_anuncio = $_GET['id'];
    
    $comando = $con->prepare('SELECT * FROM anuncio WHERE id_anuncio = :id_anuncio');

    $comando->execute(["id_anuncio"=>$id_anuncio]);

    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    
    $anuncio = $result[0];

    $comando = $con->prepare('SELECT * FROM opinion WHERE id_anuncio = :id_anuncio ORDER BY id_opinion DESC');
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
            <?php }?>
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
            <div class="comm_container">
                <?php foreach($result as $opinion) {
                    $comando = $con->prepare('SELECT * FROM usuario WHERE id_usuario = :id_usuario');
                    $comando->execute([
                        "id_usuario"=>$opinion['id_usuario'],
                    ]);
                    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
                    $usuario = $result[0];
                
                    $nombre = $usuario['nombre_completo'];
                    $imagen = $usuario['imagen'];
                    ?>
                    <div class="ct-opinion">
                        <div class="op-head">
                            <?php if($opinion['es_anonimo']){ ?>
                                <img class="op-img" src="https://prieyes.com/wp-content/uploads/2019/04/no-user.jpg" alt="">
                                <h4>Usuario de Chambea-me</h4>
                                <?php if(isset($_SESSION['id_usuario'])){
if($opinion['id_usuario'] == $_SESSION['id_usuario']) { ?>
                                    <a href="../metodos.php<?php echo '?id='.$opinion['id_opinion'].'&dlt_op='.$opinion['id_opinion']?>"><i class="fa-solid fa-trash" value="<?php echo $id_etiqueta?>" id="eliminar"></i></a>
                                <?php } } }else {?>
                                <img class="op-img" src="<?php echo $imagen ?>" alt="">
                                <h4><?php echo $nombre ?></h4>
                                <?php 
                        if(isset($_SESSION['id_usuario'])){if($opinion['id_usuario'] == $_SESSION['id_usuario']) { ?>
                                    <a href="../metodos.php<?php echo '?id='.$opinion['id_anuncio'].'&dlt_op='.$opinion['id_opinion']?>"><i class="fa-solid fa-trash" value="<?php echo $id_etiqueta?>" id="eliminar"></i></a>
                                <?php } }?>
                            <?php }?>
                        </div>
                        <div class="op-bdy">
                            <p><?php echo $opinion['comentario'] ?></p>
                            <div class="clearfix"></div>
                            <div class="estrellas">
                                <i class="fa-solid fa-star"></i>
                                <h4><?php echo "Calificó con ".$opinion['calificacion']." estrella(s)." ?></h4>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <br><br><br><br><br><br><br><br><br>
            </div>
        </div>
        <div class="fixed_bottom">
        <?php if(isset($_SESSION['id_usuario'])){ if($_SESSION['id_usuario']!=$anuncio['id_usuario']){ ?>
            <a href="./pantalla_agregar-opinion.php<?php echo '?id='.$id_anuncio?>"><button class="boton2">Agregar opinion</button></a>
        <?php }} ?>
        <a href="./pantalla_detalles-anuncio.php<?php echo '?id='.$id_anuncio?>"><button class="boton2">Ver detalles</button></a>
        <a href="../index.php"><button class="boton3">Volver</button></a>
        </div>
    </main>
    

    <script src="../js/script.js"></script>
</body>

</html>