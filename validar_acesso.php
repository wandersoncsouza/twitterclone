<?php
session_start();                // Iniciando sessão
require_once('db.class.php');

$usuario = $_POST['usuario'];
$senha= md5($_POST['senha']);

//$sql = "SELECT * FROM usuarios  WHERE usuario = '$usuario' AND senha = '$senha'";
$sql = "SELECT usuario, email FROM usuarios  WHERE usuario = '$usuario' AND senha = '$senha'";

$objDb =new db();                                           //Instanciamento da classe db
$link = $objDb->conecta_mysql();                            //Execução da função conecta_mysql

$resultado_id = mysqli_query($link, $sql);                  // retorna a consulta para $resultado_id

if($resultado_id){
    $dados_usuario = mysqli_fetch_array($resultado_id);     // Recebe por estrutura de array() o resultado_id
    //var_dump($dados_usuario);
    if(isset($dados_usuario['usuario'])){                   // Teste condição usuario no banco de dados
        
        $_SESSION['usuario'] = $dados_usuario['usuario'];
        $_SESSION['email'] = $dados_usuario['email'];

        header('Location: home.php');
    } else{
        header('Location: index.php?erro=1');               //Se usuario não existe informa na pagina principal com erro
    }
} else {
    echo 'Erro na execução da consulta, favor entrar em contato com o Administrador do site';
}
?>