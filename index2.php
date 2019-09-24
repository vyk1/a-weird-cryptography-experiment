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
    // print_r($string);
    $arr = str_split($string);
    return $arr;
}

function multiexplode($delimiters, $string)
{

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

function descrypto($file, $senha)
{
    // abre arquivo
    $data = fopen($file, 'rb');
    $size = filesize($file);
    // lê arquivo
    // aqui fica o arquivo criptografado
    // com as letras e números criptografados
    $contents = fread($data, $size);
    fclose($data);
    // if ($file) {
    //     # code...
    // }
    // print_r($file);
    // criptografa porém filetype não rola
    // converte senha em array de chars
    $arrayDChars = s2a($senha);
    // print_r($arrayDChars);
    // para tirar os chars da senha arquivo criptografado
    $explodido = multiexplode($arrayDChars, $contents);
    // print_r($explodido);

    // die();
    $desc = "";
    foreach ($explodido as $num) {
        $desc .= getAsciiChar($num);
    }

    $tamSenha = strlen($senha);
    if ($tamSenha % 2) {
        $desc = strrev($desc);
    }
    // echo $desc;
    return base64_decode($desc);
}

function disponibilizaDownload($arquivo, $nome, $type)
{
    file_put_contents($nome, $arquivo);
    echo "<a href=$nome type=$type target='_blank'>Descriptografia pronta!</a>";
}
if ($_POST) {
    $senha = $_POST['senha'];

    if ($_FILES['arquivo']['size'] > 0) {

        $file = $_FILES['arquivo'];
        $extNomeArr = explode(".", $file['name']);
        $novoNome = time() . "." . $extNomeArr[1];

        $conteudo = descrypto($file['tmp_name'], $senha);
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
    <title>CryptOff</title>
</head>

<body>
    <h1>CryptOff</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <p>Digite sua senha para descriptografar:</p>
        <input type="text" name="senha" id="senha" placeholder="senha">
        <p>Arquivo a ser descriptografado</p>
        <input type="file" name="arquivo" id="arquivo">
        <input type="submit" name="Enviar">
    </form>
    <h3>Deseja criptografar?</h3>
    <p><a href="index.php">Se sim, clique aqui</a></p>
</body>

</html>