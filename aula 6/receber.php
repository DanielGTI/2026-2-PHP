<?php
// RECEBER: lê os dados de formulario.php e mostra o resultado das superglobais.
declare(strict_types=1);
// __DIR__ é a pasta atual; require_once carrega o apoio somente uma vez.
// Usamos suas funções para ler e exibir textos. Esta página não exige login.
require_once __DIR__ . '/autenticacao.php';
// 1. Descobrir como o navegador enviou a requisição.
// $_SERVER contém informações da requisição. ?? usa 'GET' se a chave não existir.
$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
// in_array procura um valor na lista; true exige comparar o valor e o tipo.
// ! significa "não": entramos neste if quando o método não é GET nem POST.
if (!in_array($metodo, ['GET', 'POST'], true)) {
    // Allow informa os métodos aceitos; 405 informa que o método usado não é aceito.
    header('Allow: GET, POST');
    http_response_code(405);
    exemploInicio('Método não permitido');
    echo '<p>Use os formulários GET ou POST.</p>';
    exemploFim();
    exit; // Encerra o arquivo para não continuar lendo ou exibindo dados.
}
// 2. Escolher o array que contém os campos enviados.
// condição ? valorA : valorB é uma escolha curta: POST usa $_POST; GET usa $_GET.
// Escolher a origem evita depender da ordem de combinação usada por $_REQUEST.
$dados = $metodo === 'POST' ? $_POST : $_GET;
// As chaves 'nome' e 'email' vêm dos atributos name nos campos do formulário.
// exemploTexto aceita apenas texto; trim remove espaços no começo e no fim.
$nome = trim(exemploTexto($dados, 'nome'));
$email = trim(exemploTexto($dados, 'email'));
// array_key_exists verifica se o campo foi enviado, mesmo que o valor esteja vazio.
// || significa "ou": basta um dos dois campos estar presente para indicar um envio.
$enviado = array_key_exists('nome', $dados) || array_key_exists('email', $dados);
// 3. Validar no servidor. && exige que todas as condições sejam verdadeiras.
// O nome não pode estar vazio. strlen conta bytes, inclusive os usados pelos acentos.
// filter_var com FILTER_VALIDATE_EMAIL verifica o formato do e-mail e retorna false
// se ele for inválido. Isso não confirma que a caixa de e-mail realmente existe.
$valido = $nome !== '' && strlen($nome) <= 100 && strlen($email) <= 254
    && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
if ($enviado && !$valido) {
    // 422 informa que os campos chegaram, mas seus valores não passaram na validação.
    http_response_code(422);
}
// 4. Exibir a resposta. Só agora começamos o HTML, depois de definir o status HTTP.
exemploInicio('Receber dados — GET, POST e REQUEST');
?>
<p>Método recebido em <code>$_SERVER['REQUEST_METHOD']</code>: <strong><?= exemploEscapar($metodo) ?></strong>.</p>
<!-- Esta forma de if/elseif/else/endif permite colocar HTML entre as condições. -->
<?php if (!$enviado): ?>
    <p class="dica">Nenhum campo foi enviado. Abra <a href="formulario.php">formulario.php</a> e escolha um método.</p>
<?php elseif (!$valido): ?>
    <p class="erro" role="alert">Dados inválidos. Informe nome com até 100 bytes e e-mail válido. A validação ocorre no servidor, mesmo que a validação do navegador seja ignorada.</p>
<?php else: ?>
    <!-- A tag PHP com = exibe um valor. Escapar faz as tags digitadas virarem texto. -->
    <div class="resultado"><p>Nome: <?= exemploEscapar($nome) ?><br>E-mail: <?= exemploEscapar($email) ?></p></div>
<?php endif; ?>
<h2>Comparar as superglobais recebidas</h2>
<?php
// Cada chave é um rótulo literal (aspas simples); cada valor é o array real recebido.
// foreach percorre os três pares, mostrando um título e os dados em cada volta.
foreach (['$_GET' => $_GET, '$_POST' => $_POST, '$_REQUEST' => $_REQUEST] as $rotulo => $array): ?>
    <h3><?= exemploEscapar($rotulo) ?></h3>
    <!-- print_r mostra chaves e valores. true devolve o texto em vez de imprimir direto. -->
    <!-- Escapamos esse texto; pre preserva a disposição das linhas no navegador. -->
    <pre><?= exemploEscapar(print_r($array, true)) ?></pre>
<?php endforeach; ?>
<!-- ini_get consulta a configuração do PHP; (string) converte o retorno para texto. -->
<p>Configuração: <code>request_order = <?= exemploEscapar((string) ini_get('request_order')) ?></code>. Experimente enviar um POST para <code>receber.php?nome=NomeDaURL</code> e compare as chaves repetidas.</p>
<p><a href="formulario.php">Voltar e enviar com outro método</a>. Os dados deste formulário são apenas exibidos, sem gravar no perfil ou no servidor.</p>
<?php exemploFim(); // Fecha o HTML aberto pela função exemploInicio. ?>
