<?php

class Database{

    private $_hostname = "localhost";
    private $_database = "x";
    private $_username = "x";
    private $_password = "x";
    private $_charset = "utf8";

    public function conectar(){

        try {

            $conexion = "mysql:host=".$this->_hostname.";dbname=".$this->_database.";charset=".$this->_charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($conexion, $this->_username, $this->_password, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo "Error conexion: ".$e->getMessage();
            exit;
        }

    }

}

?>