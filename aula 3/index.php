<?php
declare(strict_types=1);

/**
 * Aula 3 — Arrays, objetos e operadores em PHP.
 * Cada seção abaixo corresponde a um assunto do material da aula.
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
        // ================================================================
        // BLOCO 4 — PRATIQUE: classe, propriedades e objeto
        // Edite os dados abaixo para criar o seu próprio aluno.
        // ================================================================
        $this->nome = 'Superman';
        $this->ra = '1234567890';
        $this->endereco = 'Sala da Justiça';
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aula 3 — PHP</title>
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
    </style>
</head>
<body>
    <h1>Aula 3 — Arrays, objetos e operadores</h1>
    <p>Exemplos executáveis baseados no material da aula. Cada resultado abaixo foi calculado pelo PHP antes de a página chegar ao navegador. Os códigos em fundo escuro também podem ser copiados para um console online, como o OneCompiler: cada <code>echo</code> termina com <code>"\n"</code> para exibir um resultado por linha.</p>

    <section class="introducao">
        <strong>Objetivo da aula:</strong> entender como guardar dados em arrays e objetos e como o PHP usa operadores para calcular, comparar e combinar valores.
        <br><strong>Como ler:</strong> em cada bloco, observe primeiro o código PHP comentado e, logo abaixo, o resultado que ele gerou.
    </section>

    <?php
    titulo('Bloco 1 — Criando arrays indexados');

    // ================================================================
    // BLOCO 1 — PRATIQUE: arrays indexados
    // Edite os valores ou adicione novas tecnologias abaixo.
    // Textos fixos usam aspas simples; use aspas duplas se precisar de uma variável.
    // ================================================================
    $disciplinas = array('UNINOVE', 'PHP', 'Programação Web', 2015);
    $tecnologias = [];
    $tecnologias[] = 'HTML';
    $tecnologias[] = 'CSS';
    $tecnologias[] = 'PHP';
    ?>
    <p class="explicacao">Um <strong>array indexado</strong> guarda vários valores em uma única variável. Quando não informamos a chave, o PHP cria posições numéricas começando em <code>0</code>.</p>
    <aside class="dica">
        <strong>Aspas simples ou duplas?</strong>
        <ul>
            <li>Use <code>'texto'</code> para um texto literal. É a escolha mais comum para valores fixos, como <code>'PHP'</code>.</li>
            <li>Use <code>"texto"</code> quando precisar inserir o valor de uma variável no texto ou interpretar sequências como <code>\n</code> (nova linha).</li>
        </ul>
        <p><code>$linguagem = 'PHP';</code><br>
        Com aspas simples, <code>'Estudando $linguagem'</code> mantém <code>$linguagem</code> como texto.<br>
        Com aspas duplas, <code>"Estudando $linguagem"</code> se torna <code>"Estudando PHP"</code>.</p>
        <p><strong>Regra prática:</strong> prefira aspas simples para textos fixos; use aspas duplas somente quando precisar inserir uma variável no texto ou usar uma sequência especial.</p>
    </aside>
    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código">
            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
        </button>
        <h3>1. Código PHP: criando os arrays — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// Cria o array já com quatro valores.
// As posições serão: 0, 1, 2 e 3.
$disciplinas = array('UNINOVE', 'PHP', 'Programação Web', 2015);

// Cria um array vazio: ainda não há nenhum item nele.
$tecnologias = [];

// [] adiciona um novo item na próxima posição disponível.
$tecnologias[] = 'HTML'; // posição 0
$tecnologias[] = 'CSS';  // posição 1
$tecnologias[] = 'PHP';  // posição 2

// Exemplo 1: acessa a posição 2. A contagem começa em 0.
echo 'Disciplina na posição 2: ' . $disciplinas[2] . "\n";

// Exemplo 2: percorre os itens adicionados ao segundo array.
foreach ($tecnologias as $posicao => $tecnologia) {
    echo 'Tecnologia na posição ' . $posicao . ': ' . $tecnologia . "\n";
}
?&gt;</code></pre>
    </section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>97 a 101</strong>. Troque os valores entre aspas, mude o ano ou acrescente uma nova linha <code>$tecnologias[] = 'JavaScript';</code>.</p>
    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Sintaxe:</strong> <code>$disciplinas[2]</code> acessa a terceira posição, pois a contagem começa em zero.</p>
        <p>Terceiro item de <code>$disciplinas</code>: <?= htmlspecialchars((string) $disciplinas[2]) ?></p>
        <p>Array completo com <code>print_r()</code>:</p>
        <pre><?php print_r($disciplinas); ?></pre>
        <p>Itens adicionados com <code>[]</code>:</p>
        <pre><?php print_r($tecnologias); ?></pre>
    </div>
    <p class="dica"><strong>Repare:</strong> <code>count($tecnologias)</code> retornaria <?= count($tecnologias) ?>, a quantidade de itens do array.</p>

    <?php
    titulo('Bloco 2 — Array associativo');

    // ================================================================
    // BLOCO 2 — PRATIQUE: array associativo
    // Edite os valores à direita de => para personalizar o aluno.
    // ================================================================
    $alunoAssociativo = [
        'Curso' => 'Tecnologia em Análise e Desenvolvimento de Sistemas',
        'Nome' => 'Astrogildo Ambrósio Campos',
        'RA' => '000.000.000.000',
    ];
    ?>
    <p class="explicacao">No <strong>array associativo</strong>, cada dado recebe uma chave descritiva. Isso torna o código mais fácil de ler do que usar números como posições.</p>
    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código">
            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2 2v1"></path></svg>
        </button>
        <h3>1. Código PHP: criando e consultando pelas chaves — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// A chave fica à esquerda de =&gt; e o valor fica à direita.
$alunoAssociativo = [
    'Curso' =&gt; 'Tecnologia em Análise e Desenvolvimento de Sistemas',
    'Nome' =&gt; 'Astrogildo Ambrósio Campos',
    'RA' =&gt; '000.000.000.000',
];

// Exemplo 1: obtém um valor usando a chave Nome.
echo 'Nome: ' . $alunoAssociativo['Nome'] . "\n";

// Exemplo 2: obtém outro valor usando a chave Curso.
echo 'Curso: ' . $alunoAssociativo['Curso'] . "\n";
?&gt;</code></pre>
    </section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>161 a 165</strong>. Modifique os valores à direita de <code>=&gt;</code>, como o nome, curso ou RA.</p>
    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Sintaxe:</strong> para obter o nome, usamos <code>$alunoAssociativo['Nome']</code>.</p>
        <strong>Dados do aluno:</strong><br>
        <strong>Nome:</strong> <?= htmlspecialchars($alunoAssociativo['Nome']) ?><br>
        <strong>Curso:</strong> <?= htmlspecialchars($alunoAssociativo['Curso']) ?><br>
        <strong>RA:</strong> <?= htmlspecialchars($alunoAssociativo['RA']) ?>
    </div>

    <?php
    titulo('Bloco 3 — Array multidimensional');

    // ================================================================
    // BLOCO 3 — PRATIQUE: array multidimensional
    // Edite um curso ou crie outro seguindo a mesma estrutura.
    // ================================================================
    $cursos = [
        'TADS' => [
            'Descricao' => 'Tecnologia em Análise e Desenvolvimento de Sistemas',
            'Disciplina' => 'Programação Web',
        ],
        'TSIN' => [
            'Descricao' => 'Tecnologia em Sistemas para Internet',
            'Disciplina' => 'Programação Web',
        ],
        'SI' => [
            'Descricao' => 'Sistemas de Informação',
            'Disciplina' => 'Programação Web',
        ],
    ];
    ?>
    <p class="explicacao">Um <strong>array multidimensional</strong> é um array que contém outros arrays. Ele é útil para representar listas mais completas, como cursos com várias informações.</p>
    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código">
            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2 2v1"></path></svg>
        </button>
        <h3>1. Código PHP: array dentro de array e <code>foreach</code> — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// TADS é a chave do array externo; seus dados formam outro array.
$cursos = [
    'TADS' =&gt; [
        'Descricao' =&gt; 'Tecnologia em Análise e Desenvolvimento de Sistemas',
        'Disciplina' =&gt; 'Programação Web',
    ],
    'TSIN' =&gt; [
        'Descricao' =&gt; 'Tecnologia em Sistemas para Internet',
        'Disciplina' =&gt; 'Programação Web',
    ],
];

// Exemplo 1: acesso direto a um dado dentro de dois arrays.
echo 'Disciplina de TADS: ' . $cursos['TADS']['Disciplina'] . "\n";

// Exemplo 2: em cada volta, $sigla recebe a chave e $curso recebe os dados.
foreach ($cursos as $sigla =&gt; $curso) {
    echo $sigla . ': ' . $curso['Descricao'] . ' — ' . $curso['Disciplina'] . "\n";
}
?&gt;</code></pre>
    </section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>205 a 218</strong>. Altere os dados de um curso ou copie a estrutura de um curso para cadastrar outro.</p>
    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Sintaxe:</strong> o acesso direto ao curso TADS seria <code>$cursos['TADS']['Disciplina']</code>.</p>
        <?php foreach ($cursos as $sigla => $curso): ?>
            <p>
                <strong>Sigla:</strong> <?= htmlspecialchars($sigla) ?><br>
                <strong>Descrição:</strong> <?= htmlspecialchars($curso['Descricao']) ?><br>
                <strong>Disciplina:</strong> <?= htmlspecialchars($curso['Disciplina']) ?>
            </p>
        <?php endforeach; ?>
    </div>
    <p class="dica"><strong>Laço <code>foreach</code>:</strong> ele percorre cada curso sem precisarmos saber antecipadamente quantos existem.</p>

    <?php
    titulo('Bloco 4 — Objeto e classe');
    $alunoObjeto = new Aluno();
    ?>
    <p class="explicacao">Uma <strong>classe</strong> funciona como um molde. O objeto <code>$alunoObjeto</code> foi criado a partir da classe <code>Aluno</code> e possui propriedades próprias.</p>
    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código">
            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2 2v1"></path></svg>
        </button>
        <h3>1. Código PHP: classe, método e objeto — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
class Aluno
{
    public string $nome;

    // O construtor é executado quando usamos new Aluno().
    public function __construct()
    {
        $this-&gt;nome = 'Superman';
    }
}

// Exemplo 1: cria um objeto a partir do molde Aluno.
$alunoObjeto = new Aluno();
echo 'Nome: ' . $alunoObjeto-&gt;nome . "\n";

// Exemplo 2: outro objeto pode ter valores próprios.
$outroAluno = new Aluno();
$outroAluno-&gt;nome = 'Lois Lane';
echo 'Outro nome: ' . $outroAluno-&gt;nome . "\n";
?&gt;</code></pre>
    </section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>41 a 43</strong>. Experimente mudar os valores atribuídos a <code>$this-&gt;nome</code>, <code>$this-&gt;ra</code> e <code>$this-&gt;endereco</code>.</p>
    <div class="resultado">
        <p><strong>2. Resultado do código acima:</strong></p>
        <p><strong>Sintaxe:</strong> o operador <code>-&gt;</code> acessa propriedades e métodos de um objeto: <code>$alunoObjeto-&gt;nome</code>.</p>
        <strong>Nome:</strong> <?= htmlspecialchars($alunoObjeto->nome) ?><br>
        <strong>RA:</strong> <?= htmlspecialchars($alunoObjeto->ra) ?><br>
        <strong>Endereço:</strong> <?= htmlspecialchars($alunoObjeto->endereco) ?>
    </div>

    <?php
    titulo('Bloco 5 — Operadores de atribuição e aritméticos');
    // ================================================================
    // BLOCO 5 — PRATIQUE: operadores aritméticos e atribuição
    // Edite os números de $a e $b e observe os novos cálculos.
    // ================================================================
    $a = 10;
    $b = 2;
    $acumulado = $a;
    $acumulado += $b;
    ?>
    <p class="explicacao">Operadores aritméticos calculam valores. Já os operadores de atribuição armazenam ou atualizam o valor de uma variável.</p>
    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código">
            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
        </button>
        <h3>1. Código PHP: atribuir e calcular — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
$a = 10; // atribui 10 à variável a
$b = 2;  // atribui 2 à variável b

// Exemplo 1: operações aritméticas.
echo 'Soma: ' . ($a + $b) . "\n";             // 12
echo 'Multiplicação: ' . ($a * $b) . "\n";    // 20

// Exemplo 2: atribuição abreviada.
$acumulado = $a;
$acumulado += $b; // soma b ao valor que já existia
echo 'Acumulado: ' . $acumulado . "\n";       // 12

$contador = 5;
$contador *= 3;
echo 'Contador após *= 3: ' . $contador . "\n"; // 15
?&gt;</code></pre>
    </section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>309 a 312</strong>. Troque os valores de <code>$a</code> e <code>$b</code> e recarregue a página para calcular novamente.</p>
    <div class="resultado">
        <p><strong>2. Resultado dos cálculos:</strong></p>
        <p><code>$a = <?= $a ?></code> e <code>$b = <?= $b ?></code></p>
        <ul>
            <li>Adição: <?= $a + $b ?></li>
            <li>Subtração: <?= $a - $b ?></li>
            <li>Multiplicação: <?= $a * $b ?></li>
            <li>Divisão: <?= $a / $b ?></li>
            <li>Módulo: <?= $a % $b ?></li>
            <li>Após <code>$acumulado += $b</code>: <?= $acumulado ?></li>
        </ul>
    </div>
    <p class="dica"><code>$acumulado += $b</code> é uma forma abreviada de escrever <code>$acumulado = $acumulado + $b</code>.</p>

    <?php
    titulo('Bloco 6 — Operadores de comparação e lógicos');
    // ================================================================
    // BLOCO 6 — PRATIQUE: comparação e operadores lógicos
    // Edite $um, $dois e $tres para criar outros resultados booleanos.
    // ================================================================
    $um = 1;
    $dois = 2;
    $tres = 3;
    ?>
    <p class="explicacao">Comparações produzem valores booleanos: <code>true</code> (verdadeiro) ou <code>false</code> (falso). Operadores lógicos permitem combinar essas comparações.</p>
    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código">
            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
        </button>
        <h3>1. Código PHP: comparar e combinar condições — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
// == verifica somente o valor; === verifica valor e tipo.
$mesmoValor = 10 == '10';
$mesmoValorETipo = 10 === '10';
echo '10 == "10": ' . ($mesmoValor ? 'true' : 'false') . "\n";
echo '10 === "10": ' . ($mesmoValorETipo ? 'true' : 'false') . "\n";

$um = 1;
$dois = 2;
$tres = 3;
// Exemplo 2: && só resulta em true quando as duas condições são verdadeiras.
$ordemCrescente = ($um &lt; $dois) &amp;&amp; ($dois &lt; $tres);
echo 'Os números estão em ordem crescente: ' . ($ordemCrescente ? 'true' : 'false') . "\n";

$temDesconto = true;
$clienteAtivo = false;
echo 'Pode usar desconto: ' . (($temDesconto &amp;&amp; $clienteAtivo) ? 'true' : 'false') . "\n";
?&gt;</code></pre>
    </section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>359 a 361</strong>. Mude os valores de <code>$um</code>, <code>$dois</code> e <code>$tres</code> para testar condições verdadeiras e falsas.</p>
    <div class="resultado">
        <p><strong>2. Resultado das comparações:</strong></p>
        <p><strong>Importante:</strong> <code>==</code> compara o valor; <code>===</code> compara valor <em>e</em> tipo. Por isso o texto <code>"10"</code> não é idêntico ao número <code>10</code>.</p>
        <ul>
            <li><code>10 == "10"</code>: <?= mostrarBooleano(10 == '10') ?></li>
            <li><code>10 === "10"</code>: <?= mostrarBooleano(10 === '10') ?></li>
            <li><code>10 != 2</code>: <?= mostrarBooleano(10 != 2) ?></li>
            <li><code>10 &gt; 2</code>: <?= mostrarBooleano(10 > 2) ?></li>
            <li><code>($um &lt; $dois) && ($dois &lt; $tres)</code>: <?= mostrarBooleano(($um < $dois) && ($dois < $tres)) ?></li>
            <li><code>($um &lt; $dois) xor ($dois &gt; $tres)</code>: <?= mostrarBooleano(($um < $dois) xor ($dois > $tres)) ?></li>
        </ul>
    </div>

    <?php
    titulo('Bloco 7 — Pré e pós-incremento');
    // ================================================================
    // BLOCO 7 — PRATIQUE: pré e pós-incremento
    // Edite os valores iniciais e compare o efeito de ++ antes e depois.
    // ================================================================
    $posIncremento = 10;
    $valorExibidoPos = $posIncremento++;
    $preIncremento = 10;
    $valorExibidoPre = ++$preIncremento;
    ?>
    <p class="explicacao">Os operadores <code>++</code> e <code>--</code> alteram um número em uma unidade. A posição do operador define se a alteração acontece antes ou depois de usar o valor.</p>
    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código">
            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
        </button>
        <h3>1. Código PHP: a posição de <code>++</code> importa — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
$posIncremento = 10;
$valorExibidoPos = $posIncremento++; // usa 10 e depois passa a 11
echo 'Pós-incremento — exibido: ' . $valorExibidoPos . "\n";
echo 'Pós-incremento — variável depois: ' . $posIncremento . "\n";

// Exemplo 2: o incremento ocorre antes de usar o valor.
$preIncremento = 10;
$valorExibidoPre = ++$preIncremento; // passa a 11 e depois usa 11
echo 'Pré-incremento — exibido: ' . $valorExibidoPre . "\n";
echo 'Pré-incremento — variável depois: ' . $preIncremento . "\n";
?&gt;</code></pre>
    </section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>408 a 411</strong>. Comece os dois números com outros valores e compare o pré e o pós-incremento.</p>
    <div class="resultado">
        <p><strong>2. Resultado do incremento:</strong></p>
        <p>Pós-incremento: o valor exibido foi <?= $valorExibidoPos ?>; depois, a variável passou a valer <?= $posIncremento ?>.</p>
        <p>Pré-incremento: o valor exibido foi <?= $valorExibidoPre ?>; a variável vale <?= $preIncremento ?>.</p>
    </div>

    <?php
    titulo('Bloco 8 — Operadores de strings e arrays');
    // ================================================================
    // BLOCO 8 — PRATIQUE: strings, concatenação e união de arrays
    // Edite os textos, chaves ou cores para experimentar essas operações.
    // ================================================================
    $instituicao = 'Uninove';
    $mensagem = ' com você é dez!';
    $textoConcatenado = $instituicao . $mensagem;
    $instituicao .= $mensagem;

    $coresQuentes = ['c' => 'red', 'd' => 'green'];
    $coresFrias = ['e' => 'blue', 'f' => 'yellow'];
    $todasAsCores = $coresQuentes + $coresFrias;
    ?>
    <p class="explicacao">O ponto (<code>.</code>) junta textos. Para arrays, o sinal de adição (<code>+</code>) faz uma união preservando as chaves do primeiro array.</p>
    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código">
            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
        </button>
        <h3>1. Código PHP: concatenar textos e unir arrays — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <pre><code>&lt;?php
$instituicao = 'Uninove';
$mensagem = ' com você é dez!';

// . cria um novo texto juntando os dois valores.
$textoConcatenado = $instituicao . $mensagem;
// .= acrescenta o texto à própria variável.
$instituicao .= $mensagem;
echo 'Texto com .: ' . $textoConcatenado . "\n";
echo 'Texto após .=: ' . $instituicao . "\n";

// Exemplo 2: + une arrays e preserva as chaves do primeiro array.
$coresQuentes = ['c' =&gt; 'red', 'd' =&gt; 'green'];
$coresFrias = ['e' =&gt; 'blue', 'f' =&gt; 'yellow'];
$todasAsCores = $coresQuentes + $coresFrias;
foreach ($todasAsCores as $chave =&gt; $cor) {
    echo $chave . ': ' . $cor . "\n";
}
?&gt;</code></pre>
    </section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>445 a 452</strong>. Altere os textos ou inclua novas chaves e cores nos arrays.</p>
    <div class="resultado">
        <p><strong>2. Resultado das operações:</strong></p>
        <p>Concatenação: <?= htmlspecialchars($textoConcatenado) ?></p>
        <p>Após <code>.=</code>: <?= htmlspecialchars($instituicao) ?></p>
        <p>União de arrays com <code>+</code>:</p>
        <pre><?php print_r($todasAsCores); ?></pre>
    </div>
    <details>
        <summary>Resumo para praticar</summary>
        <ul>
            <li>Troque ou acrescente uma tecnologia em <code>$tecnologias</code>.</li>
            <li>Inclua um novo curso em <code>$cursos</code> e veja o <code>foreach</code> exibi-lo automaticamente.</li>
            <li>Altere <code>$a</code> e <code>$b</code> e compare os novos resultados dos operadores.</li>
        </ul>
    </details>
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
