<?php
// Configurações de conexão com o banco de dados
$dbHost = 'localhost'; // Nome do host do banco de dados
$dbName = 'form_php'; // Nome do banco de dados
$dbUser = 'root'; // Nome de usuário do banco de dados
$dbPass = ''; // Senha do banco de dados

try {
    // Cria uma nova instância da classe PDO para estabelecer a conexão com o banco de dados
    $conexao = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
     // Define o modo de erro do PDO para lançar exceções em caso de erros
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Desativa a emulação de prepared statements para evitar possíveis vulnerabilidades de segurança
    $conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} 
// Se ocorrer uma exceção durante a conexão, exibe a mensagem de erro
catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    exit();
}


