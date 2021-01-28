<?php
session_start();
require_once('db.class.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
}

$objDb = new db();
$link = $objDb->conecta_mysql();

//Consulta quantidade de Tweets
$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT COUNT(*) AS qtde_tweets FROM tweet WHERE id_usuario = $id_usuario"; 

$resultado_id = mysqli_query($link, $sql);

$qtde_tweets = 0;

if($resultado_id){
    $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
    $qtde_tweets = $registro['qtde_tweets'];
}else{
    echo 'Erro ao consultar a query';
}

//Quantidade de seguidores
$sql = "SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario"; 

$resultado_id = mysqli_query($link, $sql);

$qtde_seguidores = 0;

if($resultado_id){
    $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
    $qtde_seguidores = $registro['qtde_seguidores'];
}else{
    echo 'Erro ao consultar a query';
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Twitter clone</title>
    <!-- jquery - link cdn -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <!-- bootstrap - link cdn -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <script type="text/javascript">
        
        $(document).ready( function(){                                                  // Verifica se pagina está carregada
            $('#btn_procurar_pessoa').click( function(){                                // Ativa função ao clicar no #btn-tweet
                //$('#texto_tweet').val();                                              // Carrega valor do "texto-tweet"
                if($('#nome_pessoa').val().length > 0){                                 // Verifica se o texto-tweet é maior que 0
                    
                    $.ajax({                                                            // Função ajax JQuery
                        url: 'get_pessoas.php',                                         // Para onde fazer requisição
                        method: 'post',                                                 // Metodo de envio da requisição
                        data: $('#form_procurar_pessoas').serialize(),                  // Quais são as informações enviadas via script
                        success: function(data){ 
                            $('#pessoas').html(data); 
                            
                            $('.btn_seguir').click(function(){                          // Verifica se o botão foi clicado
                                var id_usuario = $(this).data('id_usuario');            // Carrega o "ID" do usuário associado a cada botão

                                $('#btn_seguir_'+id_usuario).hide();                    // Esconde o botão "seguir" apos ser clicado
                                $('#btn_deixar_seguir_'+id_usuario).show();             // Exibe o botão "deixar_seguir" apos ser clicado
                                

                                $.ajax({
                                    url: 'seguir.php',
                                    method: 'post',
                                    data: {seguir_id_usuario: id_usuario},
                                    success: function(data){
                                        alert('Registro efetuado com sucesso!');
                                    }
                                });
                            });

                            $('.btn_deixar_seguir').click(function(){
                                var id_usuario = $(this).data('id_usuario');

                                $('#btn_seguir_'+id_usuario).show();                    // Exibe o botão "seguir" apos ser clicado
                                $('#btn_deixar_seguir_'+id_usuario).hide();             // Esconde o botão "deixar_seguir" apos ser clicado
                                

                                $.ajax({
                                    url: 'deixar_seguir.php',
                                    method: 'post',
                                    data: {deixar_seguir_id_usuario: id_usuario},
                                    success: function(data){
                                        alert('Registro removido com sucesso!');
                                    }
                                });
                            });
                        }
                    });
                }

            });
        });
    </script>
</head>
<body>
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="imagens/icone_twitter.png" />
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="sair.php">Sair</a>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>



    <div class="container">

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4><?php 
                    $user = ucfirst($_SESSION['usuario']); 
                    echo $user;
                    ?></h4>
                    <hr/>
                    <div class="col-md-6">
                        TWEETS <br/><?= $qtde_tweets ?>
                    </div>
                    <div class="col-md-6">
                        SEGUIDORES <br/><?= $qtde_seguidores ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">

                    <!-- Form dda procura-->
                    <form id="form_procurar_pessoas" class="input-group">
                        <input type="text" id="nome_pessoa" name="nome_pessoa" class="form-control" placeholder="Quem você está procurando?" maxlenght="200"/>
                        <span class="input-group-btn">
                            <button class="btn btn-default" id="btn_procurar_pessoa" type="button">Procurar</button>
                        </span>
                    </form>
                </div>
            </div>
            <!-- Div dos Tweets-->
            <div id="pessoas" class="list-group">    
            </div>
            <!-- Fim Div dos Tweets-->
        </div>
        
        <!--
        <div class="col-md-3">
            <div class="panel panel-default">
                    <div class="panel-body">
                    </div>
            </div>
        </div>
         -->   
    </div>


    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>

</html>