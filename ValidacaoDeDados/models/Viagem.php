<?php

class Viagem
{
  public $origem;
  public $destino;
  public $data_ida;
  public $data_volta;
  public $classe;
  public $adultos;
  public $criancas;
  public $preco;

  public function __construct($origem, $destino, $data_ida, $data_volta, $classe, $adultos, $criancas, $preco) 
  {

    #Validando a data de ida
    if(!$this->dataValida($data_ida)) throw new Exception("Data de ida inválido!");

    #Validando a data de volta
    if(!$this->dataValida($data_volta)) throw new Exception("Data de ida inválido!");

    #Validando o preço
    if(!$this->precoValido($preço)) throw new Exception("Preço inválido!");

    $this->origem = $origem;
    $this->destino = $destino;
    $this->data_ida = $data_ida;
    $this->data_volta = $data_volta;
    $this->classe = $classe;
    $this->adultos = $adultos;
    $this->criancas = $criancas;
    $this->preco = $preco;
  }

  public function dataValida(string $data): string
  {
    #A data precisa obedecer a esse formato 2010-01-19 
    #que vai ser subtituido por esse padrão de entrada 20-09-2020
    if(strlen($data) <> 10) return false;

    #O método strpos($data, "-") vai procurar a ocorrência de hífen 
    #dentro de $data e, se não possuir, retorna um false
    if(!strpos($data, "-")) return false;

    #O método explode("-", $data) vai separar a $data em partes,
    #como por exemplo ano, mês e dia. Para isso é passada a
    #referência "-" em $data, para que ele começe a realizar
    #a separação a partir do hífen
    $partes = explode("-", $data);

    #Aqui é adicionado cada parte que compõe uma data 
    #dividida em um array através do método explode()
    $ano = $partes[0];
    $mes = $partes[1];
    $dia = $partes[2];

    #Verificando se o ano possui os 4 dígitos
    if(strlen($ano) < 4) return false;

    #O método checkdate() certifica se o mês, o dia e o ano 
    #estão de acordo com o esperado em uma data normal
    if(!checkdate($mes, $dia, $ano)) return false;

    #Método date("Y-m-d") está retornando o ano com os
    #4 dígitos no formato esperado e o restante da data atual
    $data_atual = date("Y-m-d");

    #Nessa estrutura condicional, é comparada a data passada
    #pelo usuário pela data atual. Se a data passada pelo 
    #usuário for menos que a data atual, é retornado um false
    #O método strtotime(), está convertendo as datas que estáo
    #em um padrão de string para um padrão de datas com o 
    #método strtotime()
    if(strtotime($data) < strtotime($data_atual)) return false;

    return true;
  }
 
  public function precoValido(float $preco): float
  {
    #O acento circunflexo e o cifrão, estão dizendo antes e 
    #depois do preço não existe nada para além de números 
    #Na primeira ocorrencia da regular expression, na primeira
    #casa de números podemos ter de 1 até 3 dígitos, e na segunda
    #casa de números definimos só 2 casas décimais, porém se 
    #quisermos ter dais de 1 casa décimal tanto na primeira
    #casa como nas demais casas décimais, temos essa expressão 
    #regular que escrevemos no meio das 2 casas décimais.
    #O ponto final significa de depois da primeira casa,
    #vamos ter outra casa décimal, depois do 0 até 9,
    #colocamos as 3 casas décimais que quereos usar.
    #O * fala que podemos usar as 3 casas décimais infinitas 
    #vezes sempre que quisermos representar um valor acima
    #de 2,000.00 
    $regex_preco = "/^[0-9]{1,3} ([.][0-9]{3})* [,] [0-9]{2}$/";
    return preg_match($regex_preco, $preco);
  }

}
