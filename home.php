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
            $('#btn-tweet').click( function(){                                          // Ativa função ao clicar no #btn-tweet
                //$('#texto_tweet').val();                                              // Carrega valor do "texto-tweet"
                if($('#texto_tweet').val().length > 0){                                 // Verifica se o texto-tweet é maior que 0
                    
                    $.ajax({                                                            // Função ajax JQuery
                        url: 'inclui_tweet.php',                                        // Para onde fazer requisição
                        method: 'post',                                                 // Metodo de envio da requisição
                        data: $('#form_tweet').serialize(),                             // Quais são as informações enviadas via script
                        success: function(data){ 
                            $('#texto_tweet').val('');                                       // Havendo sucesso, executa a função response text
                            atualizaTweet();
                        }
                    });
                }

            });

            function atualizaTweet(){                                                   // Carregar os tweets
                $.ajax({
                    url: 'get_tweet.php',
                    success: function(data){
                        $('#tweets').html(data);

                    }
                });
            }
            atualizaTweet();
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
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- Form dos Tweets-->
                    <form id="form_tweet" class="input-group">
                        <input type="text" id="texto_tweet" name="texto_tweet" class="form-control" placeholder="O que está acontecendo agora?" maxlenght="200"/>
                        <span class="input-group-btn">
                            <button class="btn btn-default" id="btn-tweet" type="button">Tweet</button>
                        </span>
                    </form>
                </div>
            </div>
            <!-- Div dos Tweets-->
            <div id="tweets" class="list-group">    
            </div>
            <!-- Fim Div dos Tweets-->
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                    <div class="panel-body">
                        <h4><a href="procurar_pessoas.php">Procurar por pessoas</a></h4>
                    </div>
            </div>
        </div>
            
    </div>


    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>

</html>