# Aula 4 — Estruturas de decisão e repetição em PHP

Esta aula apresenta as estruturas que controlam o fluxo de execução de um programa PHP: decisões condicionais e laços de repetição. Os exemplos em `index.php` podem ser alterados e executados diretamente no navegador.

## Objetivos da aula

Ao concluir esta aula, espera-se que você consiga:

- tomar decisões com `if`, `if...else` e `if...elseif...else`;
- selecionar alternativas com `switch/case`;
- repetir instruções com `for`, `foreach`, `while` e `do...while`;
- escolher a estrutura adequada para cada situação;
- evitar loops infinitos controlando corretamente a condição e o incremento;
- percorrer arrays simples e associativos com `foreach`.

## Como executar o exemplo

Esta pasta possui um ambiente com **Docker Compose**, **PHP 8.3 FPM** e **Nginx**. Antes de começar, confirme que o Docker Desktop está instalado e em execução.

No terminal, a partir da raiz do repositório, entre na pasta da aula:

```bash
cd "aula 4"
```

Inicie os contêineres em segundo plano:

```bash
docker compose up -d
```

Depois, abra no navegador:

```text
http://localhost:8082
```

A porta `8082` permite executar esta aula ao mesmo tempo que as aulas anteriores. O arquivo `index.php` é montado como um volume no contêiner; portanto, depois de salvar uma alteração, basta atualizar o navegador.

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

## Bloco 1 — `if` e `if...else`

`if` executa um bloco somente quando sua condição for verdadeira. Com `else`, é possível definir uma alternativa para quando a condição for falsa.

```php
$idade = 20;

if ($idade >= 18) {
    echo 'Acesso permitido.';
} else {
    echo 'Acesso negado.';
}
```

No exemplo da página, também há uma comparação entre duas variáveis. Altere `$a1`, `$b1` ou `$idade1` para observar os caminhos possíveis.

---

## Bloco 2 — `if...elseif...else`

Use `elseif` quando houver mais de duas possibilidades. As condições são testadas de cima para baixo e apenas o primeiro bloco verdadeiro é executado.

```php
if ($nota >= 9.0) {
    echo 'Conceito A';
} elseif ($nota >= 7.0) {
    echo 'Conceito B';
} elseif ($nota >= 5.0) {
    echo 'Conceito C';
} else {
    echo 'Conceito D';
}
```

Em `index.php`, modifique `$a2`, `$b2` e `$notaAluno` para testar cada resultado.

---

## Bloco 3 — `switch/case`

`switch` compara uma expressão com diversos valores possíveis. Cada `case` representa uma alternativa e, normalmente, termina com `break` para impedir que os casos seguintes também sejam executados.

```php
switch ($perfil) {
    case 'admin':
        echo 'Acesso total.';
        break;
    case 'editor':
        echo 'Permissão para edição.';
        break;
    default:
        echo 'Perfil não reconhecido.';
}
```

O `default` é usado quando nenhum `case` corresponde ao valor. Experimente alterar `$destino` e `$perfilUsuario` no arquivo de exemplo.

---

## Bloco 4 — `for` e `for` aninhado

O laço `for` é indicado quando a quantidade de repetições é conhecida. Ele reúne inicialização, condição e incremento em uma única instrução.

```php
for ($i = 1; $i <= 10; $i++) {
    echo $i . ' ';
}
```

Um `for` pode ser colocado dentro de outro para resolver tarefas como a geração de tabuadas:

```php
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 10; $j++) {
        echo "$i x $j = " . ($i * $j);
    }
}
```

Altere `$limiteContagem` e `$limiteTabuada` para ajustar os exemplos exibidos.

---

## Bloco 5 — `foreach`

`foreach` percorre os elementos de um array sem exigir contador ou limite manual.

```php
$nomes = ['Thiago', 'João', 'Ricardo'];

foreach ($nomes as $nome) {
    echo $nome;
}
```

Para arrays associativos, use a sintaxe com chave e valor:

```php
foreach ($produtos as $item => $preco) {
    echo "$item: R$ $preco";
}
```

Na página, inclua itens em `$nomes` ou `$produtos` e observe como a lista é atualizada automaticamente.

---

## Bloco 6 — `while`

`while` executa um bloco enquanto a condição for verdadeira. É útil quando a quantidade de repetições depende de uma situação que muda durante a execução.

```php
$i = 1;

while ($i <= 10) {
    echo $i . ' ';
    $i++;
}
```

O contador deve ser atualizado dentro do laço; caso contrário, a condição pode nunca se tornar falsa e causar um loop infinito. O exemplo também simula o acúmulo de saldo até alcançar uma meta. Altere `$contadorWhile`, `$saldoInversao` ou `$metaMeta` para testá-lo.

---

## Bloco 7 — `do...while`

Em `do...while`, a condição é verificada ao final. Por isso, o conteúdo do laço é executado pelo menos uma vez, mesmo que a condição já seja falsa no início.

```php
$j = 20;

do {
    echo "Executou com j = $j";
    $j++;
} while ($j <= 10);
```

Compare este comportamento com o `while` e altere `$contadorDoWhile` ou `$contadorCondicaoFalsa` no exemplo.

---

## Comparativo dos laços

| Estrutura | Quando usar | Execução mínima |
| --- | --- | --- |
| `for` | A quantidade de repetições é conhecida. | 0 vezes |
| `foreach` | É necessário percorrer um array. | 0 vezes |
| `while` | A repetição depende de uma condição. | 0 vezes |
| `do...while` | O bloco precisa executar antes do primeiro teste. | 1 vez |

## Exercícios sugeridos

1. Crie uma condição que informe se uma pessoa pode votar, considerando idade mínima de 16 anos.
2. Classifique uma nota em aprovado, recuperação ou reprovado usando `if...elseif...else`.
3. Use `switch` para exibir uma mensagem para cada dia útil da semana.
4. Exiba somente os números pares de 0 a 20 com `for`.
5. Crie um array com cinco cidades e percorra-o com `foreach`.
6. Use `while` para somar números de 1 a 100.
7. Monte um exemplo com `do...while` cuja condição inicial seja falsa e comprove que o bloco foi executado uma vez.

## Recursos úteis para estudo

```php
count($array);       // Retorna a quantidade de elementos de um array
in_array($valor, $array); // Verifica se um valor está presente no array
break;               // Interrompe switch ou laço
continue;            // Pula para a próxima iteração do laço
```

Use `var_dump()` ou `print_r()` durante os exercícios para observar valores e estruturas de dados enquanto o código é executado.
