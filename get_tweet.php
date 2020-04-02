<?php
session_start();

if(!isset($_SESSION['usuario'])) {             //Controle de sessão de usuario
    header('Location: index.php?erro=1');
}
require_once('db.class.php');


$id_usuario = $_SESSION['id_usuario'];

$objDb = new db();
$link = $objDb->conecta_mysql();
  
$sql = "SELECT DATE_FORMAT(t.data_inclusao, '%d %b %Y %T') AS dt_format, t.data_inclusao, t.tweet, u.usuario ";
$sql.= "FROM tweet AS t JOIN usuarios AS u ON (t.id_usuario = u.id)";                                  // Join realizado entre a tabela tweet e usuarios
$sql.= "WHERE id_usuario = $id_usuario ORDER BY data_inclusao DESC";                                   // Seleção de todos os registros por ordem de data decrescente do usuario da sessão
$resultado_id = mysqli_query($link, $sql);

if($resultado_id){

    while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
        echo ' <a href="#" class="list-group-item">';
        echo ' <p class="list-group-item-text">'.$registro['tweet'].'</p>';
        echo ' <h5 class="list-group-item-heading">'.$registro['usuario'].'<small> - '.$registro['dt_format'].'</small></h5>';
        echo ' </a>';
    }

}else{
    echo 'Erro na consulta de tweetes no banco de dados!';
}

?>