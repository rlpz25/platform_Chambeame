<?php

include './database.php';

session_start();

$db = new Database();
$con = $db->conectar();

$comando = $con->prepare('SELECT * FROM usuario WHERE correo = :correo');
$comando3 = $con->prepare('SELECT * FROM usuario WHERE correo = :correo AND pass = :pass');


if (isset($_POST['registrar'])){
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];
    $rfc = $_POST['rfc'];

    $comando->execute([
        "correo"=>$correo
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    if(!$result){
        $comando2 = $con->prepare('INSERT INTO usuario (nombre_completo, rfc, imagen, telefono, correo, pass) VALUES (:nombre, :rfc, :imagen, :telefono, :correo, :pass)');
        $comando2->execute([
            "nombre"=>$nombre,
            "rfc"=>$rfc,
            "imagen"=>"https://prieyes.com/wp-content/uploads/2019/04/no-user.jpg",
            "telefono"=>$telefono,
            "correo"=>$correo,
            "pass"=>$pass,
        ]);
        $result2 = $comando2->fetchAll(PDO::FETCH_ASSOC);

        $comando3->execute([
            "correo"=>$correo,
            "pass"=>$pass,
        ]);
        $result = $comando3->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $usuario){
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre_completo'];
            $_SESSION['imagen'] = $usuario['imagen'];
            $_SESSION['telefono'] = $usuario['telefono'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['pass'] = $usuario['pass'];
            $_SESSION['rfc'] = $usuario['rfc'];
        }
        header('Location: ./index.php');
    } else {
        header('Location: ./pantallas/pantalla_registro.php');
    }
}

if (isset($_POST['iniciar_sesion'])){
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];
    $comando3->execute([
        "correo"=>$correo,
        "pass"=>$pass,
    ]);
    $result = $comando3->fetchAll(PDO::FETCH_ASSOC);
    if($result){
        foreach($result as $usuario){
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre_completo'];
            $_SESSION['imagen'] = $usuario['imagen'];
            $_SESSION['telefono'] = $usuario['telefono'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['pass'] = $usuario['pass'];
            $_SESSION['rfc'] = $usuario['rfc'];
        }
        header('Location: ./index.php');
    } else {
        header('Location: ./pantallas/pantalla_inicio-sesion.php');
    }
}

if (isset($_POST['cerrar_sesion'])){
    session_destroy();
    header('Location: ./index.php');
}

if (isset($_POST['agregar_anuncio'])){
    $fecha = date('Y-m-d H:i:s');
    $comando = $con->prepare('INSERT INTO anuncio (titulo, descripcion, telefono, fecha, id_usuario) VALUES (:titulo, :descripcion, :telefono, :fecha, :id_usuario)');
    $comando->execute([
        "titulo"=>$_POST['titulo'],
        "descripcion"=>$_POST['descripcion'],
        "telefono"=>$_POST['telefono'],
        "fecha"=>$fecha,
        "id_usuario"=>$_SESSION['id_usuario'],
    ]);
    $comando = $con->prepare('SELECT * FROM anuncio WHERE fecha = :fecha AND id_usuario = :id_usuario ORDER BY fecha ASC');
    $comando->execute([
        "fecha"=>$fecha,
        "id_usuario"=>$_SESSION['id_usuario'],
    ]);
    $result = $comando->fetchAll(PDO::FETCH_ASSOC);
    $anuncio = array();
    foreach($result as $a){
        $anuncio = $a;
    }
    $comando = $con->prepare('INSERT INTO etiqueta_anuncio (id_etiqueta, id_anuncio) VALUES (:id_etiqueta, :id_anuncio)');
    $comando->execute([
        "id_anuncio"=>$anuncio['id_anuncio'],
        "id_etiqueta"=>$_POST['etiqueta'],
    ]);
    header('Location: ./pantallas/pantalla_mis-anuncios.php');
}

if (isset($_POST['modificar_anuncio'])){
    $fecha = date('Y-m-d H:i:s');
    $comando = $con->prepare('UPDATE anuncio SET titulo = :titulo, descripcion = :descripcion, telefono = :telefono, fecha = :fecha WHERE id_anuncio = :id_anuncio');
    $comando->execute([
        "titulo"=>$_POST['titulo'],
        "descripcion"=>$_POST['descripcion'],
        "telefono"=>$_POST['telefono'],
        "fecha"=>$fecha,
        "id_anuncio"=>$_GET['id'],
    ]);
    $comando = $con->prepare('UPDATE etiqueta_anuncio SET id_etiqueta = :id_etiqueta WHERE id_anuncio = :id_anuncio');
    $comando->execute([
        "id_anuncio"=>$_GET['id'],
        "id_etiqueta"=>$_POST['etiqueta'],
    ]);
    header('Location: ./pantallas/pantalla_mis-anuncios.php');
}

if(isset($_GET['dlt'])){
    if ($_GET['dlt'] == true){
        $comando = $con->prepare('DELETE FROM etiqueta_anuncio WHERE id_anuncio = :id_anuncio;');
        $comando->execute([
            "id_anuncio"=>$_GET['id'],
        ]);
        $comando = $con->prepare('DELETE FROM anuncio WHERE id_anuncio = :id_anuncio;');
        $comando->execute([
            "id_anuncio"=>$_GET['id']
        ]);
        header('Location: ./pantallas/pantalla_mis-anuncios.php');
    }
}

if(isset($_GET['dlt_op'])){
    $comando = $con->prepare('DELETE FROM opinion WHERE id_opinion = :id_opinion;');
    $comando->execute([
        "id_opinion"=>$_GET['dlt_op'],
    ]);
    header('Location: ./pantallas/pantalla_opinion.php?id='.$_GET['id']);
}

if(isset($_POST['guardar_perfil'])){
    $comando = $con->prepare('UPDATE usuario SET nombre_completo = :nombre, telefono = :telefono WHERE id_usuario = :id_usuario');
    $comando->execute([
        "nombre"=>$_POST['nombre'],
        "telefono"=>$_POST['telefono'],
        "id_usuario"=>$_SESSION['id_usuario'],
    ]);
    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION['telefono'] = $_POST['telefono'];
    header('Location: ./pantallas/pantalla_perfil.php');
}

if(isset($_POST['agregar_opinion'])){
    $comando = $con->prepare('INSERT INTO opinion (comentario, calificacion, es_anonimo, id_usuario, id_anuncio) VALUES (:comentario, :calificacion, :es_anonimo, :id_usuario, :id_anuncio)');
    $comando->execute([
        "comentario"=>$_POST['comentario'],
        "calificacion"=>$_POST['estrellas'],
        "es_anonimo"=>$_POST['es_anonimo'],
        "id_anuncio"=>$_GET['id'],
        "id_usuario"=>$_SESSION['id_usuario'],
    ]);
    header('Location: ./pantallas/pantalla_opinion.php?id='.$_GET['id']);
}

?>