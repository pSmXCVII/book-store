<?php
  $db_host = 'localhost';
  $db_user = 'root';
  $db_pass = 'root1001';
  $db_name = 'book_store';

  try{
    // $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'));
    // $pdo = new PDO("mysql:host=localhost;dbname=book_store", 'root', 'root1001', array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'));
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($mysqli->connect_error) {
      die("Falha na conexão com o banco de dados: " . $mysqli->connect_error);
    }
    } catch (PDOException $e){
    echo 'Erro na conexão: '.$e->getMessage().'<br>';
    echo 'Codigo do erro: '.$e->getCode();
  }
?>