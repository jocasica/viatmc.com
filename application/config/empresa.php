<?php
defined('BASEPATH') OR exit('No direct script access allowed');

@include dirname(dirname(__DIR__)).'/application/config/database.php';

try {
    $conex =  new PDO(
            "mysql:host=localhost;dbname=".$db['default']['database'],
            $db['default']['username'],
            $db['default']['password'],
            array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
            )
    );
    //$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query= "SELECT  * FROM config WHERE id=1";
    $statement= $conex->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $config['ruc'] = $result['ruc'];
    $config['tipo_doc'] = $result['tipo_doc'];
    $config['nom_comercial'] = $result['nom_comercial'];
    $config['razon_social'] = $result['razon_social'];
    $config['codigo_ubigeo'] = $result['codigo_ubigeo'];
    $config['direccion'] = $result['direccion'];
    $config['direccion_departamento'] = $result['direccion_departamento'];
    $config['direccion_provincia'] = $result['direccion_provincia'];
    $config['direccion_distrito'] = $result['direccion_distrito'];
    $config['direccion_codigopais'] = $result['direccion_codigopais'];
    $config['usuariosol'] = $result['usuariosol'];
    $config['clavesol'] = $result['clavesol'];
    $config['tipoproceso'] = $result['tipoproceso']; //3=beta,2=homologacion,1=produccion,4:nubefact
    $config['firma_password'] = $result['firma_password'];
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}