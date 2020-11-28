<?php

require 'environment.php';
global $config;
$config = array();
if (ENVIRONMENT == 'development') {
    define("BASE_URL", "http://projetox.pc/");
    $config['dbname'] = 'db_batepapo';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['pass'] = '';
} else {
    define("BASE_URL", "http://meusite.com.br/");
    $config['dbname'] = 'estrutura_mvc';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['pass'] = 'root';
}
global $db;
$config['default_lang'] = 'en';
try {
    $db = new PDO(
        'mysql:dbname=' . $config['dbname'] . ';host=' . $config['host'],
        $config['dbuser'],
        $config['pass'],
        array(PDO::MYSQL_ATTR_INIT_COMMAND => ("SET NAMES utf8"))
    );
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
