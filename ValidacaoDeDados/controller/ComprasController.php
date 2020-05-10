<?php

require_once("models/Viagem.php");
require_once("models/Cliente.php");

if ($_REQUEST) {

  $origem = $_REQUEST['origem'];
  $destino = $_REQUEST['destino'];
  $data_ida = $_REQUEST['data_ida'];
  $data_volta = $_REQUEST['data_volta'];
  $classe = $_REQUEST['classe'];
  $adultos = $_REQUEST['adultos'];
  $criancas = $_REQUEST['criancas'];
  $preco = "1.500,35";

  $nome = $_REQUEST['nome'];
  $cpf_cnpj = $_REQUEST['cpf_cnpj'];
  $telefone = $_REQUEST['telefone'];
  $email = $_REQUEST['email'];
  $cep = $_REQUEST['cep'];
  $endereco = $_REQUEST['endereco'];
  $bairro = $_REQUEST['bairro'];
  $numero = $_REQUEST['numero'];
  $cidade = $_REQUEST['cidade'];
  $uf = $_REQUEST['uf'];

  try
  {
    $cliente = new Cliente($nome, $cpf_cnpj, $telefone, $email, $cep, $endereco, $bairro, $numero, $cidade, $uf);
    $viagem = new Viagem($origem, $destino, $data_ida, $data_volta, $classe, $adultos, $criancas, $preco);
  }
  catch(Exception $error)
  {
    echo "<script>alert('" . $error->getMessage() . "')</script>";
    echo "<script>history.back()</script>";
  }

}
