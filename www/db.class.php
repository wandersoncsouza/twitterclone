<?php
class db{
    private $host = 'localhost';            // host address
    private $usuario = 'root';              // usuario do banco
    private $senha = '';                    // senha do banco de dados
    private $database = 'twitter_clone';    // nome do banco de dados

    public function conecta_mysql(){
        $conn = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);                 // Criar conexão ao banco
        mysqli_set_charset($conn, 'utf8');  // Ajustar o charset de comunicação entra a aplicação eo banco de dados

        if(mysqli_connect_errno()){        // Verificar se houve erro de conexão
            echo 'Erro ao se conectar ao banco de dados'.mysqli_connect_error();
        }
        return $conn;
    }
}
?>