<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
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
                        url: 'get_pessoas.php',                                        // Para onde fazer requisição
                        method: 'post',                                                 // Metodo de envio da requisição
                        data: $('#form_procurar_pessoas').serialize(),                             // Quais são as informações enviadas via script
                        success: function(data){ 
                            $('#pessoas').html(data);                                       // Havendo sucesso, executa a função response text
                            //atualizaTweet();
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
                        TWEETS <br/>1
                    </div>
                    <div class="col-md-6">
                        SEGUIDORES <br/>1
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