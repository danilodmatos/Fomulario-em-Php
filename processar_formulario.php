<?php
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
