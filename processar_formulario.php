<?php
// Inclui o arquivo 'banco.php' que contém as configurações de conexão com o banco de dados e estabelece uma conexão
include_once('banco.php');

// Recupera os dados do formulário usando o superglobal $_POST e atribui-os a variáveis
$nome = $_POST['nome'];
$data_nascimento = $_POST['data_nascimento'];
$sexo = $_POST['sexo'];
$endereco = $_POST['endereco'];
$faculdade = $_POST['faculdade'];
$atividade_fisica = $_POST['atividade_fisica'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Consulta SQL INSERT para inserir os dados do formulário em uma tabela chamada 'for_php'
$query = "INSERT INTO for_php(nome, data_nascimento, sexo, endereco, faculdade_desejada, atividade_fisica, email, senha) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

try {
    // Preparar a consulta (prepara a query)
    $statement = $conexao->prepare($query);

    // Vincula os parâmetros (Bind dos parâmetros)
    $statement->bindParam(1, $nome);
    $statement->bindParam(2, $data_nascimento);
    $statement->bindParam(3, $sexo);
    $statement->bindParam(4, $endereco);
    $statement->bindParam(5, $faculdade);
    $statement->bindParam(6, $atividade_fisica);
    $statement->bindParam(7, $email);
    $statement->bindParam(8, $senha);

    //Executa a consulta (Executa a query)
    $statement->execute();

    // Exibe mensagem de sucesso
    echo "<p>Dados inseridos com sucesso!</p>";
} catch (PDOException $e) {
    // Exibe mensagem de erro
    echo "<p>Ocorreu um erro ao inserir os dados: " . $e->getMessage() . "</p>";
}

// Função para tratar os campos dos formulários e garantir a segurança dos dados
function tratarCampo($campo, $valor) {
    // Remove espaços extras do valor do campo
    $valor = trim($valor);
    // Converte caracteres especiais para entidades HTML
    $valor = htmlspecialchars($valor);

    switch ($campo) {
        case 'nome':
            // Remove qualquer coisa que não seja uma letra ou espaço
            $valor = preg_replace('/[^a-zA-Z\sÀ-úçãõ]/u', '', $valor);
            break;

        case 'endereco':
            // Remove qualquer coisa que não seja uma letra, número, espaço ou caracteres especiais permitidos
            $valor = preg_replace('/[^a-zA-Z0-9\s\.,\-À-úçãõ]/u', '', $valor);
            break;

        case 'faculdade':
            // Remove qualquer coisa que não seja uma letra, número, espaço ou caracteres especiais permitidos
            $valor = preg_replace('/[^a-zA-Z0-9\s\.,\-À-úçãõ]/u', '', $valor);
            break;

        case 'atividade_fisica':
            // Remove qualquer coisa que não seja uma letra, espaço ou caracteres especiais permitidos
            $valor = preg_replace('/[^a-zA-Z\s\.,\-À-úçãõ]/u', '', $valor);
            break;

        case 'email':
            // Verifica se o valor é um formato de e-mail válido
            $valor = filter_var($valor, FILTER_VALIDATE_EMAIL);
            break;

        case 'senha':
            // Encripta a senha usando a função password_hash()
            $valor = password_hash($valor, PASSWORD_DEFAULT);
            break;

        default:
            // Não é necessário realizar tratamento adicional para outros campos
            break;
    }

    return $valor;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $dados = $_POST;

    // Trata os dados para garantir segurança
    $dadosTratados = array_map('tratarCampo', array_keys($dados), $dados);
}

// Exibição dos dados recebidos
echo "<h1>Dados Recebidos:</h1>";
foreach ($dadosTratados as $campo => $valor) {
    echo "<p><strong>" . ucfirst($campo) . ":</strong> " . $valor . "</p>";
}

// Verifica a senha fornecida pelo usuário
if (isset($_POST['senha']) && isset($dadosTratados['senha'])) {
    $senhaUsuario = $_POST['senha'];
    $senhaArmazenada = $dadosTratados['senha'];

    if (password_verify($senhaUsuario, $senhaArmazenada)) {
        echo "<p>Senha correta!</p>";
    } else {
        echo "<p>Senha incorreta!</p>";
    }
} 

//---------------------------------------------------------------------------------------------------------
/*Bloco 1: Definindo a função tratarCampo

Neste bloco, estamos criando uma função chamada tratarCampo.
Essa função recebe dois parâmetros: $campo e $valor, que representam o nome do campo do formulário e o valor associado a esse campo.
A função realiza algumas operações de tratamento nos valores, como remoção de espaços extras e conversão de caracteres especiais para entidades HTML.
Em seguida, usamos uma estrutura chamada switch para executar diferentes ações dependendo do valor do campo.

Bloco 2: Tratando os dados recebidos
Neste bloco, verificamos se a requisição foi feita pelo método POST, ou seja, se o formulário foi submetido.
Se for uma requisição POST, recebemos os dados do formulário na variável $dados.
Usamos a função array_map para aplicar a função tratarCampo a cada par chave/valor do array $dados.
O resultado é armazenado na variável $dadosTratados, que contém os dados tratados e seguros.

Bloco 3: Exibindo os dados recebidos
Neste bloco, estamos exibindo os dados recebidos do formulário tratados e seguros.
Usamos um laço de repetição foreach para percorrer cada campo e valor em $dadosTratados.
Para cada campo, exibimos o nome do campo (com a primeira letra em maiúscula) e o valor correspondente.

Bloco 4: Verificando a senha fornecida
Neste bloco, estamos verificando se a senha fornecida pelo usuário está correta.
Primeiro, verificamos se os campos 'senha' existem no array $_POST e $dadosTratados.
Se existirem, armazenamos a senha fornecida pelo usuário na variável $senhaUsuario e a senha armazenada (previamente criptografada) na variável $senhaArmazenada.
Usamos a função password_verify para comparar a senha fornecida com a senha armazenada. Se forem iguais, exibimos a mensagem "Senha correta!". Caso contrário, exibimos a mensagem "Senha incorreta!".*/