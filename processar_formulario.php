<?php
function tratarDados($dados) {
    foreach ($dados as $campo => $valor) {
         // Remove espaços extras do valor do campo
        $valor = trim($valor);
        // Converte caracteres especiais para entidades HTML
        $valor = htmlspecialchars($valor);

        switch ($campo) { //O switch é uma estrutura de controle que permite executar diferentes blocos de código dependendo do valor de uma variável.
            case 'nome':
                // Verifica se o campo é 'nome'
                // Remove qualquer coisa que não seja uma letra ou espaço
                // executará uma expressão regular para permitir apenas letras e espaços
                $valor = preg_replace('/[^a-zA-Z\s < >]/', '', $valor);
                break;

            case 'endereco':
                // Verifica se o campo é 'endereco'
                // Remove qualquer coisa que não seja uma letra, número, espaço ou caracteres especiais permitidos
                // executará uma expressão regular para permitir apenas letras, números, espaços e caracteres especiais permitidos
                $valor = preg_replace('/[^a-zA-Z0-9\s\.,\- < >]/', '', $valor);
                break;

            case 'faculdade':
                // Verifica se o campo é 'faculdade'
                // Remove qualquer coisa que não seja uma letra, número, espaço ou caracteres especiais permitidos
                // executará uma expressão regular para permitir apenas letras, números, espaços e caracteres especiais permitidos
                $valor = preg_replace('/[^a-zA-Z0-9\s\.,\- < >]/', '', $valor);
                break;

            case 'atividade_fisica':
                //Verifica se o campo é 'atividade_fisica'
                // Remove qualquer coisa que não seja uma letra, espaço ou caracteres especiais permitidos
                // executará uma expressão regular para permitir apenas letras, espaços e caracteres especiais permitidos
                $valor = preg_replace('/[^a-zA-Z\s\.,\- < >]/', '', $valor);
                break;

            case 'email':
                // Verifica se o campo é 'email'
                // Verifica se o valor é um formato de e-mail válido
                // executará a função filter_var() com o filtro FILTER_VALIDATE_EMAIL para validar o formato de e-mail
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
        // Atualiza o valor tratado no array de dados
        $dados[$campo] = $valor;
    }

    return $dados;
}


// Está verificando se a requisição foi feita pelo método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $dados = $_POST;

    // Trata os dados para garantir segurança
    $dadosTratados = tratarDados($dados);
}


// Exibição dos dados recebidos
echo "<h1>Dados Recebidos:</h1>";
echo "<p><strong>Nome:</strong> " . $dadosTratados['nome'] . "</p>";
echo "<p><strong>Data de Nascimento:</strong> " . $dadosTratados['data_nascimento'] . "</p>";
echo "<p><strong>Sexo:</strong> " . $dadosTratados['sexo'] . "</p>";
echo "<p><strong>Endereço:</strong> " . $dadosTratados['endereco'] . "</p>";
echo "<p><strong>Faculdade que deseja cursar:</strong> " . $dadosTratados['faculdade'] . "</p>";
echo "<p><strong>Atividade física que pratica:</strong> " . $dadosTratados['atividade_fisica'] . "</p>";
echo "<p><strong>E-mail:</strong> " . $dadosTratados['email'] . "</p>";

// Verifica a senha fornecida pelo usuário
$senhaUsuario = $_POST['senha'];
$senhaArmazenada = $dadosTratados['senha'];

if (password_verify($senhaUsuario, $senhaArmazenada)) {
    echo "<p>Senha correta!</p>";
} else {
    echo "<p>Senha incorreta!</p>";
}
?>
