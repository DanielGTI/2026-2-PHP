# Aula 3 — Arrays, objetos e operadores em PHP

Esta aula dá continuidade aos fundamentos de PHP, apresentando coleções de dados com arrays, uma introdução à orientação a objetos e os operadores mais usados na linguagem.

## Objetivos da aula

Ao concluir esta aula, espera-se que você consiga:

- criar arrays indexados, associativos e multidimensionais;
- acessar valores de um array por seu índice ou chave;
- inspecionar arrays com `print_r()`;
- reconhecer uma classe, seus atributos, métodos e objetos;
- criar uma instância com `new` e acessar atributos com `->`;
- utilizar operadores de atribuição, aritméticos, comparação, lógicos, strings e arrays;
- distinguir pré-incremento de pós-incremento.

## Como executar o exemplo

Esta pasta possui um ambiente com **Docker Compose**, **PHP 8.3 FPM** e **Nginx**. Antes de começar, confirme que o Docker Desktop está instalado e em execução.

No terminal, a partir da raiz do repositório, entre na pasta da aula:

```bash
cd "aula 3"
```

Inicie os contêineres em segundo plano:

```bash
docker compose up -d
```

Depois, abra no navegador:

```text
http://localhost:8081
```

A porta `8081` foi escolhida para que esta aula possa ser executada ao mesmo tempo que a Aula 2, que utiliza a porta `8080`. O arquivo `index.php` é montado como um volume no contêiner; portanto, basta atualizar o navegador depois de salvar uma alteração.

Para conferir os serviços ativos, use:

```bash
docker compose ps
```

Ao encerrar os estudos, pare os contêineres:

```bash
docker compose down
```

Para entender a estrutura Docker em mais detalhes, consulte o [`README.md` da raiz](../README.md).

---

## Bloco 1 — Arrays indexados

Um **array** é uma variável capaz de guardar vários valores. Cada valor ocupa uma posição identificada por uma chave. Quando as chaves são numéricas e criadas automaticamente, o array é chamado de **indexado**.

```php
$disciplinas = array('UNINOVE', 'PHP', 'Programação Web', 2015);
```

Também é comum usar a sintaxe curta com colchetes, disponível nas versões modernas do PHP:

```php
$disciplinas = ['UNINOVE', 'PHP', 'Programação Web', 2015];
```

Os índices numéricos começam em `0`. Logo, o primeiro item está no índice `0`, o segundo no `1` e assim por diante:

| Posição humana | Índice PHP | Valor |
| --- | --- | --- |
| 1ª | `0` | `UNINOVE` |
| 2ª | `1` | `PHP` |
| 3ª | `2` | `Programação Web` |

Para acessar o terceiro elemento, usamos o índice `2`:

```php
echo $disciplinas[2]; // Programação Web
```

### Adicionando elementos

Ao usar `[]` após o nome da variável, o PHP cria o próximo índice numérico disponível automaticamente:

```php
$tecnologias = [];
$tecnologias[] = 'HTML';
$tecnologias[] = 'CSS';
$tecnologias[] = 'PHP';
```

O resultado possui as chaves `0`, `1` e `2`. Outra possibilidade é definir uma posição específica, desde que ela faça sentido para o problema:

```php
$disciplinas[1] = 'PHP 8';
```

### Exibindo todos os elementos com `print_r()`

A função `print_r()` é útil para estudo e depuração, pois mostra as chaves e os valores de arrays e objetos:

```php
print_r($disciplinas);
```

Uma saída semelhante à seguinte será exibida:

```text
Array
(
    [0] => UNINOVE
    [1] => PHP
    [2] => Programação Web
    [3] => 2015
)
```

Em uma aplicação para usuários, normalmente os itens são exibidos em uma lista ou tabela. `print_r()` é mais apropriado como ferramenta de inspeção durante o desenvolvimento.

---

## Bloco 2 — Arrays associativos

Em vez de índices numéricos, um array pode utilizar chaves nomeadas. Esse formato é chamado de **array associativo** e torna os dados mais fáceis de entender.

```php
$aluno = [
    'Curso' => 'Tecnologia em Análise e Desenvolvimento de Sistemas',
    'Nome' => 'Astrogildo Ambrósio Campos',
    'RA' => '000.000.000.000',
];
```

O operador `=>` associa uma chave ao seu valor. Para acessar uma informação, informe a chave entre colchetes:

```php
echo $aluno['Nome'];
echo $aluno['Curso'];
echo $aluno['RA'];
```

No exemplo do `index.php`, os valores são passados por `htmlspecialchars()` antes de serem inseridos no HTML. Essa função evita que um texto contendo caracteres especiais seja interpretado como marcação HTML. É uma boa prática sempre que o conteúdo puder vir de uma pessoa usuária, de formulário ou de outra fonte externa.

---

## Bloco 3 — Arrays multidimensionais

Um array pode conter outros arrays. Essa estrutura é chamada de **array multidimensional** ou matriz. Ela é útil para representar registros agrupados, como vários cursos e suas informações.

```php
$cursos = [
    'TADS' => [
        'Descricao' => 'Tecnologia em Análise e Desenvolvimento de Sistemas',
        'Disciplina' => 'Programação Web',
    ],
    'TSIN' => [
        'Descricao' => 'Tecnologia em Sistemas para Internet',
        'Disciplina' => 'Programação Web',
    ],
];
```

Para acessar uma informação, utilizamos uma chave para cada nível:

```php
echo $cursos['TADS']['Descricao'];
echo $cursos['TSIN']['Disciplina'];
```

O primeiro colchete localiza o curso; o segundo localiza uma informação dentro daquele curso. No arquivo de exemplo, o laço `foreach` percorre todos os cursos:

```php
foreach ($cursos as $sigla => $curso) {
    echo $sigla;
    echo $curso['Descricao'];
}
```

`$sigla` recebe a chave externa, como `TADS`, e `$curso` recebe o array interno correspondente.

---

## Bloco 4 — Classes e objetos

Orientação a objetos é uma forma de organizar um programa em entidades que possuem dados e comportamentos.

- **Classe**: modelo que descreve uma entidade;
- **Objeto** ou **instância**: elemento criado a partir de uma classe;
- **Atributo**: dado armazenado pelo objeto;
- **Método**: ação ou comportamento definido na classe;
- **Encapsulamento**: controle sobre como os dados internos são acessados;
- **Herança**: criação de uma classe especializada a partir de outra;
- **Polimorfismo**: possibilidade de diferentes classes responderem à mesma operação de formas diferentes.

Nesta aula, o foco é apenas criar uma classe simples e utilizá-la:

```php
class Aluno
{
    public string $nome;
    public string $ra;
    public string $endereco;

    public function __construct()
    {
        $this->definirDados();
    }

    public function definirDados(): void
    {
        $this->nome = 'Superman';
        $this->ra = '1234567890';
        $this->endereco = 'Sala da Justiça';
    }
}
```

`public` indica que o atributo ou método pode ser acessado fora da classe. Os tipos `string` deixam claro que os três atributos devem armazenar texto.

### Construtor e `$this`

O método `__construct()` é chamado automaticamente quando um objeto é criado. Ele é o construtor moderno do PHP. O material original usa um método com o mesmo nome da classe como construtor; essa forma foi descontinuada e não deve ser usada no PHP 8.

Dentro da classe, `$this` representa o objeto atual. Assim, `$this->nome` significa o atributo `nome` daquele objeto.

### Criando e acessando o objeto

```php
$alunoObjeto = new Aluno();

echo $alunoObjeto->nome;
echo $alunoObjeto->ra;
echo $alunoObjeto->endereco;
```

`new Aluno()` cria uma instância e `->` acessa seus atributos ou métodos.

---

## Bloco 5 — Operadores de atribuição e aritméticos

Operadores realizam ações sobre valores e produzem um resultado. Para os exemplos, considere:

```php
$a = 10;
$b = 2;
```

### Atribuição

O sinal `=` atribui o valor à direita para a variável à esquerda:

```php
$a = $b;
```

Os operadores de atribuição combinada realizam uma operação e guardam o resultado na própria variável:

| Operador | Equivale a | Exemplo com `$a = 10` e `$b = 2` | Resultado em `$a` |
| --- | --- | --- | --- |
| `+=` | `$a = $a + $b` | `$a += $b` | `12` |
| `-=` | `$a = $a - $b` | `$a -= $b` | `8` |
| `*=` | `$a = $a * $b` | `$a *= $b` | `20` |
| `/=` | `$a = $a / $b` | `$a /= $b` | `5` |
| `%=` | `$a = $a % $b` | `$a %= $b` | `0` |

### Aritméticos

| Operador | Operação | Exemplo | Resultado |
| --- | --- | --- | --- |
| `-` | Negação | `-$a` | `-10` |
| `+` | Adição | `$a + $b` | `12` |
| `-` | Subtração | `$a - $b` | `8` |
| `*` | Multiplicação | `$a * $b` | `20` |
| `/` | Divisão | `$a / $b` | `5` |
| `%` | Resto da divisão | `$a % $b` | `0` |

O operador `%` é chamado de módulo. Ele é útil, por exemplo, para verificar se um número é par: um número é par quando `numero % 2 === 0`.

---

## Bloco 6 — Operadores de comparação e lógicos

Operadores de comparação verificam uma relação entre valores e sempre retornam um booleano: `true` ou `false`.

| Operador | Significado | Exemplo |
| --- | --- | --- |
| `==` | Igual em valor | `10 == '10'` é `true` |
| `===` | Idêntico em valor e tipo | `10 === '10'` é `false` |
| `!=` ou `<>` | Diferente em valor | `10 != 2` é `true` |
| `!==` | Não idêntico | `10 !== '10'` é `true` |
| `>` | Maior que | `10 > 2` é `true` |
| `<` | Menor que | `10 < 2` é `false` |
| `>=` | Maior ou igual | `10 >= 10` é `true` |
| `<=` | Menor ou igual | `10 <= 2` é `false` |

Em código novo, prefira `===` e `!==` quando a comparação também deve considerar o tipo. Isso evita conversões implícitas inesperadas.

### Operadores lógicos

Eles combinam condições:

```php
$um = 1;
$dois = 2;
$tres = 3;

($um < $dois) && ($dois < $tres); // true: as duas condições são verdadeiras
($um < $dois) || ($dois > $tres); // true: pelo menos uma condição é verdadeira
($um < $dois) xor ($dois > $tres); // true: exatamente uma condição é verdadeira
!($um > $dois); // true: nega false
```

`and` e `or` também existem, mas possuem prioridade diferente de `&&` e `||`. Para expressões comuns, `&&` e `||`, com parênteses quando necessário, deixam a intenção mais explícita.

---

## Bloco 7 — Incremento e decremento

Os operadores `++` e `--` alteram o valor de uma variável em uma unidade. A posição do operador determina o momento em que a alteração acontece.

```php
$valor = 10;
echo $valor++; // exibe 10; depois, $valor passa a valer 11

$valor = 10;
echo ++$valor; // primeiro altera para 11; depois, exibe 11
```

Da mesma forma:

```php
$valor--; // usa o valor atual e depois reduz em 1
--$valor; // reduz em 1 e depois usa o novo valor
```

No `index.php`, os valores são armazenados em variáveis separadas para deixar essa diferença visível na página.

---

## Bloco 8 — Operadores de strings e arrays

### Strings

O ponto (`.`) concatena textos:

```php
$instituicao = 'Uninove';
$mensagem = ' com você é dez!';

$texto = $instituicao . $mensagem;
```

O operador `.=` concatena e atribui o resultado à variável da esquerda:

```php
$instituicao .= $mensagem;
```

Após essa instrução, `$instituicao` conterá `Uninove com você é dez!`.

### Arrays

O operador `+` faz a união de arrays. As chaves que já existem no array da esquerda são preservadas; elas não são sobrescritas pelos valores da direita.

```php
$coresQuentes = ['c' => 'red', 'd' => 'green'];
$coresFrias = ['e' => 'blue', 'f' => 'yellow'];

$todasAsCores = $coresQuentes + $coresFrias;
```

Também é possível comparar arrays:

| Operador | Verifica |
| --- | --- |
| `==` | mesmas chaves e valores, sem exigir mesma ordem e tipos idênticos |
| `===` | mesmas chaves, valores, tipos e ordem |
| `!=` ou `<>` | arrays diferentes em valor/chaves |
| `!==` | arrays não idênticos |

---

## Resumo da saída esperada

Ao abrir a página, cada conteúdo é separado por um título. Entre os resultados exibidos estão:

- o terceiro valor de um array indexado e o resultado de `print_r()`;
- os dados de um aluno em um array associativo;
- os cursos e disciplinas de uma matriz;
- os atributos do objeto `Aluno`;
- resultados de operações aritméticas, comparações e condições lógicas;
- a diferença entre pós-incremento e pré-incremento;
- uma concatenação de strings e uma união de arrays.

## Exercícios sugeridos

1. Crie um array indexado com cinco linguagens de programação e exiba a primeira e a última.
2. Crie um array associativo para representar um livro, com as chaves `titulo`, `autor` e `ano`.
3. Monte uma matriz com três alunos. Para cada um, armazene nome, RA e curso; depois, exiba os dados com `foreach`.
4. Acrescente à classe `Aluno` um método `apresentar()` que retorne uma frase usando o nome do aluno.
5. Com `$a = 17` e `$b = 5`, calcule soma, produto, divisão e resto da divisão.
6. Teste a diferença entre `5 == '5'` e `5 === '5'`. Explique o resultado em um comentário.
7. Crie uma condição que verifique se uma pessoa tem idade entre 18 e 65 anos.
8. Faça um contador que comece em `0` e use incremento para chegar a `5`.
9. Crie dois arrays associativos com uma chave repetida e observe qual valor permanece após usar `+`.

## Funções e recursos úteis para estudo

```php
print_r($array);          // Mostra a estrutura de arrays e objetos
var_dump($variavel);      // Mostra tipo e valor detalhadamente
count($array);            // Retorna a quantidade de elementos
isset($array['chave']);   // Verifica se uma chave existe e não contém null
```

Use esses recursos para observar o comportamento do código enquanto realiza os exercícios.
