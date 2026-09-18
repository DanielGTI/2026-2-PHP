<?php
declare(strict_types=1);

/**
 * Aula 4 — Estruturas de Decisão e Looping em PHP.
 * Cada seção abaixo corresponde a um assunto do material da aula.
 * Conteúdo original: Prof. Adriano Kleber Milanez.
 */

function titulo(string $texto): void
{
    echo "<h2>{$texto}</h2>";
}

function mostrarBooleano(bool $valor): string
{
    return $valor ? 'true' : 'false';
}

function escapar(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aula 4 — PHP: Estruturas de Decisão e Looping</title>
    <style>
        body { background: #fcfcfd; font-family: Arial, sans-serif; line-height: 1.6; margin: 2rem auto; max-width: 960px; color: #202124; }
        h1 { color: #5b2c6f; }
        h2 { border-bottom: 1px solid #ddd; margin-top: 2rem; padding-bottom: .35rem; }
        h3 { margin-bottom: .2rem; }
        pre { background: #f6f8fa; border-radius: 6px; overflow: auto; padding: 1rem; }
        code { color: #6b247c; }
        .introducao { background: #fff7e6; border-left: 4px solid #f39c12; padding: 1rem 1.25rem; }
        .explicacao { margin: .5rem 0 1rem; }
        .resultado { background: #f3e5f5; border-left: 4px solid #8e44ad; padding: .75rem 1rem; }
        .resultado p:first-child { margin-top: 0; }
        .resultado p:last-child { margin-bottom: 0; }
        .dica { background: #eaf4ff; border-left: 4px solid #2878c8; margin-top: 1rem; padding: .65rem 1rem; }
        .codigo { background: #282c34; border-left: 4px solid #f39c12; color: #f8f8f2; padding: .75rem 1rem; position: relative; }
        .codigo h3 { color: #fff; margin-top: 0; }
        .codigo h3 a { color: #f9d65c; }
        .codigo h3 a:hover, .codigo h3 a:focus-visible { color: #fff09a; }
        .codigo pre { background: #1e2127; color: #f8f8f2; margin-bottom: 0; }
        .codigo code { color: inherit; }
        .copiar-codigo { align-items: center; background: #3b4048; border: 1px solid #737985; border-radius: 4px; color: #fff; cursor: pointer; display: flex; height: 2rem; justify-content: center; padding: 0; position: absolute; right: 1rem; top: .75rem; width: 2rem; }
        .copiar-codigo:hover, .copiar-codigo:focus-visible { background: #505762; outline: 2px solid #f39c12; outline-offset: 2px; }
        .copiar-codigo svg { height: 1.1rem; width: 1.1rem; }
        .localizacao { background: #fff7e6; border-left: 4px solid #f39c12; margin: 0; padding: .65rem 1rem; }
        details { margin-top: 1rem; }
        summary { cursor: pointer; font-weight: bold; }
        
        /* Estilos específicos para destaques e tabuada */
        .cor1 { color: #f00; font-weight: bold; }
        .cor2 { color: #00f; font-weight: bold; }
        .cor3 { color: #27ae60; font-weight: bold; }
        .cor4 { color: #d35400; font-weight: bold; }
        .cor5 { color: #000; font-weight: bold; }
        .tabuada-container { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
        .tabuada-box { border: 1px solid #000; padding: 8px 12px; width: 160px; font-size: 14px; background: #fff; float: left; margin: 4px; }
        .tabuada-box h4 { margin: 0 0 5px 0; text-align: center; font-size: 16px; border-bottom: 1px solid #ddd; color: #5b2c6f; }
        .clear { clear: both; }
        table.comparativo { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.comparativo th, table.comparativo td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        table.comparativo th { background-color: #f2f2f2; color: #5b2c6f; }
    </style>
</head>
<body>
    <h1>Aula 4 — Estruturas de Decisão e Looping</h1>
    <p>Exemplos executáveis baseados no material da aula. Cada resultado abaixo foi calculado pelo PHP antes de a página chegar ao navegador. Os códigos em fundo escuro também podem ser copiados para um console online, como o OneCompiler: cada <code>echo</code> termina com <code>"\n"</code> para exibir um resultado por linha.</p>

    <section class="introducao">
        <strong>Objetivo da aula:</strong> Entender como o PHP trabalha com estruturas de decisão do tipo <code>if</code>, <code>if...else</code>, <code>if...elseif...else</code> e <code>switch/case</code>, além dos laços de repetição (looping): <code>for</code>, <code>foreach</code>, <code>while</code> e <code>do...while</code>.
        <br><strong>Como ler:</strong> Em cada bloco, observe a explicação, o código PHP e os resultados gerados com múltiplos exemplos práticos para fixação.
    </section>

    <?php
    titulo('Bloco 1 — Estrutura de Decisão: if e if...else');

    // ================================================================
    // BLOCO 1 — PRATIQUE: if e if...else
    // Altere os valores das variáveis para testar desvios condicionais.
    // ================================================================
    $a1 = 5;
    $b1 = 5;

    $idade1 = 20;
    $idadeMinima = 18;
    ?>
    <p class="explicacao">A instrução <code>if</code> testa se uma expressão condicional é verdadeira (<code>true</code>). Se a condição for falsa, o <code>else</code> fornece um desvio alternativo de saída.</p>
    
    <aside class="dica">
        <strong>Conceito Chave:</strong> Expressões condicionais no PHP sempre retornam um valor booleano (<code>true</code> ou <code>false</code>).
    </aside>

    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
        <h3>1. Código PHP: testando igualdade e validação de idade — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// Exemplo 1: Comparação simples de igualdade (if)
$a = 5;
$b = 5;
if ($a == $b) {
    echo 'A variável $a é igual a variável $b' . "\n";
}

// Exemplo 2: Verificação com alternativa (if...else)
$idade = 20;
if ($idade &gt;= 18) {
    echo 'Acesso permitido: Usuário é maior de idade.' . "\n";
} else {
    echo 'Acesso negado: Usuário é menor de idade.' . "\n";
}
?&gt;</code></pre>
    </section>
    
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>88 a 92</strong>. Ajuste os valores das variáveis para alterar os desvios exibidos neste bloco.</p>
    
    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Exemplo 1 (Comparação simples):</strong></p>
        <?php if ($a1 == $b1): ?>
            <p class="cor1">A variável $a (<?= $a1 ?>) é igual a variável $b (<?= $b1 ?>)</p>
        <?php endif; ?>

        <p><strong>Exemplo 2 (Verificação de Maioridade com if...else):</strong></p>
        <?php if ($idade1 >= $idadeMinima): ?>
            <p class="cor2">Idade: <?= $idade1 ?> anos — Status: Acesso permitido (Maior de idade).</p>
        <?php else: ?>
            <p class="cor1">Idade: <?= $idade1 ?> anos — Status: Acesso negado (Menor de idade).</p>
        <?php endif; ?>
    </div>

    <?php
    titulo('Bloco 2 — Estrutura de Decisão: if...elseif...else');

    // ================================================================
    // BLOCO 2 — PRATIQUE: if...elseif...else
    // Edite os números para testar múltiplos desvios encadeados.
    // ================================================================
    $a2 = 5;
    $b2 = 6;

    $notaAluno = 7.5;
    ?>
    <p class="explicacao">Quando temos mais de duas possibilidades de desvio, utilizamos o <code>elseif</code>. Ele deve ser obrigatoriamente precedido por um <code>if</code> e permite checar uma segunda condição caso a primeira seja falsa.</p>
    
    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
        <h3>1. Código PHP: checando somas e conceitos de notas — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// Exemplo 1: Verificação de soma de variáveis
$a = 5; $b = 6;
if ($a == $b) {
    echo 'A variável $a é igual a $b' . "\n";
} elseif (($a + $b) == 11) {
    echo 'A soma das variáveis $a + $b é igual a 11' . "\n";
} else {
    echo 'A soma das variáveis $a + $b é diferente de 11' . "\n";
}

// Exemplo 2: Classificação de Desempenho Escolar
$nota = 7.5;
if ($nota &gt;= 9.0) {
    echo 'Conceito A — Excelente!' . "\n";
} elseif ($nota &gt;= 7.0) {
    echo 'Conceito B — Bom!' . "\n";
} elseif ($nota &gt;= 5.0) {
    echo 'Conceito C — Recuperação.' . "\n";
} else {
    echo 'Conceito D — Reprovado.' . "\n";
}
?&gt;</code></pre>
    </section>

    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>145 a 148</strong>. Ajuste os valores das variáveis para testar outros caminhos do código.</p>

    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Exemplo 1 (Teste de soma do PDF):</strong></p>
        <?php
        if ($a2 == $b2) {
            echo '<p class="cor1">A variável $a é igual a variável $b</p>';
        } elseif (($a2 + $b2) == 11) {
            echo '<p class="cor2">A soma das variáveis $a + $b é igual a 11</p>';
        } else {
            echo '<p class="cor5">A soma das variáveis $a + $b é diferente de 11</p>';
        }
        ?>

        <p><strong>Exemplo 2 (Avaliação de nota com múltiplos elseif):</strong></p>
        <p>
            Nota avaliada: <strong><?= $notaAluno ?></strong> — 
            <?php
            if ($notaAluno >= 9.0) {
                echo '<span class="cor3">Conceito A (Excelente)</span>';
            } elseif ($notaAluno >= 7.0) {
                echo '<span class="cor2">Conceito B (Aprovado com Bom Desempenho)</span>';
            } elseif ($notaAluno >= 5.0) {
                echo '<span class="cor4">Conceito C (Em Recuperação)</span>';
            } else {
                echo '<span class="cor1">Conceito D (Reprovado)</span>';
            }
            ?>
        </p>
    </div>

    <?php
    titulo('Bloco 3 — Estrutura de Decisão: switch/case');

    // ================================================================
    // BLOCO 3 — PRATIQUE: switch/case
    // Mude a cidade de destino ou o perfil de usuário para testar.
    // ================================================================
    $destino = 'New York';
    $perfilUsuario = 'editor';
    ?>
    <p class="explicacao">O <code>switch/case</code> é ideal para testar uma mesma variável contra diversos valores pré-estabelecidos. É uma solução mais elegante e eficiente do que encadear dezenas de blocos <code>if...elseif</code>.</p>
    
    <aside class="dica">
        <strong>Atenção ao Break:</strong> A instrução <code>break</code> é indispensável no final de cada <code>case</code>. Sem ela, o PHP continuará executando os casos seguintes até encontrar um <code>break</code> ou o fim do bloco!
    </aside>

    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
        <h3>1. Código PHP: escolhendo destinos e permissões de usuário — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// Exemplo 1: Destinos de viagem (Exemplo da Apostila)
$destino = "New York";
switch ($destino) {
    case "São Paulo":
        echo 'Seja bem-vindo à cidade que nunca para!' . "\n";
        break;
    case "Paris":
        echo 'Seja bem-vindo à Cidade Luz!' . "\n";
        break;
    case "New York":
        echo 'Seja bem-vindo à Big Apple!' . "\n";
        break;
    case "Rio de Janeiro":
        echo 'Seja bem-vindo à Cidade Maravilhosa!' . "\n";
        break;
    default:
        echo 'Não encontramos seu destino!' . "\n";
}

// Exemplo 2: Permissão de Acesso no Sistema
$perfil = "editor";
switch ($perfil) {
    case "admin":
        echo 'Acesso total ao sistema.' . "\n";
        break;
    case "editor":
        echo 'Acesso para criar e editar conteúdos.' . "\n";
        break;
    case "visitante":
        echo 'Acesso apenas para leitura.' . "\n";
        break;
    default:
        echo 'Perfil não reconhecido.' . "\n";
}
?&gt;</code></pre>
    </section>

    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>219 e 220</strong>. Mude o destino ou o perfil para testar outras mensagens do <code>switch</code>.</p>

    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Exemplo 1 (Mensagem do Destino):</strong></p>
        <?php
        switch ($destino) {
            case "São Paulo":
                echo '<p class="cor1">Seja bem-vindo à cidade que nunca para!</p>';
                break;
            case "Paris":
                echo '<p class="cor2">Seja bem-vindo à Cidade Luz!</p>';
                break;
            case "New York":
                echo '<p class="cor3">Seja bem-vindo à Big Apple!</p>';
                break;
            case "Rio de Janeiro":
                echo '<p class="cor4">Seja bem-vindo à Cidade Maravilhosa!</p>';
                break;
            default:
                echo '<p class="cor5">Não encontramos seu destino!</p>';
        }
        ?>

        <p><strong>Exemplo 2 (Permissão do Perfil):</strong></p>
        <p>
            Perfil selecionado: <strong><?= htmlspecialchars($perfilUsuario) ?></strong> — 
            <?php
            switch ($perfilUsuario) {
                case "admin":
                    echo '<span class="cor1">Acesso completo (Administrador)</span>';
                    break;
                case "editor":
                    echo '<span class="cor2">Permissão para publicação e edição</span>';
                    break;
                case "visitante":
                    echo '<span class="cor3">Permissão apenas de leitura</span>';
                    break;
                default:
                    echo '<span class="cor5">Acesso restrito ou indefinido</span>';
            }
            ?>
        </p>
    </div>

    <?php
    titulo('Bloco 4 — Estrutura de Repetição: FOR e FOR Aninhado');

    // ================================================================
    // BLOCO 4 — PRATIQUE: laço for
    // Edite os limites das iterações abaixo.
    // ================================================================
    $limiteContagem = 10;
    $limiteTabuada = 5; // Quantidade de tabuadas exibidas
    ?>
    <p class="explicacao">Utilizamos a instrução <code>for</code> quando sabemos previamente a quantidade exata de vezes que o bloco deve ser executado. É dividida em 3 partes: <code>expressão1</code> (inicialização), <code>expressão2</code> (condição) e <code>expressão3</code> (incremento).</p>

    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
        <h3>1. Código PHP: contagem simples e tabuadas aninhadas — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// Exemplo 1: Contagem de 1 até 10
for ($i = 1; $i &lt;= 10; $i++) {
    echo $i . "\n";
}

// Exemplo 2: For aninhado (Tabuada)
for ($i = 1; $i &lt;= 5; $i++) {
    echo "Tabuada do $i:\n";
    for ($j = 1; $j &lt;= 10; $j++) {
        echo "$i x $j = " . ($i * $j) . "\n";
    }
}
?&gt;</code></pre>
    </section>

    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>321 e 322</strong>. Ajuste os limites que geram a sequência e as tabuadas.</p>

    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Exemplo 1 (Sequência numérica):</strong></p>
        <p class="cor1">
            <?php
            for ($i = 1; $i <= $limiteContagem; $i++) {
                echo $i . " ";
            }
            ?>
        </p>

        <p><strong>Exemplo 2 (Tabuadas geradas com FOR aninhado):</strong></p>
        <div class="tabuada-container">
            <?php for ($i = 1; $i <= $limiteTabuada; $i++): ?>
                <div class="tabuada-box">
                    <h4>Tabuada do <?= $i ?></h4>
                    <?php for ($j = 1; $j <= 10; $j++): ?>
                        <span class="cor1"><?= $i ?></span> x <span class="cor2"><?= $j ?></span> = <strong><?= $i * $j ?></strong><br>
                    <?php endfor; ?>
                </div>
            <?php endfor; ?>
        </div>
        <div class="clear"></div>
    </div>

    <?php
    titulo('Bloco 5 — Estrutura de Repetição: FOREACH');

    // ================================================================
    // BLOCO 5 — PRATIQUE: laço foreach
    // Adicione novos elementos ao vetor ou matriz.
    // ================================================================
    $nomes = array('Thiago', 'João', 'Ricardo', 'Paula');
    $produtos = array(
        'Teclado' => 150.00,
        'Mouse' => 80.00,
        'Monitor' => 950.00
    );
    ?>
    <p class="explicacao">O laço <code>foreach</code> é exclusivo para percorrer coleções de dados (vetores/arrays e matrizes). Ele não exige controle manual do limite, pois avança automaticamente item por item.</p>

    <aside class="dica">
        <strong>Duas sintaxes possíveis:</strong>
        <br>1. <code>foreach ($array as $valor)</code> — Acessa apenas os valores.
        <br>2. <code>foreach ($array as $chave =&gt; $valor)</code> — Acessa os índices/chaves e os seus respectivos valores.
    </aside>

    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
        <h3>1. Código PHP: percorrendo vetor simples e array associativo — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// Exemplo 1: Sintaxe 1 (Apenas valores)
$nomes = array('Thiago', 'João', 'Ricardo', 'Paula');
foreach ($nomes as $valor) {
    echo $valor . "\n";
}

// Exemplo 2: Sintaxe 2 (Chave/Índice =&gt; Valor)
$produtos = array('Teclado' =&gt; 150.00, 'Mouse' =&gt; 80.00);
foreach ($produtos as $item =&gt; $preco) {
    echo "Item: $item — Preço: R$ " . number_format($preco, 2, ',', '.') . "\n";
}
?&gt;</code></pre>
    </section>

    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>379 a 384</strong>. Adicione ou altere os nomes e produtos percorridos pelo <code>foreach</code>.</p>

    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Exemplo 1 (Lista de nomes com sintaxe simples):</strong></p>
        <ul>
            <?php foreach ($nomes as $valor): ?>
                <li>Nome: <strong><?= htmlspecialchars($valor) ?></strong></li>
            <?php endforeach; ?>
        </ul>

        <p><strong>Exemplo 2 (Catálogo de produtos com Chave e Valor):</strong></p>
        <ul>
            <?php foreach ($produtos as $item => $preco): ?>
                <li>Produto: <strong><?= htmlspecialchars($item) ?></strong> — Valor: <span class="cor3">R$ <?= number_format($preco, 2, ',', '.') ?></span></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php
    titulo('Bloco 6 — Estrutura de Repetição: WHILE');

    // ================================================================
    // BLOCO 6 — PRATIQUE: laço while
    // Edite a variável de controle inicial e os limites do laço.
    // ================================================================
    $contadorWhile = 1;
    $saldoInversao = 100;
    $metaMeta = 150;
    ?>
    <p class="explicacao">O laço <code>while</code> repete um bloco de código <strong>enquanto</strong> a condição verificada for verdadeira. A presença de um contador/incremento é obrigatória para evitar que o código caia em um loop infinito.</p>

    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
        <h3>1. Código PHP: contador numérico e acumulador financeiro — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// Exemplo 1: Contagem simples com While
$i = 1;
while ($i &lt;= 10) {
    echo $i . "\n";
    $i++; // Incremento obrigatório
}

// Exemplo 2: Simulação de rendimento/metas
$saldo = 100;
$meses = 0;
while ($saldo &lt; 150) {
    $saldo += 10; // Adiciona 10 por iteração
    $meses++;
}
echo "Meta atingida em $meses meses com R$ $saldo\n";
?&gt;</code></pre>
    </section>

    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>438 a 440</strong>. Ajuste os valores inicial e de meta para alterar as repetições exibidas.</p>

    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Exemplo 1 (Contador simples de 1 a 10):</strong></p>
        <p class="cor1">
            <?php
            $i = $contadorWhile;
            while ($i <= 10) {
                echo $i . " ";
                $i++;
            }
            ?>
        </p>

        <p><strong>Exemplo 2 (Simulação de acúmulo de saldo até atingir a meta):</strong></p>
        <p>
            <?php
            $saldo = $saldoInversao;
            $meses = 0;
            while ($saldo < $metaMeta) {
                $saldo += 15;
                $meses++;
            }
            echo "Saldo inicial de R$ $saldoInversao atingiu a meta de R$ $metaMeta em <span class=\"cor2\">$meses iterações</span>. Saldo final: <span class=\"cor3\">R$ $saldo</span>.";
            ?>
        </p>
    </div>

    <?php
    titulo('Bloco 7 — Estrutura de Repetição: DO...WHILE');

    // ================================================================
    // BLOCO 7 — PRATIQUE: laço do...while
    // Altere o valor inicial do contador.
    // ================================================================
    $contadorDoWhile = 1;
    $contadorCondicaoFalsa = 20; // Já inicia maior que 10
    ?>
    <p class="explicacao">A diferença fundamental entre o <code>while</code> e o <code>do...while</code> é que o <code>do...while</code> garante que o bloco de instruções seja executado <strong>pelo menos uma vez</strong> antes de testar a condição pela primeira vez.</p>

    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
        <h3>1. Código PHP: execução normal vs execução com condição inicialmente falsa — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// Exemplo 1: Execução padrão do...while
$i = 1;
do {
    echo $i . "\n";
    $i++;
} while ($i &lt;= 10);

// Exemplo 2: Testando valor onde a condição é falsa logo de início
$j = 20;
do {
    echo "Executou ao menos uma vez! Valor de j: $j\n";
    $j++;
} while ($j &lt;= 10); // Condição é falsa, mas executou 1 vez!
?&gt;</code></pre>
    </section>

    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>502 e 503</strong>. Ajuste os valores iniciais e observe que o <code>do...while</code> executa ao menos uma vez.</p>

    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Exemplo 1 (Contagem de 1 a 10):</strong></p>
        <p class="cor1">
            <?php
            $i = $contadorDoWhile;
            do {
                echo $i . " ";
                $i++;
            } while ($i <= 10);
            ?>
        </p>

        <p><strong>Exemplo 2 (Garantia de execução de 1 vez quando a condição inicial é FALSA):</strong></p>
        <p class="cor4">
            <?php
            $j = $contadorCondicaoFalsa;
            do {
                echo "O valor inicial era $j (que é maior que 10), mas o bloco foi executado uma vez!";
                $j++;
            } while ($j <= 10);
            ?>
        </p>
    </div>

    <?php
    titulo('Bloco 8 — Quadro Comparativo e Fixação');
    ?>
    <p class="explicacao">Para facilitar a fixação das diferenças entre cada estrutura de repetição estudada na aula, consulte a tabela comparativa abaixo:</p>

    <table class="comparativo">
        <thead>
            <tr>
                <th>Estrutura</th>
                <th>Quando utilizar?</th>
                <th>Verificação da Condição</th>
                <th>Garantia de Execução</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>for</strong></td>
                <td>Quando a quantidade de repetições é conhecida previamente.</td>
                <td>No início de cada iteração.</td>
                <td>0 ou mais vezes.</td>
            </tr>
            <tr>
                <td><strong>foreach</strong></td>
                <td>Exclusivo para percorrer vetores (arrays) ou coleções.</td>
                <td>Implicitamente em cada elemento.</td>
                <td>0 ou mais vezes (se o array estiver vazio, não roda).</td>
            </tr>
            <tr>
                <td><strong>while</strong></td>
                <td>Quando não sabemos o número exato de repetições e depende de uma condição.</td>
                <td>No início de cada iteração.</td>
                <td>0 ou mais vezes.</td>
            </tr>
            <tr>
                <td><strong>do...while</strong></td>
                <td>Quando o bloco precisa ser executado ao menos uma vez obrigatoriamente.</td>
                <td>No final de cada iteração.</td>
                <td><strong>Ao menos 1 vez</strong>.</td>
            </tr>
        </tbody>
    </table>

    <script>
        document.querySelectorAll('.copiar-codigo').forEach((botao) => {
            botao.addEventListener('click', async () => {
                const codigo = botao.closest('.codigo').querySelector('pre code').textContent;
                const iconeOriginal = botao.innerHTML;

                try {
                    if (navigator.clipboard && window.isSecureContext) {
                        await navigator.clipboard.writeText(codigo);
                    } else {
                        const areaDeTexto = document.createElement('textarea');
                        areaDeTexto.value = codigo;
                        document.body.appendChild(areaDeTexto);
                        areaDeTexto.select();
                        document.execCommand('copy');
                        areaDeTexto.remove();
                    }

                    botao.textContent = '✓';
                    botao.setAttribute('aria-label', 'Código copiado');
                    botao.title = 'Código copiado!';
                    setTimeout(() => {
                        botao.innerHTML = iconeOriginal;
                        botao.setAttribute('aria-label', 'Copiar código do exemplo');
                        botao.title = 'Copiar código';
                    }, 1800);
                } catch (erro) {
                    botao.title = 'Não foi possível copiar o código';
                }
            });
        });
    </script>
</body>
</html>
