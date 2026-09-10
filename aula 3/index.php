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
        body { font-family: Arial, sans-serif; line-height: 1.5; margin: 2rem; color: #202124; }
        h1 { color: #5b2c6f; }
        h2 { border-bottom: 1px solid #ddd; margin-top: 2rem; padding-bottom: .35rem; }
        pre { background: #f6f8fa; border-radius: 6px; overflow: auto; padding: 1rem; }
        .resultado { background: #f3e5f5; border-left: 4px solid #8e44ad; padding: .75rem 1rem; }
    </style>
</head>
<body>
    <h1>Aula 3 — Arrays, objetos e operadores</h1>
    <p>Exemplos executáveis baseados no material da aula.</p>

    <?php
    titulo('Bloco 1 — Criando arrays indexados');

    $disciplinas = array('UNINOVE', 'PHP', 'Programação Web', 2015);
    $tecnologias = [];
    $tecnologias[] = 'HTML';
    $tecnologias[] = 'CSS';
    $tecnologias[] = 'PHP';
    ?>
    <div class="resultado">
        <p>Terceiro item de <code>$disciplinas</code>: <?= htmlspecialchars((string) $disciplinas[2]) ?></p>
        <p>Array completo com <code>print_r()</code>:</p>
        <pre><?php print_r($disciplinas); ?></pre>
        <p>Itens adicionados com <code>[]</code>:</p>
        <pre><?php print_r($tecnologias); ?></pre>
    </div>

    <?php
    titulo('Bloco 2 — Array associativo');

    $alunoAssociativo = [
        'Curso' => 'Tecnologia em Análise e Desenvolvimento de Sistemas',
        'Nome' => 'Astrogildo Ambrósio Campos',
        'RA' => '000.000.000.000',
    ];
    ?>
    <div class="resultado">
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
    <div class="resultado">
        <?php foreach ($cursos as $sigla => $curso): ?>
            <p>
                <strong>Sigla:</strong> <?= htmlspecialchars($sigla) ?><br>
                <strong>Descrição:</strong> <?= htmlspecialchars($curso['Descricao']) ?><br>
                <strong>Disciplina:</strong> <?= htmlspecialchars($curso['Disciplina']) ?>
            </p>
        <?php endforeach; ?>
    </div>

    <?php
    titulo('Bloco 4 — Objeto e classe');
    $alunoObjeto = new Aluno();
    ?>
    <div class="resultado">
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

    <?php
    titulo('Bloco 6 — Operadores de comparação e lógicos');
    $um = 1;
    $dois = 2;
    $tres = 3;
    ?>
    <div class="resultado">
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
    <div class="resultado">
        <p>Concatenação: <?= htmlspecialchars($textoConcatenado) ?></p>
        <p>Após <code>.=</code>: <?= htmlspecialchars($instituicao) ?></p>
        <p>União de arrays com <code>+</code>:</p>
        <pre><?php print_r($todasAsCores); ?></pre>
    </div>
</body>
</html>
