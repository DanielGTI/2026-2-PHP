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
        details { margin-top: 1rem; }
        summary { cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Aula 3 — Arrays, objetos e operadores</h1>
    <p>Exemplos executáveis baseados no material da aula. Cada resultado abaixo foi calculado pelo PHP antes de a página chegar ao navegador.</p>

    <section class="introducao">
        <strong>Objetivo da aula:</strong> entender como guardar dados em arrays e objetos e como o PHP usa operadores para calcular, comparar e combinar valores.
        <br><strong>Como ler:</strong> em cada bloco, observe a explicação, a sintaxe destacada e o resultado gerado pelo código.
    </section>

    <?php
    titulo('Bloco 1 — Criando arrays indexados');

    $disciplinas = array('UNINOVE', 'PHP', 'Programação Web', 2015);
    $tecnologias = [];
    $tecnologias[] = 'HTML';
    $tecnologias[] = 'CSS';
    $tecnologias[] = 'PHP';
    ?>
    <p class="explicacao">Um <strong>array indexado</strong> guarda vários valores em uma única variável. Quando não informamos a chave, o PHP cria posições numéricas começando em <code>0</code>.</p>
    <div class="resultado">
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

    $alunoAssociativo = [
        'Curso' => 'Tecnologia em Análise e Desenvolvimento de Sistemas',
        'Nome' => 'Astrogildo Ambrósio Campos',
        'RA' => '000.000.000.000',
    ];
    ?>
    <p class="explicacao">No <strong>array associativo</strong>, cada dado recebe uma chave descritiva. Isso torna o código mais fácil de ler do que usar números como posições.</p>
    <div class="resultado">
        <p><strong>Sintaxe:</strong> para obter o nome, usamos <code>$alunoAssociativo['Nome']</code>.</p>
        <strong>Dados do aluno:</strong><br>
        <strong>Nome:</strong> <?= htmlspecialchars($alunoAssociativo['Nome']) ?><br>
        <strong>Curso:</strong> <?= htmlspecialchars($alunoAssociativo['Curso']) ?><br>
        <strong>RA:</strong> <?= htmlspecialchars($alunoAssociativo['RA']) ?>
    </div>

    <?php
    titulo('Bloco 3 — Array multidimensional');

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
    <div class="resultado">
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
    <div class="resultado">
        <p><strong>Sintaxe:</strong> o operador <code>-&gt;</code> acessa propriedades e métodos de um objeto: <code>$alunoObjeto-&gt;nome</code>.</p>
        <strong>Nome:</strong> <?= htmlspecialchars($alunoObjeto->nome) ?><br>
        <strong>RA:</strong> <?= htmlspecialchars($alunoObjeto->ra) ?><br>
        <strong>Endereço:</strong> <?= htmlspecialchars($alunoObjeto->endereco) ?>
    </div>

    <?php
    titulo('Bloco 5 — Operadores de atribuição e aritméticos');
    $a = 10;
    $b = 2;
    $acumulado = $a;
    $acumulado += $b;
    ?>
    <p class="explicacao">Operadores aritméticos calculam valores. Já os operadores de atribuição armazenam ou atualizam o valor de uma variável.</p>
    <div class="resultado">
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
    $um = 1;
    $dois = 2;
    $tres = 3;
    ?>
    <p class="explicacao">Comparações produzem valores booleanos: <code>true</code> (verdadeiro) ou <code>false</code> (falso). Operadores lógicos permitem combinar essas comparações.</p>
    <div class="resultado">
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
    $posIncremento = 10;
    $valorExibidoPos = $posIncremento++;
    $preIncremento = 10;
    $valorExibidoPre = ++$preIncremento;
    ?>
    <p class="explicacao">Os operadores <code>++</code> e <code>--</code> alteram um número em uma unidade. A posição do operador define se a alteração acontece antes ou depois de usar o valor.</p>
    <div class="resultado">
        <p>Pós-incremento: o valor exibido foi <?= $valorExibidoPos ?>; depois, a variável passou a valer <?= $posIncremento ?>.</p>
        <p>Pré-incremento: o valor exibido foi <?= $valorExibidoPre ?>; a variável vale <?= $preIncremento ?>.</p>
    </div>

    <?php
    titulo('Bloco 8 — Operadores de strings e arrays');
    $instituicao = 'Uninove';
    $mensagem = ' com você é dez!';
    $textoConcatenado = $instituicao . $mensagem;
    $instituicao .= $mensagem;

    $coresQuentes = ['c' => 'red', 'd' => 'green'];
    $coresFrias = ['e' => 'blue', 'f' => 'yellow'];
    $todasAsCores = $coresQuentes + $coresFrias;
    ?>
    <p class="explicacao">O ponto (<code>.</code>) junta textos. Para arrays, o sinal de adição (<code>+</code>) faz uma união preservando as chaves do primeiro array.</p>
    <div class="resultado">
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
</body>
</html>
