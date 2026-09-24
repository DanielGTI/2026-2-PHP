<?php
declare(strict_types=1);

/** Aula 5 — Manipulação de Arrays e Objetos em PHP.
 * Material-base: Prof. Adriano Kleber Milanez.
 */
function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function tipo($valor): string
{
    return is_object($valor) ? get_class($valor) : gettype($valor);
}

class Saudacao
{
    public $nome;

    public function __construct(string $nome)
    {
        $this->nome = $nome;
    }

    public function dizerOla(): string
    {
        return "Olá, {$this->nome}!";
    }
}

// Altere estes valores para praticar os exemplos.
$bandas = ['Pearl Jam', 'Metallica', 'Pearl Jam', 'Faith No More', 'Nirvana', 'Angra'];
$precos = ['teclado' => 150.00, 'mouse' => 80.00, 'monitor' => 950.00];
$dadosAluno = ['nome' => 'Ana', 'nota' => 9.0, 'ativo' => true];
$tecnologias = ['PHP', 'HTML'];
$arrAtividade = ['var' => [6 => 5, 13 => 9, 'a' => 42]];
$objeto = new Saudacao('Maria');
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aula 5 — Manipulação de Arrays e Objetos em PHP</title>
    <style>
        :root { color-scheme: light; }
        body { background:#fcfcfd; color:#202124; font-family:Arial,sans-serif; line-height:1.6; margin:2rem auto; max-width:960px; padding:0 1rem; }
        h1 { color:#5b2c6f; } h2 { border-bottom:1px solid #ddd; margin-top:2rem; padding-bottom:.35rem; }
        code { color:#6b247c; } pre { margin:0; overflow:auto; } table { border-collapse:collapse; margin:1rem 0; width:100%; }
        th,td { border:1px solid #ccc; padding:.65rem; text-align:left; vertical-align:top; } th { background:#f2f2f2; color:#5b2c6f; }
        .introducao,.dica,.resultado,.localizacao { border-left:4px solid; margin:1rem 0; padding:.8rem 1rem; }
        .introducao,.localizacao { background:#fff7e6; border-color:#f39c12; } .dica { background:#eaf4ff; border-color:#2878c8; } .resultado { background:#f3e5f5; border-color:#8e44ad; }
        .codigo { background:#282c34; border-left:4px solid #f39c12; color:#f8f8f2; margin-top:1rem; padding:1rem; position:relative; }
        .codigo h3 { color:#fff; margin:0 2.75rem .7rem 0; } .codigo a { color:#f9d65c; } .codigo code { color:inherit; }
        .copiar-codigo { background:#3b4048; border:1px solid #737985; border-radius:4px; color:#fff; cursor:pointer; height:2rem; position:absolute; right:1rem; top:1rem; width:2rem; }
        .copiar-codigo:hover,.copiar-codigo:focus-visible { background:#505762; outline:2px solid #f39c12; outline-offset:2px; }
        .lista-resultados li { margin:.25rem 0; } .cor1 { color:#c0392b; font-weight:bold; } .cor2 { color:#1f5fa5; font-weight:bold; } .cor3 { color:#197b42; font-weight:bold; }
    </style>
</head>
<body>
    <h1>Aula 5 — Manipulação de Arrays e Objetos em PHP</h1>
    <p>Exemplos executáveis baseados no material da aula. O PHP calcula os resultados no servidor; os blocos escuros podem ser copiados e executados diretamente no console do OneCompiler.</p>

    <section class="introducao">
        <strong>Objetivo:</strong> compreender os tipos de dados do PHP e usar arrays para armazenar e manipular coleções de valores. Ao final, há uma breve introdução a objetos, criados a partir de classes.
    </section>

    <h2>Bloco 1 — Tipos de dados no PHP</h2>
    <p>O PHP determina o tipo de uma variável em tempo de execução. Os tipos escalares são <code>bool</code>, <code>int</code>, <code>float</code> e <code>string</code>. Arrays e objetos são tipos compostos; <code>null</code> e <code>resource</code> são tipos especiais.</p>
    <section class="codigo"><button class="copiar-codigo" type="button" aria-label="Copiar código">⧉</button><h3>1. Código PHP: tipos escalares — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3><pre><code>&lt;?php
$ativo = true;       // bool
$quantidade = 42;    // int
$preco = 19.90;      // float
$mensagem = 'Olá';   // string

echo 'Ativo: ' . var_export($ativo, true) . "\n";
echo "Quantidade: $quantidade\n";
echo "Preço: $preco\n";
echo "Mensagem: $mensagem\n";
?&gt;</code></pre></section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>33 a 38</strong> e <strong>84 a 87</strong>. Ajuste as variáveis e os valores exibidos para experimentar os tipos escalares.</p>
    <div class="resultado"><strong>Resultado:</strong><ul class="lista-resultados">
        <li><code>$ativo</code> = <?= e(var_export($dadosAluno['ativo'], true)) ?> (<?= e(tipo($dadosAluno['ativo'])) ?>)</li>
        <li><code>$quantidade</code> = 42 (<?= e(tipo(42)) ?>)</li>
        <li><code>$preco</code> = 19.90 (<?= e(tipo(19.90)) ?>)</li>
        <li><code>$mensagem</code> = <?= e('Olá') ?> (<?= e(tipo('Olá')) ?>)</li>
    </ul></div>

    <h2>Bloco 2 — Criando arrays</h2>
    <p>Um array é um mapa ordenado: associa chaves a valores. Pode ser criado com <code>array()</code> ou com a sintaxe curta <code>[]</code>. Índices numéricos são criados automaticamente quando não indicamos uma chave.</p>
    <section class="codigo"><button class="copiar-codigo" type="button" aria-label="Copiar código">⧉</button><h3>1. Código PHP: array simples e associativo — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3><pre><code>&lt;?php
$nomes = array('Ana', 'João', 'Paula');
$aluno = ['nome' =&gt; 'Ana', 'nota' =&gt; 9.0];

echo 'Primeiro nome: ' . $nomes[0] . "\n";
echo 'Nome do aluno: ' . $aluno['nome'] . "\n";
echo 'Nota: ' . $aluno['nota'] . "\n";
?&gt;</code></pre></section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>33 a 38</strong> e <strong>101</strong>. Altere o array <code>$dadosAluno</code> e observe os itens exibidos.</p>
    <div class="resultado"><strong>Resultado do array associativo:</strong><ul class="lista-resultados"><?php foreach ($dadosAluno as $chave => $valor): ?><li><code><?= e($chave) ?></code> =&gt; <?= e(is_bool($valor) ? var_export($valor, true) : $valor) ?></li><?php endforeach; ?></ul></div>

    <h2>Bloco 3 — <code>array_unique()</code>: removendo duplicados</h2>
    <p><code>array_unique()</code> remove valores repetidos e preserva as chaves originais. Caso sejam necessários índices sequenciais novamente, use <code>array_values()</code> no resultado.</p>
    <section class="codigo"><button class="copiar-codigo" type="button" aria-label="Copiar código">⧉</button><h3>1. Código PHP: bandas sem repetição — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3><pre><code>&lt;?php
$bandas = ['Pearl Jam', 'Metallica', 'Pearl Jam', 'Faith No More'];
$resultado = array_unique($bandas);
foreach ($resultado as $indice =&gt; $banda) {
    echo "Banda[$indice]: $banda\n";
}
?&gt;</code></pre></section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>33 a 38</strong> e <strong>113</strong>. Adicione, remova ou repita valores no array <code>$bandas</code> para testar <code>array_unique()</code>.</p>
    <div class="resultado"><strong>Resultado:</strong><ul class="lista-resultados"><?php foreach (array_unique($bandas) as $indice => $banda): ?><li>Banda[<?= e($indice) ?>]: <span class="cor2"><?= e($banda) ?></span></li><?php endforeach; ?></ul></div>

    <h2>Bloco 4 — Ordenando valores: <code>asort()</code> e <code>arsort()</code></h2>
    <p>Essas funções ordenam pelos valores, mantendo a associação com as chaves: <code>asort()</code> em ordem crescente e <code>arsort()</code> em ordem decrescente.</p>
    <section class="codigo"><button class="copiar-codigo" type="button" aria-label="Copiar código">⧉</button><h3>1. Código PHP: ordenação por valor — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3><pre><code>&lt;?php
$precos = ['teclado' =&gt; 150, 'mouse' =&gt; 80, 'monitor' =&gt; 950];
$crescente = $precos;
asort($crescente);
echo "Crescente:\n";
foreach ($crescente as $produto =&gt; $preco) {
    echo "$produto: R$ $preco\n";
}

$decrescente = $precos;
arsort($decrescente);
echo "Decrescente:\n";
foreach ($decrescente as $produto =&gt; $preco) {
    echo "$produto: R$ $preco\n";
}
?&gt;</code></pre></section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>33 a 38</strong> e <strong>134 a 135</strong>. Modifique os produtos, as chaves ou os preços no array <code>$precos</code>.</p>
    <?php $crescente = $precos; asort($crescente); $decrescente = $precos; arsort($decrescente); ?>
    <div class="resultado"><table><thead><tr><th>asort() — crescente</th><th>arsort() — decrescente</th></tr></thead><tbody><tr><td><?php foreach ($crescente as $item => $preco): ?><?= e($item) ?>: R$ <?= number_format($preco, 2, ',', '.') ?><br><?php endforeach; ?></td><td><?php foreach ($decrescente as $item => $preco): ?><?= e($item) ?>: R$ <?= number_format($preco, 2, ',', '.') ?><br><?php endforeach; ?></td></tr></tbody></table></div>

    <h2>Bloco 5 — Contagem e ordenação por chave</h2>
    <p><code>count()</code> retorna quantos elementos há no array. Já <code>ksort()</code> e <code>krsort()</code> ordenam pelas chaves em ordem crescente e decrescente, respectivamente.</p>
    <section class="codigo"><button class="copiar-codigo" type="button" aria-label="Copiar código">⧉</button><h3>1. Código PHP: count(), ksort() e krsort() — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3><pre><code>&lt;?php
$bandas = ['Pearl Jam', 'Metallica', 'Nirvana', 'Angra'];
echo 'Quantidade de bandas: ' . count($bandas) . "\n";

$dados = ['zebra' =&gt; 1, 'ana' =&gt; 2, 'maria' =&gt; 3];
$porChave = $dados;
ksort($porChave);
echo 'ksort(): ' . implode(', ', array_keys($porChave)) . "\n";

$porChaveReversa = $dados;
krsort($porChaveReversa);
echo 'krsort(): ' . implode(', ', array_keys($porChaveReversa)) . "\n";
?&gt;</code></pre></section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>33 a 38</strong> e <strong>153 a 154</strong>. Ajuste o array <code>$bandas</code> e as chaves usadas nas ordenações.</p>
    <?php $chaves = ['zebra' => 1, 'ana' => 2, 'maria' => 3]; $porChave = $chaves; ksort($porChave); $porChaveReversa = $chaves; krsort($porChaveReversa); ?>
    <div class="resultado"><p>Foram encontradas <span class="cor3"><?= count($bandas) ?></span> bandas no array original.</p><p><strong>ksort():</strong> <?= e(implode(', ', array_keys($porChave))) ?><br><strong>krsort():</strong> <?= e(implode(', ', array_keys($porChaveReversa))) ?></p></div>

    <h2>Bloco 6 — Outras funções úteis para arrays</h2>
    <p>O PHP oferece muitas funções para trabalhar com coleções. A tabela resume algumas operações frequentes, além das apresentadas no material.</p>
    <section class="codigo"><button class="copiar-codigo" type="button" aria-label="Copiar código">⧉</button><h3>1. Código PHP: adicionando, unindo e consultando arrays — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3><pre><code>&lt;?php
$lista = ['PHP', 'HTML'];
array_push($lista, 'CSS');
echo 'Após array_push(): ' . implode(', ', $lista) . "\n";

$unidos = array_merge($lista, ['JavaScript']);
echo 'Após array_merge(): ' . implode(', ', $unidos) . "\n";
echo 'array_slice(1, 2): ' . implode(', ', array_slice($unidos, 1, 2)) . "\n";
echo in_array('PHP', $unidos, true) ? "PHP foi encontrado.\n" : "PHP não foi encontrado.\n";
?&gt;</code></pre></section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>33 a 38</strong> e <strong>169 a 175</strong>. Inclua ou remova tecnologias do array <code>$tecnologias</code> para alterar as operações exibidas.</p>
    <?php $lista = $tecnologias; array_push($lista, 'CSS'); $unidos = array_merge($lista, ['JavaScript']); ?>
    <table><thead><tr><th>Função</th><th>Uso</th><th>Exemplo executado</th></tr></thead><tbody>
        <tr><td><code>array_push()</code></td><td>Adiciona elementos ao final.</td><td><?= e(implode(', ', $lista)) ?></td></tr>
        <tr><td><code>array_merge()</code></td><td>Une arrays.</td><td><?= e(implode(', ', $unidos)) ?></td></tr>
        <tr><td><code>array_slice()</code></td><td>Extrai uma parte.</td><td><?= e(implode(', ', array_slice($unidos, 1, 2))) ?></td></tr>
        <tr><td><code>in_array()</code></td><td>Verifica se um valor existe.</td><td><?= in_array('PHP', $unidos, true) ? 'PHP foi encontrado.' : 'PHP não foi encontrado.' ?></td></tr>
        <tr><td><code>array_key_exists()</code></td><td>Verifica se uma chave existe.</td><td><?= array_key_exists('nota', $dadosAluno) ? 'A chave nota existe.' : 'A chave nota não existe.' ?></td></tr>
    </tbody></table>

    <h2>Bloco 7 — Objetos</h2>
    <p>Um objeto é uma instância de uma classe. A classe descreve propriedades e métodos; a palavra-chave <code>new</code> cria o objeto, e <code>-&gt;</code> acessa seus membros.</p>
    <section class="codigo"><button class="copiar-codigo" type="button" aria-label="Copiar código">⧉</button><h3>1. Código PHP: classe e objeto — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3><pre><code>&lt;?php
class Saudacao {
    public $nome;

    public function __construct($nome) {
        $this-&gt;nome = $nome;
    }

    public function dizerOla(): string { return "Olá, {$this-&gt;nome}!"; }
}
$pessoa = new Saudacao('Maria');
echo $pessoa-&gt;dizerOla() . "\n";
?&gt;</code></pre></section>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>33 a 38</strong> e <strong>194</strong>. Troque <code>'Maria'</code> ao criar <code>$objeto</code> para mudar a saudação.</p>
    <div class="resultado"><strong>Resultado:</strong> <?= e($objeto->dizerOla()) ?> O valor é do tipo <code><?= e(tipo($objeto)) ?></code>.</div>

    <h2>Bloco 8 — Tipos especiais e atividade final</h2>
    <p><code>null</code> representa uma variável sem valor. Um <code>resource</code> representa um recurso externo, geralmente criado por funções específicas, como uma conexão ou um arquivo aberto.</p>
    <?php $semValor = null; ?>
    <div class="dica"><strong>Atividade:</strong><ol><li>Tipos escalares: <strong>A. Integer, Float e String</strong>.</li><li>Declaração de array: <strong>A. <code>$var = array();</code></strong>.</li><li>Em <code>$arr['var'][13]</code>, o valor retornado é <strong><?= e($arrAtividade['var'][13]) ?></strong> (alternativa A).</li></ol></div>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>33 a 38</strong> e <strong>198 a 199</strong>. Modifique as chaves e os valores de <code>$arrAtividade</code>; altere também o índice <code>[13]</code> na atividade para consultar outro valor.</p>

    <script>
        document.querySelectorAll('.copiar-codigo').forEach((botao) => {
            botao.addEventListener('click', async () => {
                const codigo = botao.closest('.codigo').querySelector('code').textContent;
                try {
                    await navigator.clipboard.writeText(codigo);
                    botao.textContent = '✓';
                    setTimeout(() => { botao.textContent = '⧉'; }, 1600);
                } catch (erro) { botao.title = 'Não foi possível copiar o código'; }
            });
        });
    </script>
</body>
</html>
