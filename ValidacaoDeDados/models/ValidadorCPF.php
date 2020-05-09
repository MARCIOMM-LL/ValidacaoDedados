<?php

class ValidadorCPF
{

  #Método de validação
  public function ehValido($cpf)
  {

    #Se o método ehcpf($cpf) não é um cpf com máscara,
    #retorna um false
    if (!ValidadorCPF::ehCPF($cpf)) return false;

    #Retirando a máscara de cpf
    $cpf_numeros = ValidadorCPF::removeFormatacao($cpf);

    #Se o método verificaNumerosIguais($cpf) possuir
    #números iguais, retorna um false
    #Para realizar esse verificação precisamos em 
    #primeiro lugar retirar a máscara de cpf
    if (!ValidadorCPF::verificarNumerosIguais($cpf_numeros)) return false;

    #Se validarDigitos($cpf_numeros) não possuir todos os dígitos
    #do cpf, retorna um false
    if (!ValidadorCPF::validarDigitos($cpf_numeros)) return false;

    #Se nada retornar um false então está atendendo corretamente
    return true;
  }


  

  #Adicionar máscara de formatação de cpf
  private function ehCPF($cpf)
  {
    //123.456.789-10
    $regex_cpf = "/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/";
    return preg_match($regex_cpf, $cpf);
  }


  #Retirar a máscara de formatação para verificação de 
  #números repetidos sequencialmente
  private function removeFormatacao($cpf)
  {
    $somente_numeros = str_replace([".", "-"], "", $cpf);
    return $somente_numeros;
  }


  #Procurar por sequências de números iguais no cpf
  #se forem encontradas sequencias iguais, irá retornar um false
  private function verificarNumerosIguais($cpf)
  {

    #Esse loop vai verificar a sequencia de números
    #no cpf, se ele encontrar sequencias iguais, 
    #retornará um erro/false
    for ($i = 0; $i <= 11; $i++) {
      if (str_repeat($i, 11) == $cpf) return false;
    }

    return true;
  }


  #Método que faz a  validação de digitos
  private function validarDigitos($cpf)
  {

    $primeiro_digito = 0;
    $segundo_digito = 0;

    #Nesse loop irá ser percorrido o CPF de 0 a 8
    #que é o mesmo de 1 a 9, depois então o peso é
    #decrementado de 10 a 2 para casar com os números
    #do incremento e depois o cpf multiplicado pelo peso
    #e adicionado a variável primeiro dígito
    for ($i = 0, $peso = 10; $i <= 8; $i++, $peso--) 
    {
      $primeiro_digito = $primeiro_digito + $cpf[$i] * $peso;
    }

    for ($i = 0, $peso = 11; $i <= 9; $i++, $peso--) 
    {
      $segundo_digito = $segundo_digito + $cpf[$i] * $peso;
    }

    #Abaixo é realizada uma operação ternária para realizar 
    #a fórmula matemática do cpf
    #Começando por pegar o resto da divisão entre primeiro_digito 
    #e 11, depois se o resto não for menor que 2 ele será 0 
    #senão, ele será 11 menos o primeiro_digito
    $calculo_um = (($primeiro_digito % 11) < 2) ? 0 : 11 - ($primeiro_digito % 11);
    $calculo_dois = (($segundo_digito % 11) < 2) ? 0 : 11 - ($segundo_digito % 11);

    #Nessa estrutura condicional, é avaliado se o valor resultante de cálculo matemático.
    #Se calculo_um é diferente da  posição "9" que corresponde à possição 10 de cpf, e se 
    #calculo_dois é diferente da posição "10" que corresponde à possição 11 de cpf. 
    #É porque um dos dois dígitos pode estar errado. E para seguir em diante,
    #um dos dois dígitos tem que corresponder ao esperado nos loops acima
    if ($calculo_um <> $cpf[9] || $calculo_dois <> $cpf[10]) return false;

    return true;
  }
}
