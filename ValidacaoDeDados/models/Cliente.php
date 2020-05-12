<?php

require_once "ValidadorCPF.php";
require_once "ValidadorCNPJ.php";

class Cliente
{
  public $nome;
  public $cpf_cnpj;
  public $telefone;
  public $email;
  public $cep;
  public $endereco;
  public $bairro;
  public $numero;
  public $cidade;
  public $uf;

  public function __construct($nome, $cpf_cnpj, $telefone, $email, $cep, $endereco, $bairro, $numero, $cidade, $uf) 
  {
    $validadorCPF = new ValidadorCPF();
    $validadorCNPJ = new ValidadorCNPJ();

    //Validação CEP chamando o método de validação de cep
    if(!$this->cepValido($cep)) throw new Exception("CEP no formato inválido!");

    //Validação Telefone chamando o método de validação de telefone
    if(!$this->telefoneValido($telefone)) throw new Exception("Telefone no formato inválido!");

    //Validação e-mail chamando o método de validação de e-mail
    if(!$this->emailValido($email)) throw new Exception("Email no formato inválido!");

    //Validação do cpf_cnpj chamando o método de validação de cpf_cnpj
    if(strlen($cpf_cnpj) >= 14)
    {
      if(!$validadorCNPJ->ehValido($cpf_cnpj)) throw new Exception("CNPJ no formato inválido!");
    }
    else
    {
      if(!$validadorCPF->ehValido($cpf_cnpj)) throw new Exception("CPF no formato inválido!");
    }

    $this->nome = $nome;
    $this->cpf_cnpj = $this->removeFormatacao($cpf_cnpj);
    $this->telefone = $this->removeFormatacao($telefone);
    $this->email = $email;
    $this->cep = $this->removeFormatacao($cep);
    $this->endereco = $endereco;
    $this->bairro = $bairro;
    $this->numero = $numero;
    $this->cidade = $cidade;
    $this->uf = $uf;
  }

  #Validando cep
  public function cepValido(string $cep):string 
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
  public function telefoneValido(string $telefone): string
  {
    if(strlen($telefone) == 15)
    {
      $regex_telefone = "/^\([0-9]{2}\)[0-9]{5}\-[0-9]{4}$/";

      #O str_replace(" ", "", $telefone) está substituindo o espaço vazio entre
      #o parêntesis e o início do número do telefone por espaço nenhum
      return preg_match($regex_telefone, str_replace(" ", "", $telefone));
    }  
      return false;
  }

  #Validando e-mail
  public function emailValido(string $email): string
  {
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      return true;
    }  
      return false;
  }

  #Retirando a máscara de todos os dados para persistência no banco 
  public function removeFormatacao($info)
  {
    $dado = str_replace([".", "-", "/", "(", ")", " "], "", $info);
    return $dado;
  }

}
