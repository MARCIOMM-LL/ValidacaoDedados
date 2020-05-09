<?php

require_once "ValidadorCPF.php";
require_once "ValidadorCNPJ.php";

class Cliente
{
  var $nome;
  var $cpf_cnpj;
  var $telefone;
  var $email;
  var $cep;
  var $endereco;
  var $bairro;
  var $numero;
  var $cidade;
  var $uf;

  function __construct($nome, $cpf_cnpj, $telefone, $email, $cep, $endereco, $bairro, $numero, $cidade, $uf) 
  {
    $validadorCPF = new ValidadorCPF();
    $validadorCNPJ = new ValidadorCNPJ();

    //Validação CEP
    if(!$this->cepValido($cep)) throw new Exception("CEP no formato inválido!");

    //Validação Telefone
    if(!$this->telefoneValido($telefone)) throw new Exception("Telefone no formato inválido!");

    //Validação email
    if(!$this->emailValido($email)) throw new Exception("Email no formato inválido!");

    //Validação do cpf_cnpj
    if(strlen($cpf_cnpj) >= 14)
    {
      if(!$validadorCNPJ->ehValido($cpf_cnpj)) throw new Exception("CNPJ no formato inválido!");
    }
    else
    {
      if(!$validadorCPF->ehValido($cpf_cnpj)) throw new Exception("CPF no formato inválido!");
    }

    $this->nome = $nome;
    $this->cpf_cnpj = $cpf_cnpj;
    $this->telefone = $telefone;
    $this->email = $email;
    $this->cep = $cep;
    $this->endereco = $endereco;
    $this->bairro = $bairro;
    $this->numero = $numero;
    $this->cidade = $cidade;
    $this->uf = $uf;
  }

  #Validando cep
  public function cepValido($cep)
  {
    if(strlen($cep) == 10)
    {
      $regex_cep = "/^[0-9]{2}\.[0-9]{3}\-[0-9]{3}$/";
      
      #A função preg_match verifica se a variável $regex_cep está 
      #dentro da variável $cep 
      return preg_match($regex_cep, $cep);
    }  
      return false;
  }

  #Validando telefone
  public function telefoneValido($telefone)
  {
    if(strlen($telefone) == 15)
    {
      $regex_telefone = "/\([0-9]{2}\)[0-9]{5}\-[0-9]{4}/";
      return preg_match($regex_telefone, str_replace(" ", "", $telefone));
    }  
      return false;
  }

  #Validando e-mail
  public function emailValido($email)
  {
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      return true;
    }  
      return false;
  }

}
