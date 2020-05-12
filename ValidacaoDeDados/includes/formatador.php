<?php

#Adicionando a máscara de CPF_CNPJ
function formataCpfCnpj($cpf_cnpj)
{

  $formatado = "";

  if (strlen($cpf_cnpj) == 11) {
    //cpf
    $formatado = substr($cpf_cnpj, 0, 3) . ".";
    $formatado .= substr($cpf_cnpj, 3, 3) . ".";
    $formatado .= substr($cpf_cnpj, 6, 3) . "-";
    $formatado .= substr($cpf_cnpj, 9, 2);
  } else {
    //cnpj
    $formatado = substr($cpf_cnpj, 0, 2) . ".";
    $formatado .= substr($cpf_cnpj, 2, 3) . ".";
    $formatado .= substr($cpf_cnpj, 5, 3) . "/";
    $formatado .= substr($cpf_cnpj, 8, 4) . "-";
    $formatado .= substr($cpf_cnpj, 12, 14);
  }
  return $formatado;
}

#Adicionando a máscara de CEP
function formataCep($cep)
{
  $formatado = "";
  $formatado = substr($cep, 0, 2) . ".";
  $formatado .= substr($cep, 2, 3) . "-";
  $formatado .= substr($cep, 5, 6);
  return $formatado;
}

#Adicionando a máscara de PREÇO
function formataPreco($preco)
{
  $formatado = "R$ ";

  #Afunção number_format() formata os números no padrão que for necessário
  #O ponto final é adiciono para separar a casa das unidades das restantes casas 
  #décimais, e a vírgula serve para separar as restantes casas décimais 
  $formatado .= number_format($preco, 2, ",", ".");
  return $formatado;
}

#Adicionando a máscara de DATA
function formataData($data)
{
  #A função strtotime() recebe como parâmetro uma string de formato 
  #de data em inglês e tenta analisar esse formato. É como tentar 
  #transformar uma frase que possui possíveis informações de data em uma data real  
  $formatado = date("d/m/Y", strtotime($data));
  return $formatado;
}

#Adicionando a máscara de TELEFONE  
function formataTelefone($telefone)
{
  $formatado = "";
  $formatado = "(" . substr($telefone, 0, 2) . ") ";
  $formatado .= substr($telefone, 2, -4);
  $formatado .= "-" . substr($telefone, -4);
  return $formatado;
}