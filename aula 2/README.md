# Aula 2 — Fundamentos da linguagem PHP

Este material explica, de forma didática, os exemplos apresentados no arquivo [`index.php`](index.php). O conteúdo introduz a sintaxe do PHP, as principais formas de exibir informações, os tipos de dados, o funcionamento das variáveis e a criação de constantes.

## Objetivos da aula

Ao concluir esta aula, espera-se que você consiga:

- reconhecer os delimitadores de um código PHP;
- utilizar `echo` e `print` para gerar uma saída HTML;
- escrever comentários no código;
- concatenar textos e valores;
- identificar os oito tipos primitivos apresentados;
- compreender os escopos local, global e estático;
- criar e acessar variáveis dinâmicas;
- reconhecer as principais variáveis superglobais;
- declarar e utilizar constantes.

## Como executar o exemplo

O PHP é executado no servidor. Portanto, abrir o arquivo diretamente no navegador não interpreta o código: é necessário utilizar um servidor com PHP.

Se o PHP estiver instalado e disponível no terminal, entre na pasta da aula e execute:

```bash
php -S localhost:8000
```

Depois, acesse no navegador:

```text
http://localhost:8000
```

Os títulos impressos antes de cada bloco ajudam a separar visualmente os exemplos na página.

---

## Bloco 1 — Sintaxe básica e delimitadores PHP

Um trecho de código PHP começa com o delimitador `<?php` e pode terminar com `?>`:

```php
<?php
echo "Olá mundo!<br/>";
?>
```

Tudo o que está dentro desses delimitadores é interpretado pelo PHP. Conteúdos escritos fora deles são enviados diretamente ao navegador como HTML.

### Ponto e vírgula

O ponto e vírgula (`;`) indica o final de uma instrução:

```php
echo "Olá mundo!";
```

Esquecê-lo normalmente provoca um erro de sintaxe.

### Letras maiúsculas e minúsculas

Os nomes das variáveis são sensíveis a maiúsculas e minúsculas. Assim, as variáveis abaixo são diferentes:

```php
$nome = "Ana";
$Nome = "Carlos";
```

No exemplo da aula, `<br/>` é uma tag HTML que produz uma quebra de linha no navegador.

---

## Bloco 2 — Instruções de saída: `echo` e `print`

As instruções `echo` e `print` enviam conteúdo para a saída, que geralmente é o navegador.

### `echo`

Pode ser utilizado com ou sem parênteses:

```php
echo("Prefiro o calor do que frio<br/>");
echo "Prefiro o calor do que frio<br/>";
```

`echo` é uma construção da linguagem e não possui valor de retorno.

### `print`

Também pode ser escrito com ou sem parênteses:

```php
print("Prefiro o calor do que frio<br/>");
print "Prefiro o calor do que frio<br/>";
```

`print` sempre retorna o valor inteiro `1`. Na maioria das situações simples, a escolha entre `echo` e `print` não produz uma diferença prática perceptível. É comum utilizar `echo`.

### Interpolação de variáveis

Uma variável colocada dentro de uma string delimitada por aspas duplas tem seu valor inserido no texto:

```php
$clima2 = "calor";
print "Prefiro o calor do que $clima2<br/>";
```

A saída será:

```text
Prefiro o calor do que calor
```

Strings entre aspas simples, por outro lado, normalmente exibem o conteúdo literalmente:

```php
echo '$clima2'; // Exibe: $clima2
```

---

## Bloco 3 — Sintaxe de comentários

Comentários documentam o código e são ignorados pelo interpretador PHP.

### Comentários de uma linha

Podem começar com duas barras (`//`) ou com cerquilha (`#`):

```php
// Comentário de uma linha
# Outra forma de comentar uma linha
```

### Comentários de várias linhas

São delimitados por `/*` e `*/`:

```php
/*
   Este comentário
   ocupa várias linhas.
*/
```

Comentários devem explicar decisões, regras ou trechos que não sejam evidentes. Eles não devem substituir nomes claros para variáveis e funções.

---

## Bloco 4 — Concatenação em PHP

Concatenar significa unir valores para formar uma string maior. Em PHP, o operador de concatenação é o ponto (`.`).

### Operador ponto

```php
$dia = 14;
$mes = "abril";
$ano = 1912;

$anocompleto = $dia . " de " . $mes . " de " . $ano;
echo $anocompleto . "<br/>";
```

O resultado é:

```text
14 de abril de 1912
```

O PHP converte os números para texto ao realizar a concatenação.

### Operador de atribuição concatenada `.=`

O operador `.=` acrescenta um novo conteúdo ao valor que a variável já possui:

```php
$anocompleto2 = 14;
$anocompleto2 .= " de abril de ";
$anocompleto2 .= 1912;
```

Essa forma equivale, de maneira simplificada, a:

```php
$anocompleto2 = $anocompleto2 . " de abril de ";
```

---

## Bloco 5 — Variáveis e tipos de dados

Uma variável PHP começa com o símbolo `$`, seguido por uma letra ou sublinhado. O tipo não precisa ser declarado explicitamente, pois o PHP determina o tipo a partir do valor atribuído.

```php
$idade = 20;       // integer
$nome = "Maria";  // string
```

O arquivo apresenta oito tipos, organizados em escalares, compostos e especiais.

### Tipos escalares

#### 1. Boolean

Representa um valor lógico: `true` ou `false`.

```php
$_varBool = true;
```

É bastante utilizado em condições e para representar estados, como ativo/inativo.

#### 2. Integer

Representa números inteiros. O exemplo mostra diferentes notações:

```php
$a_dec = 1234; // decimal
$a_neg = -123; // negativo
$a_oct = 0123; // octal: 83 em decimal
$a_hex = 0x1A; // hexadecimal: 26 em decimal
```

O prefixo `0` indica a notação octal e o prefixo `0x` indica a hexadecimal. Em código moderno, é importante ter atenção ao zero inicial para evitar interpretações inesperadas.

#### 3. Float

Representa números com parte decimal ou escritos em notação científica:

```php
$f1 = 1.234;
$f2 = 1.2e3; // 1200
$f3 = 7E-10;
```

Valores `float` possuem precisão limitada. Por isso, cálculos financeiros normalmente exigem técnicas ou bibliotecas apropriadas.

#### 4. String

Representa uma sequência de caracteres:

```php
$_varString = "Hello world!!";
```

### Tipos compostos

#### 5. Array

Um array armazena vários valores e relaciona cada valor a uma chave:

```php
$arr = array("foo" => "bar", 12 => true);
```

Os valores são acessados por suas respectivas chaves:

```php
echo $arr["foo"]; // bar
echo $arr[12];    // true
```

O operador ternário usado no arquivo converte o booleano em um texto mais claro:

```php
echo $arr[12] ? "true" : "false";
```

#### 6. Object

Um objeto é uma instância de uma classe. A classe funciona como um modelo que reúne dados e comportamentos:

```php
class Teste {
    function hello() {
        echo "Hello World vindo de um Objeto!!<br/>";
    }
}

$objeto = new Teste;
$objeto->hello();
```

Nesse exemplo:

- `class Teste` declara a classe;
- `new Teste` cria um objeto;
- `->` acessa um método ou uma propriedade do objeto;
- `hello()` é o método executado.

### Tipos especiais

#### 7. Resource

Um `resource` representa uma referência para um recurso externo, como um arquivo aberto ou, dependendo da extensão utilizada, uma conexão externa. Em geral, ele é criado por uma função específica do PHP.

#### 8. NULL

`NULL` representa a ausência de valor:

```php
$varNula = NULL;
```

Por convenção moderna, costuma-se escrever `null` em letras minúsculas, embora a palavra-chave não diferencie maiúsculas de minúsculas.

---

## Bloco 6 — Escopo de variáveis

O escopo determina em quais partes do programa uma variável pode ser acessada.

### Variável local

Uma variável criada dentro de uma função pertence ao escopo local dessa função:

```php
function quadradoLocal() {
    $numeroLocal = 3;
    $numeroLocal = $numeroLocal * $numeroLocal;
}
```

`$numeroLocal` deixa de estar disponível quando a execução da função termina. Tentar acessá-la fora da função gera um aviso de variável indefinida.

### Variável global

Uma variável criada fora de uma função pertence ao escopo global. Para modificá-la dentro de uma função, o exemplo utiliza a palavra-chave `global`:

```php
$numeroGlobal = 3;

function quadradoGlobal() {
    global $numeroGlobal;
    $numeroGlobal = $numeroGlobal * $numeroGlobal;
}
```

Depois da chamada de `quadradoGlobal()`, o valor de `$numeroGlobal` será `9`.

O uso excessivo de variáveis globais pode dificultar a manutenção do programa. Em aplicações maiores, é preferível passar valores como parâmetros e retorná-los explicitamente.

### Variável estática

Uma variável local normalmente é recriada sempre que a função é chamada. A palavra-chave `static` faz com que ela preserve seu valor entre as chamadas:

```php
function somatorio() {
    static $soma = 0;
    $soma = $soma + 1;
    echo $soma;
}
```

Ao chamar a função três vezes, os valores exibidos serão `1`, `2` e `3`.

### Variável dinâmica

Uma variável dinâmica, também chamada de variável variável, utiliza o conteúdo de uma variável como nome de outra:

```php
$var = "Curso";
$$var = "Tecnologia em Análise e Desenvolvimento de Sistemas";
```

Como `$var` contém o texto `Curso`, a expressão `$$var` cria uma variável chamada `$Curso`.

Esse recurso é válido, mas deve ser usado com cautela, pois nomes criados dinamicamente podem tornar o código mais difícil de compreender.

---

## Bloco 7 — Variáveis superglobais

Superglobais são arrays especiais disponibilizados automaticamente pelo PHP. Eles podem ser acessados em qualquer escopo.

| Superglobal | Finalidade |
| --- | --- |
| `$_SERVER` | Informações sobre o servidor e a execução da requisição |
| `$_GET` | Dados recebidos pela URL ou por formulário com método GET |
| `$_POST` | Dados enviados por formulário com método POST |
| `$_COOKIE` | Cookies recebidos do navegador |
| `$_FILES` | Informações sobre arquivos enviados por upload |
| `$_ENV` | Variáveis de ambiente disponíveis ao PHP |
| `$_REQUEST` | Pode reunir dados de GET, POST e cookies, conforme a configuração |
| `$_SESSION` | Dados mantidos na sessão do usuário |
| `$GLOBALS` | Referências às variáveis disponíveis no escopo global |

O exemplo utiliza `$_SERVER['PHP_SELF']`:

```php
echo $_SERVER['PHP_SELF'];
```

Esse valor normalmente contém o caminho do script que está sendo executado.

Dados vindos de superglobais podem ser controlados pelo usuário. Antes de exibi-los em HTML, armazená-los ou utilizá-los em consultas, eles devem ser validados e tratados de acordo com o contexto para evitar falhas de segurança.

---

## Bloco 8 — Constantes

Uma constante associa um nome a um valor que não deve mudar durante a execução do script.

No exemplo, ela é declarada com `define()`:

```php
define("CONSTANT", "Hello world!");
echo CONSTANT;
```

As constantes:

- não utilizam o símbolo `$`;
- possuem escopo global;
- não podem ser redefinidas durante a execução normal;
- tradicionalmente recebem nomes em letras maiúsculas.

Outra sintaxe disponível para constantes é `const`:

```php
const NOME_DO_CURSO = "Programação Web";
```

## Resumo da saída esperada

Ao executar o arquivo no navegador, cada bloco é identificado por um título. Entre os principais valores exibidos estão:

- a mensagem `Olá mundo!`;
- as frases geradas com `echo` e `print`;
- as datas montadas por concatenação;
- os valores armazenados no array;
- a mensagem produzida pelo objeto;
- o quadrado do número global, cujo resultado é `9`;
- os valores `1`, `2` e `3` da variável estática;
- o conteúdo das variáveis dinâmica e superglobal;
- o valor da constante `CONSTANT`.

O bloco de comentários não executa os comentários. Seu título aparece na página apenas para indicar a posição desse conteúdo no código.

## Exercícios sugeridos

1. Crie variáveis para armazenar seu nome, sua idade e seu curso e exiba uma frase completa.
2. Monte uma data utilizando primeiro o operador `.` e depois o operador `.=`.
3. Crie um array com três disciplinas e exiba cada uma delas.
4. Escreva uma função que receba um número por parâmetro e retorne seu quadrado, sem utilizar uma variável global.
5. Altere a função `somatorio()` para incrementar o valor de dois em dois.
6. Crie uma classe `Aluno` com um método que exiba uma mensagem de apresentação.
7. Declare uma constante com o nome da instituição e mostre seu valor no navegador.
8. Adicione `var_dump()` a alguns valores para observar o tipo e o conteúdo de cada variável.

## Funções úteis para estudo

Durante os testes, estas funções ajudam a inspecionar valores:

```php
var_dump($variavel); // Exibe o tipo e o valor
print_r($arr);       // Exibe arrays e objetos de forma legível
gettype($variavel);  // Retorna o nome do tipo
```

Essas ferramentas são especialmente úteis durante o aprendizado e a depuração do código.
