<?php

function getAsciiNum($c)
{
    return ord($c);
}

function getAsciiChar($num)
{
    return chr($num);
}

function letraAleatoria($string)
{
    return substr(str_shuffle($string), 0, 1);
}

function s2a($string)
{
    $arr = str_split($string);
    return $arr;
}

function multiexplode($delimiters, $string)
{

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

//função para criptografia
function crypto($file, $senha)
{
    // abre arquivo
    $data = fopen($file, 'rb');
    $size = filesize($file);
    // lê arquivo
    $contents = fread($data, $size);
    fclose($data);

    // converte para base64
    // ->por causa de arquivos que não são texto
    // melhor manipulação
    $baseado = base64_encode($contents);

    // regra 1.
    // se o tamanho da senha for impar
    $tamSenha = strlen($senha);
    // inverte
    if ($tamSenha % 2) {
        $baseado = strrev($baseado);
    }

    // variável final é a concatenação de uma letra aleatória com 
    // os chars do base64 em números da tabela ASCII
    // tabela ASCII!=tabela de base64
    $final = "";
    for ($i = 0; $i < $size; $i++) {
        $letra = letraAleatoria($senha);
        $final .= getAsciiNum($baseado[$i]) . $letra;
    }
    // saída da string criptografada
    return $final;
}
function disponibilizaDownload($arquivo, $nome, $type)
{
    file_put_contents($nome, $arquivo);
    echo "<a href=$nome type=$type target='_blank'>Criptografia pronta!</a>";
}
if ($_POST) {
    $senha = $_POST['senha'];
    // die();
    if ($_FILES['arquivo']['size'] > 0) {
        $file = $_FILES['arquivo'];

        $extNomeArr = explode(".", $file['name']);
        // crypt(caminho, senha)
        $conteudo = crypto($file['tmp_name'], $senha);
        // novonome é o timestamp para que seja menos possível saber qual arquivo é
        $novoNome = time() . "." . $extNomeArr[1];
        // disponibiliza download
        disponibilizaDownload($conteudo, $novoNome, $file['type']);
    } else {
        echo "Por favor, insira um arquivo válido.";
    }
} else {
    echo "Por favor, digite uma senha.";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CryptOn</title>
</head>

<body>
    <h1>CryptOn</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <p>Digite sua senha para criptografar:</p>
        <input type="text" name="senha" id="senha" placeholder="senha">
        <p>Arquivo a ser criptografado</p>
        <input type="file" name="arquivo" id="arquivo">
        <input type="submit" name="Enviar">
    </form>
    <h3>Deseja descriptografar?</h3>
    <p><a href="index2.php">Se sim, clique aqui</a></p>
</body>

</html>