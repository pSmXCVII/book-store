<?php
  $db_host = 'localhost';
  $db_user = 'root';
  $db_pass = 'root1001';
  $db_name = 'book_store';

  try{
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($mysqli->connect_error) {
      die("Falha na conexão com o banco de dados: " . $mysqli->connect_error);
    }
    } catch (PDOException $e){
    echo 'Erro na conexão: '.$e->getMessage().'<br>';
    echo 'Codigo do erro: '.$e->getCode();
  }
?>