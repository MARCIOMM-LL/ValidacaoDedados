<?php

class ValidadorCNPJ
{
  #Método de validação
  public function ehValido(string $cnpj)
  {
    #Se o método ehcpf($cnpj) não é um cpf com máscara, retorna um false
    if (!ValidadorCNPJ::ehCNPJ($cnpj)) return false;

    #Retirando a máscara de cnpj
    $cnpj_numeros = ValidadorCNPJ::removeFormatacao($cnpj);

    #Se o método verificaNumerosIguais($cnpj) possuir números iguais, retorna um false
    #Para realizar esse verificação precisamos em primeiro lugar retirar a máscara de cnpj
    if (!ValidadorCNPJ::verificarNumerosIguais($cnpj_numeros)) return false;

    #Se validarDigitos($cnpj_numeros) não possuir todos os dígitos do cnpj, retorna um false
    if (!ValidadorCNPJ::validarDigitos($cnpj_numeros)) return false;

    #Se nada retornar um false então está atendendo corretamente
    return true;
  }

  #Adicionar máscara de formatação de cnpj
  private function ehCNPJ(string $cnpj): string 
  {
    //12.345.678/0001-94
    $regex_cnpj = "/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$/";
    return preg_match($regex_cnpj, $cnpj);
  }

  #Retirar a máscara de formatação para verificação de números repetidos sequencialmente
  private function removeFormatacao(string $cnpj): int
  {
    $somente_numeros = str_replace([".", "/", "-"], "", $cnpj);
    return $somente_numeros;
  }

  #Procurar por sequências de números iguais no cnpj se forem encontradas 
  #sequencias iguais, retornar um false
  private function verificarNumerosIguais(string $cnpj): string 
  {
    #Esse loop vai verificar a sequencia de números no cnpj, se ele 
    #encontrar sequencias iguais, retornará um erro/false
    for ($i = 0; $i <= 14; $i++) 
    {
      if (str_repeat($i, 14) == $cnpj) return false;
    }

    return true;
  }

  #Método que faz a validação de digitos
  private function validarDigitos(string $cnpj): string 
  {
    $primeiro_digito = 0;
    $segundo_digito = 0;

    #Nesse ciclo for, vão ser avaliados os primeiros 12 dígitos do CNPJ. A variável $i vai 
    #ser percorrida de 0 até 11 que é o mesmo que ser percorrida de 1 até 12 no CNPJ, depois 
    #então é feito o incremento de $i e o decremento de $peso. Se o $peso for menor que 2 
    #enquanto for decrescendo, é retornado o valor 9, senão, é retornado o valor atual do $peso 
    #que continua decrementando do 9 em diante
    #Aqui no loop for, a variável $peso começa a decrementar sobre $i de 5 até 2, e depois
    #continua de 9 até 2 de novo
    for ($i = 0, $peso = 5; $i <= 11; $i++, $peso--) 
    {
      #Operação ternária para fazer comparação entre o resto da divisão e o peso.
      #Se o resto da divisão for menor que 2, o resultado será 0. Senão, se o resultado
      #for maior que dois, esse será o resultado
      #Aqui na operação ternária é para $peso decrementar de $i de 5 até 2 e, depois 9 até 2 de novo 
      $peso = ($peso < 2) ? 9 : $peso;
      $primeiro_digito += $cnpj[$i] * $peso;
    }

    for ($i = 0, $peso = 6; $i <= 12; $i++, $peso--) 
    {
      $peso = ($peso < 2) ? 9 : $peso;
      $segundo_digito += $cnpj[$i] * $peso;
    }

    #Abaixo é realizada uma operação ternária para realizar a fórmula matemática do cnpj
    #Começando por pegar o resto da divisão entre primeiro_digito e 11, depois se o resto 
    #não for menor que 2 ele será 0 senão, ele será 11 menos o primeiro_digito
    $calculo_um = (($primeiro_digito % 11) < 2) ? 0 : (11 - ($primeiro_digito % 11));
    $calculo_dois = (($segundo_digito % 11) < 2) ? 0 : (11 - ($segundo_digito % 11));

    #Nessa estrutura condicional, é avaliado se o valor resultante de cálculo matemático.
    #Se calculo_um é diferente da  posição "12" que corresponde à possição 13 de cnpj, e se 
    #calculo_dois é diferente da posição "13" que corresponde à possição 14 de cnpj. 
    #É porque um dos dois dígitos pode estar errado. E para seguir em diante,
    #um dos dois dígitos tem que corresponder ao esperado nos loops acima
    if ($calculo_um <> $cnpj[12] || $calculo_dois <> $cnpj[13]) 
    {
      return false;
    } 
    else 
    {
      return true;
    }
  }
}
