<?php
// PÁGINA PRINCIPAL: o PHP prepara os dados e depois monta os exemplos em HTML.
// strict_types exige os tipos declarados nas funções nas chamadas feitas aqui.
declare(strict_types=1);

/** Aula 6 — Variáveis pré-definidas (superglobais). */
// Esta função transforma sinais como <, > e aspas em texto para exibição em HTML.
// string indica que o parâmetro e o retorno são textos. return devolve o resultado.
function escapar(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Lê uma chave de um array, por exemplo texto($_GET, 'txt_nome').
// Se o campo faltar ou vier como array em vez de texto, usamos o valor padrão.
// O valor padrão é '' quando o terceiro argumento não é informado.
function texto(array $dados, string $chave, string $padrao = ''): string
{
    // isset verifica se o valor existe e não é null; is_string verifica se é texto.
    // && exige as duas condições; condição ? valorA : valorB escolhe o retorno.
    return isset($dados[$chave]) && is_string($dados[$chave]) ? $dados[$chave] : $padrao;
}

// PRATIQUE — BLOCO 1: altere as bandas dos dois arrays.
$bandas1 = ['Pearl Jam', 'Metallica', 'Nirvana'];
$bandas2 = ['New Order', 'Angra', 'Faith No More'];
function bandas(): void
{
    // Dentro da função, $GLOBALS permite acessar as variáveis criadas fora dela.
    // array_merge junta os itens; a chave 'resultadoBandas' cria um resultado global.
    $GLOBALS['resultadoBandas'] = array_merge($GLOBALS['bandas1'], $GLOBALS['bandas2']);
}
bandas(); // Chamar a função executa as instruções que foram definidas acima.

// PRATIQUE — BLOCO 2: acrescente ou remova índices do servidor.
$indicesServidor = ['SERVER_NAME', 'HTTP_HOST', 'HTTP_USER_AGENT', 'SCRIPT_NAME',
    'PHP_SELF', 'GATEWAY_INTERFACE', 'SERVER_ADDR', 'SERVER_SOFTWARE',
    'SERVER_PROTOCOL', 'REQUEST_METHOD', 'REQUEST_TIME', 'QUERY_STRING',
    'HTTP_ACCEPT', 'HTTP_ACCEPT_CHARSET', 'HTTP_REFERER', 'HTTPS', 'REMOTE_ADDR',
    'REMOTE_HOST', 'REMOTE_PORT', 'SCRIPT_FILENAME', 'SERVER_ADMIN', 'SERVER_PORT',
    'SERVER_SIGNATURE', 'PATH_TRANSLATED', 'SCRIPT_URI'];

// PRATIQUE — BLOCOS 3 E 4: valores iniciais dos formulários.
$nomeInicial = 'Ana';
$emailInicial = 'ana@example.com';
// As chaves txt_nome e txt_email vêm do atributo name de cada campo do formulário.
// $_GET recebe campos da URL; $_POST recebe campos enviados no corpo da requisição.
// Os valores iniciais aparecem quando o visitante ainda não enviou os campos.
$nomeGet = texto($_GET, 'txt_nome', $nomeInicial);
$emailGet = texto($_GET, 'txt_email', $emailInicial);
$nomePost = texto($_POST, 'txt_nome', $nomeInicial);
$emailPost = texto($_POST, 'txt_email', $emailInicial);

// PRATIQUE — BLOCO 5: compare a banda na URL e a banda enviada por POST.
$bandaUrl = 'One Direction';
$bandaFormulario = 'Pink Floyd';
// Lemos a mesma chave em três arrays para observar de onde veio cada resultado.
// $_REQUEST combina entradas conforme a configuração do PHP, não inclui a sessão.
$bandaGet = texto($_GET, 'txt_banda', '(não enviada)');
$bandaPost = texto($_POST, 'txt_banda', '(não enviada)');
$bandaRequest = texto($_REQUEST, 'txt_banda', '(não enviada)');

// PRATIQUE — BLOCO 6: limite em bytes e formatos permitidos.
$limiteUpload = 20000;
$tiposPermitidos = ['image/jpeg' => 'jpg', 'image/gif' => 'gif'];
$diretorioUpload = sys_get_temp_dir() . '/aula6-uploads';
$mensagemUpload = 'Envie uma imagem JPEG ou GIF com menos de 20.000 bytes.';
$dadosUpload = [];
// Só processamos o upload quando o campo name="foto" chegou como um array de dados.
if (isset($_FILES['foto']) && is_array($_FILES['foto'])) {
    // $arquivo guarda os dados de uma única imagem, incluindo tamanho e código de erro.
    $arquivo = $_FILES['foto'];
    if (!isset($arquivo['error']) || !is_int($arquivo['error'])) {
        $mensagemUpload = 'Formato de envio inválido: selecione apenas um arquivo.';
    } elseif ($arquivo['error'] !== UPLOAD_ERR_OK) {
        $mensagemUpload = 'Upload não concluído. Código de erro: ' . $arquivo['error'];
    } elseif (!isset($arquivo['size']) || !is_int($arquivo['size']) || $arquivo['size'] >= $limiteUpload) {
        $mensagemUpload = 'Arquivo maior ou igual ao limite de ' . $limiteUpload . ' bytes.';
    } else {
        // tmp_name é o caminho temporário criado pelo PHP, não o nome no computador do aluno.
        $temporario = texto($arquivo, 'tmp_name');
        // is_uploaded_file confirma que o arquivo veio de um upload HTTP.
        // finfo inspeciona o conteúdo para descobrir o tipo; não confiamos apenas no nome.
        $tipoReal = is_uploaded_file($temporario) ? (new finfo(FILEINFO_MIME_TYPE))->file($temporario) : false;
        if (!is_string($tipoReal) || !isset($tiposPermitidos[$tipoReal])) {
            $mensagemUpload = 'Arquivo inválido: o conteúdo deve ser JPEG ou GIF.';
        // is_dir consulta a pasta. Se não existir, mkdir tenta criá-la.
        // 0700 restringe o acesso ao dono; true permite criar as pastas intermediárias.
        } elseif (!is_dir($diretorioUpload) && !mkdir($diretorioUpload, 0700, true)) {
            $mensagemUpload = 'Não foi possível criar a pasta de uploads.';
        } else {
            // Um nome gerado evita sobrescrever arquivos e usar caminhos enviados pelo cliente.
            $destino = $diretorioUpload . '/' . bin2hex(random_bytes(12)) . '.' . $tiposPermitidos[$tipoReal];
            // move_uploaded_file tira o upload da pasta temporária e o guarda no destino.
            // Se retornar true, preparamos os dados que serão exibidos no bloco 6.
            if (move_uploaded_file($temporario, $destino)) {
                $mensagemUpload = 'Arquivo recebido e guardado fora da pasta pública.';
                $dadosUpload = ['name' => texto($arquivo, 'name'), 'type (informado)' => texto($arquivo, 'type'),
                    'tipo verificado' => $tipoReal, 'size (bytes)' => $arquivo['size'],
                    'tmp_name' => $temporario, 'error' => $arquivo['error'], 'destino' => $destino];
            } else {
                $mensagemUpload = 'Não foi possível guardar o arquivo.';
            }
        }
    }
}

// PRATIQUE — BLOCO 7: cores permitidas e duração do cookie em segundos.
$coresPermitidas = ['#ff0' => 'Amarelo', '#eaf4ff' => 'Azul', '#fcfcfd' => 'Branco'];
$duracaoCookie = 600;
$cookieCor = texto($_COOKIE, 'cor', '#fcfcfd');
// Aceitamos somente uma cor da lista, antes de colocá-la no CSS da página.
$corFundo = isset($coresPermitidas[$cookieCor]) ? $cookieCor : '#fcfcfd';
$acao = texto($_POST, 'acao');
// O botão clicado envia a chave 'acao', usada para escolher salvar ou remover o cookie.
$mensagemCookie = 'O cookie recebido nesta requisição aparece abaixo.';
$opcoesCookie = ['expires' => time() + $duracaoCookie, 'path' => '/',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true, 'samesite' => 'Lax'];
if ($acao === 'salvar_cor') {
    $novaCor = texto($_POST, 'cor');
    if (isset($coresPermitidas[$novaCor])) {
        // setcookie envia um cabeçalho antes do HTML. O navegador guarda a preferência
        // e só a devolve em $_COOKIE na próxima requisição.
        setcookie('cor', $novaCor, $opcoesCookie);
        $mensagemCookie = 'Cookie enviado! Atualize a página para recebê-lo em $_COOKIE e aplicar a cor.';
    }
} elseif ($acao === 'remover_cor') {
    // Uma data de expiração no passado pede ao navegador para remover o cookie.
    $opcoesCookie['expires'] = time() - 3600;
    setcookie('cor', '', $opcoesCookie);
    $mensagemCookie = 'Cookie removido! Atualize a página para ver a cor padrão.';
}

// PRATIQUE — BLOCOS 8 E 9: dados da sessão. Tudo antes de qualquer HTML.
$topicoInicial = 'Trabalhando com sessões em PHP';
$leituraInicial = 'sim';
session_name('AULA6SESSID');
// session_start recupera a sessão anterior ou inicia uma nova.
// Este exemplo guarda dados de um tópico; ele não autentica nas páginas de login.
session_start(['cookie_httponly' => true, 'cookie_samesite' => 'Lax', 'use_strict_mode' => true]);
$mensagemSessao = 'Use os botões para criar, consultar e encerrar a sessão.';
if ($acao === 'criar_sessao') {
    // Cada atribuição cria ou substitui um valor no array $_SESSION.
    $_SESSION['topico'] = $topicoInicial;
    $_SESSION['ler'] = $leituraInicial;
    $_SESSION['visitas'] = 0;
    $mensagemSessao = 'Dados gravados na sessão.';
} elseif ($acao === 'encerrar_sessao') {
    // session_unset limpa as variáveis; session_destroy destrói os dados armazenados.
    session_unset();
    session_destroy();
    $parametros = session_get_cookie_params();
    // Usamos o mesmo nome e caminho do cookie, com uma data passada, para removê-lo.
    setcookie(session_name(), '', ['expires' => time() - 3600, 'path' => $parametros['path'],
        'secure' => $parametros['secure'], 'httponly' => true, 'samesite' => 'Lax']);
    $mensagemSessao = 'Dados e cookie da sessão removidos.';
}
if (isset($_SESSION['topico'])) {
    // ?? usa zero se não houver contador. (int) converte para inteiro e + 1 conta o acesso.
    $_SESSION['visitas'] = (int) ($_SESSION['visitas'] ?? 0) + 1;
}
$podeLer = ($_SESSION['ler'] ?? '') === 'sim';

// Esta função monta o painel escuro com um código que o aluno pode copiar.
// $titulo descreve o exemplo; $codigo contém o programa mostrado, sem executá-lo aqui.
// Os resultados da página são calculados nos trechos PHP de cada bloco.
function exemplo(string $titulo, string $codigo): void
{
    ?>
    <section class="codigo">
        <button class="copiar-codigo" type="button" aria-label="Copiar código do exemplo" title="Copiar código">
            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
        </button>
        <h3>1. Código PHP: <?= escapar($titulo) ?> — <a href="https://onecompiler.com/php" target="_blank" rel="noopener noreferrer">Praticar no OneCompiler</a></h3>
        <!-- Escapamos o código para mostrar suas tags como texto, preservando as linhas. -->
        <pre><code><?= escapar($codigo) ?></code></pre>
    </section>
    <?php
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <!-- charset define a codificação dos acentos; viewport adapta a página à tela. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aula 6 — Variáveis pré-definidas em PHP</title>
    <style>
        /* CSS define a aparência. A cor do fundo vem da lista de cores permitidas. */
        body { background: <?= escapar($corFundo) ?>; font-family: Arial, sans-serif; line-height: 1.6; margin: 2rem auto; max-width: 960px; padding: 0 1rem; color: #202124; }
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
        .dica { background: #eaf4ff; border-left: 4px solid #2878c8; margin: 1rem 0; padding: .65rem 1rem; }
        .codigo { background: #282c34; border-left: 4px solid #f39c12; color: #f8f8f2; padding: .75rem 1rem; position: relative; }
        .codigo h3 { color: #fff; margin-top: 0; padding-right: 2rem; }
        .codigo h3 a { color: #f9d65c; }
        .codigo pre { background: #1e2127; color: #f8f8f2; margin-bottom: 0; }
        .codigo code { color: inherit; }
        .copiar-codigo { background: #3b4048; border: 1px solid #737985; border-radius: 4px; color: #fff; cursor: pointer; height: 2rem; position: absolute; right: 1rem; top: .75rem; width: 2rem; }
        .copiar-codigo:hover, .copiar-codigo:focus-visible { background: #505762; outline: 2px solid #f39c12; outline-offset: 2px; }
        .copiar-codigo svg { height: 1.1rem; width: 1.1rem; }
        .localizacao { background: #fff7e6; border-left: 4px solid #f39c12; margin: 0; padding: .65rem 1rem; }
        details { margin-top: 1rem; }
        summary { cursor: pointer; font-weight: bold; }
        form { background: #fff; border: 1px solid #ddd; border-radius: 6px; margin: 1rem 0; padding: 1rem; }
        label { display: block; margin: .4rem 0; }
        input, select, button { font: inherit; max-width: 100%; }
        input, select { box-sizing: border-box; padding: .3rem; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ddd; padding: .5rem; text-align: left; overflow-wrap: anywhere; }
        .resultado pre { white-space: pre-wrap; overflow-wrap: anywhere; }
    </style>
</head>
<body>
    <h1>Aula 6 — Variáveis pré-definidas (superglobais)</h1>
    <p>Conteúdo baseado no material do Prof. Adriano Kleber Milanez, com exemplos adaptados para PHP 8.3. Os resultados são calculados no servidor, como na aula 3.</p>
    <section class="introducao">
        <strong>Objetivo:</strong> acessar variáveis globais, consultar o servidor, receber formulários e arquivos e manter informações com cookies e sessões.
        <br><strong>Como estudar:</strong> leia a explicação, copie o exemplo e observe o resultado. Os exemplos de console simulam os dados HTTP quando necessário; os formulários desta página usam requisições reais.
    </section>
    <p>Superglobais são arrays disponíveis em qualquer escopo, inclusive dentro de funções e métodos, sem <code>global</code>. O PDF apresenta <code>$GLOBALS</code>, <code>$_SERVER</code>, <code>$_GET</code>, <code>$_POST</code>, <code>$_REQUEST</code>, <code>$_FILES</code>, <code>$_COOKIE</code> e <code>$_SESSION</code>. O PHP também oferece <code>$_ENV</code>.</p>

    <section class="introducao" id="exemplos-arquivos">
        <h2>Exemplos em arquivos separados</h2>
        <p>Teste como as superglobais funcionam entre páginas. Para o login, use <strong>usuário aluno</strong> e <strong>senha php123</strong>.</p>
        <ul>
            <li><a href="login.php">login.php — Entrar</a>: recebe as credenciais por <code>$_POST</code>, verifica a senha e registra o usuário em <code>$_SESSION</code>. Teste uma senha errada e depois a correta.</li>
            <li><a href="area-restrita.php">area-restrita.php — Página logada</a>: exige login e sessão válida antes de enviar o conteúdo. Abra primeiro sem login ou em uma janela anônima para observar o redirecionamento.</li>
            <li><a href="perfil.php">perfil.php — Outra página protegida</a>: lê a mesma sessão e permite alterar o nome. Volte à área restrita para ver o nome atualizado.</li>
            <li><a href="logout.php">logout.php — Sair</a>: apresenta uma confirmação e encerra a sessão por POST. Após sair, tente abrir a área restrita diretamente pela URL.</li>
            <li><a href="autenticacao.php">autenticacao.php — Entender a proteção</a>: explica o arquivo comum que inicia a sessão, confere a expiração e impede acesso sem login. O limite de inatividade é de 15 minutos e pode ser alterado para testar.</li>
            <li><a href="formulario.php">formulario.php — Enviar GET e POST</a>: apresenta dois formulários públicos com os mesmos campos, ambos enviados para outro arquivo PHP.</li>
            <li><a href="receber.php">receber.php — Receber e comparar os dados</a>: valida nome/e-mail no servidor e mostra <code>$_GET</code>, <code>$_POST</code> e <code>$_REQUEST</code>. Sem envio, orienta a voltar ao formulário.</li>
        </ul>
        <p><strong>Roteiro:</strong> tente abrir a área restrita → faça login → altere o perfil → volte à área restrita → saia → tente entrar novamente pela URL.</p>
        <p>A sessão de login usa o nome <code>AULA6LOGIN</code>. A sessão didática dos blocos abaixo usa <code>AULA6SESSID</code>; clicar em “Criar sessão” no bloco 8 não concede acesso às páginas protegidas.</p>
    </section>

    <h2>Bloco 1 — $GLOBALS e escopo</h2>
    <p class="explicacao"><code>$GLOBALS</code> permite acessar uma variável global pelo seu nome, sem o símbolo <code>$</code> na chave. Uma função pode combinar os dois arrays de bandas e guardar o resultado no escopo global.</p>
    <?php
    // <<<'PHP' inicia um texto chamado nowdoc, que termina na linha marcada com PHP.
    // O código dentro desse texto será mostrado ao aluno, não executado neste ponto.
    // Os outros blocos usam a mesma forma de escrever seus exemplos copiáveis.
    exemplo('mesclando bandas dentro de uma função', <<<'PHP'
<?php
$bandas1 = ['Pearl Jam', 'Metallica', 'Nirvana'];
$bandas2 = ['New Order', 'Angra', 'Faith No More'];
function bandas(): void
{
    // Cada chave corresponde ao nome de uma variável global.
    $GLOBALS['resultado'] = array_merge($GLOBALS['bandas1'], $GLOBALS['bandas2']);
}
bandas();
foreach ($resultado as $banda) {
    echo $banda . "\n";
}
?>
PHP); ?>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>25 a 33</strong>. Altere as bandas; a função combina os arrays e a saída é exibida nas linhas <strong>270 a 273</strong>.</p>
    <div class="resultado">
        <p><strong>2. Resultado:</strong></p>
        <pre><?= escapar(implode("\n", $resultadoBandas)) ?></pre>
    </div>
    <p class="dica">A superglobal se chama <code>$GLOBALS</code>, no plural. Outra opção é declarar <code>global $bandas1;</code> dentro da função; são sintaxes diferentes.</p>

    <h2>Bloco 2 — $_SERVER</h2>
    <p class="explicacao">Este array informa dados da requisição e do servidor: host, navegador, método, porta e caminho do script. Os índices disponíveis variam conforme o servidor e a execução em navegador ou console.</p>
    <?php exemplo('consultando informações do servidor', <<<'PHP'
<?php
// O console não recebe uma requisição HTTP: simule os dados do navegador.
$servidor = ['SERVER_NAME' => 'localhost', 'HTTP_HOST' => 'localhost:8084',
    'HTTP_USER_AGENT' => 'Navegador de exemplo', 'SCRIPT_NAME' => '/index.php'];
foreach ($servidor as $indice => $valor) {
    echo $indice . ': ' . $valor . "\n";
}
// Em uma página web, use $_SERVER no lugar de $servidor.
echo 'Método real: ' . ($_SERVER['REQUEST_METHOD'] ?? 'CLI (console)') . "\n";
?>
PHP); ?>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>36 a 41</strong>. Escolha os índices consultados; a tabela real é montada nas linhas <strong>291 a 298</strong>.</p>
    <div class="resultado">
        <p><strong>2. Resultado real desta requisição:</strong></p>
        <table><thead><tr><th scope="col">Índice de $_SERVER</th><th scope="col">Valor</th></tr></thead><tbody>
        <?php foreach ($indicesServidor as $indice): ?>
            <tr><th scope="row"><?= escapar($indice) ?></th><td><?= escapar((string) ($_SERVER[$indice] ?? '(não disponível)')) ?></td></tr>
        <?php endforeach; ?>
        </tbody></table>
    </div>
    <p class="dica"><code>HTTP_REFERER</code>, quando presente, indica a página de origem. Cabeçalhos como host e navegador vêm do cliente. Nem todas as chaves existem: use <code>??</code> e escape os textos ao exibi-los em HTML.</p>

    <h2>Bloco 3 — $_GET: dados na URL</h2>
    <p class="explicacao">Com <code>method="get"</code>, os campos com atributo <code>name</code> são enviados na URL. Por exemplo: <code>?txt_nome=Ana&amp;txt_email=ana%40example.com</code>. O PHP disponibiliza esses valores em <code>$_GET</code>.</p>
    <?php exemplo('recebendo nome e e-mail por GET', <<<'PHP'
<?php
// Simulação de uma URL ?txt_nome=Ana&txt_email=ana%40example.com.
$_GET = ['txt_nome' => 'Ana', 'txt_email' => 'ana@example.com'];
$nome = $_GET['txt_nome'] ?? 'Não informado';
$email = $_GET['txt_email'] ?? 'Não informado';
echo 'Nome: ' . $nome . "\n";
echo 'E-mail: ' . $email . "\n";
?>
PHP); ?>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>44 a 50</strong>. Altere os valores iniciais ou envie o formulário; o resultado está nas linhas <strong>314 a 318</strong>.</p>
    <div class="resultado">
        <p><strong>2. Resultado GET:</strong></p>
        <p>Nome: <?= escapar($nomeGet) ?><br>E-mail: <?= escapar($emailGet) ?></p>
        <p>Consulta recebida: <code><?= escapar(texto($_SERVER, 'QUERY_STRING', '(vazia)')) ?></code></p>
    </div>
    <form method="get" action="/index.php#form-get" id="form-get">
        <label for="get-nome">Nome: <input id="get-nome" name="txt_nome" value="<?= escapar($nomeGet) ?>" maxlength="100" required></label>
        <label for="get-email">E-mail: <input id="get-email" name="txt_email" type="email" value="<?= escapar($emailGet) ?>" required></label>
        <button type="submit">Enviar por GET</button>
    </form>
    <p class="dica">Use GET para consultas e filtros. Os dados aparecem na URL e podem ficar no histórico; evite enviar senhas nesse método.</p>

    <h2>Bloco 4 — $_POST: dados no corpo da requisição</h2>
    <p class="explicacao">Com <code>method="post"</code>, os campos são enviados no corpo da requisição e lidos em <code>$_POST</code>. O atributo <code>name</code> continua definindo a chave.</p>
    <?php exemplo('recebendo nome e e-mail por POST', <<<'PHP'
<?php
// Simulação dos campos enviados por um formulário method="post".
$_POST = ['txt_nome' => 'Ana', 'txt_email' => 'ana@example.com'];
$nome = $_POST['txt_nome'] ?? 'Não informado';
$email = $_POST['txt_email'] ?? 'Não informado';
echo 'Nome: ' . $nome . "\n";
echo 'E-mail: ' . $email . "\n";
?>
PHP); ?>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>44 a 52</strong>. Mude os dados iniciais ou envie por POST; a saída está nas linhas <strong>339 a 343</strong>.</p>
    <div class="resultado">
        <p><strong>2. Resultado POST:</strong></p>
        <p>Nome: <?= escapar($nomePost) ?><br>E-mail: <?= escapar($emailPost) ?></p>
        <p>Método atual: <?= escapar(texto($_SERVER, 'REQUEST_METHOD', 'CLI')) ?>. Limite configurado: <code>post_max_size = <?= escapar((string) ini_get('post_max_size')) ?></code>.</p>
    </div>
    <form method="post" action="/index.php#form-post" id="form-post">
        <label for="post-nome">Nome: <input id="post-nome" name="txt_nome" value="<?= escapar($nomePost) ?>" maxlength="100" required></label>
        <label for="post-email">E-mail: <input id="post-email" name="txt_email" type="email" value="<?= escapar($emailPost) ?>" required></label>
        <button type="submit">Enviar por POST</button>
    </form>
    <p class="dica">POST não criptografa os dados. HTTPS protege o transporte. Há limites de tamanho no PHP e no servidor web; campos recebidos também precisam de validação no servidor.</p>

    <h2>Bloco 5 — $_REQUEST e precedência</h2>
    <p class="explicacao"><code>$_REQUEST</code> reúne entradas de GET, POST e, conforme a configuração, cookies. A diretiva <code>request_order</code>, ou <code>variables_order</code> quando ela não está definida, determina a composição e a ordem. Não inclui sessões ou uploads.</p>
    <?php exemplo('comparando uma chave repetida em GET e POST', <<<'PHP'
<?php
$get = ['txt_banda' => 'One Direction'];
$post = ['txt_banda' => 'Pink Floyd'];
// Simula a ordem GP: POST substitui GET quando as chaves são iguais.
$request = array_merge($get, $post);
echo 'GET: ' . $get['txt_banda'] . "\n";
echo 'POST: ' . $post['txt_banda'] . "\n";
echo 'REQUEST simulado (GP): ' . $request['txt_banda'] . "\n";
// Alterar $_GET durante a execução não recalcula automaticamente $_REQUEST.
?>
PHP); ?>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>55 a 61</strong>. Troque as bandas da URL e do formulário; compare as saídas nas linhas <strong>366 a 370</strong>.</p>
    <div class="resultado">
        <p><strong>2. Resultado real:</strong></p>
        <p>GET: <?= escapar($bandaGet) ?><br>POST: <?= escapar($bandaPost) ?><br>REQUEST: <?= escapar($bandaRequest) ?></p>
        <p><code>request_order = <?= escapar((string) ini_get('request_order')) ?></code>; <code>variables_order = <?= escapar((string) ini_get('variables_order')) ?></code>.</p>
    </div>
    <form method="post" action="/index.php?<?= escapar(http_build_query(['txt_banda' => $bandaUrl])) ?>#form-request" id="form-request">
        <p>A URL enviará: <?= escapar($bandaUrl) ?>.</p>
        <label for="request-banda">Banda por POST: <input id="request-banda" name="txt_banda" value="<?= escapar($bandaFormulario) ?>" required></label>
        <button type="submit">Comparar GET, POST e REQUEST</button>
    </form>
    <p class="dica">Prefira <code>$_GET</code> ou <code>$_POST</code> quando precisar saber a origem do dado. A precedência observada depende da configuração, não de uma ordem universal.</p>

    <h2>Bloco 6 — $_FILES e upload</h2>
    <p class="explicacao">Um envio de arquivo exige <code>method="post"</code>, <code>enctype="multipart/form-data"</code> e um campo <code>type="file"</code>. A chave do campo dá acesso a <code>name</code>, <code>type</code>, <code>size</code>, <code>tmp_name</code> e <code>error</code>.</p>
    <?php exemplo('consultando os dados de um arquivo enviado', <<<'PHP'
<?php
// Simulação: o console não recebe uploads de um formulário web.
$_FILES = ['foto' => ['name' => 'foto.gif', 'type' => 'image/gif',
    'size' => 15360, 'tmp_name' => '/tmp/phpExemplo', 'error' => UPLOAD_ERR_OK]];
$arquivo = $_FILES['foto'];
if ($arquivo['error'] === UPLOAD_ERR_OK && $arquivo['size'] < 20000) {
    foreach ($arquivo as $chave => $valor) {
        echo $chave . ': ' . $valor . "\n";
    }
    echo 'Tamanho em KiB: ' . ($arquivo['size'] / 1024) . "\n";
} else {
    echo "Erro no envio ou limite excedido.\n";
}
// Na página, finfo verifica o conteúdo e move_uploaded_file guarda o upload real.
// Um caminho inventado em tmp_name não é um upload válido.
?>
PHP); ?>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>64 a 68</strong>. Ajuste limite e tipos; o processamento usa <code>finfo</code> e <code>move_uploaded_file()</code>. A saída está nas linhas <strong>399 a 403</strong>.</p>
    <div class="resultado">
        <p><strong>2. Resultado do upload real:</strong> <?= escapar($mensagemUpload) ?></p>
        <pre><?= escapar(print_r($dadosUpload, true)) ?></pre>
        <p>Limites do ambiente: <code>upload_max_filesize = <?= escapar((string) ini_get('upload_max_filesize')) ?></code> e <code>post_max_size = <?= escapar((string) ini_get('post_max_size')) ?></code>.</p>
    </div>
    <form method="post" action="/index.php#form-upload" enctype="multipart/form-data" id="form-upload">
        <label for="foto">Imagem JPEG ou GIF (menos de <?= $limiteUpload ?> bytes): <input type="file" name="foto" id="foto" accept="image/jpeg,image/gif" required></label>
        <button type="submit">Enviar arquivo</button>
    </form>
    <p class="dica"><code>type</code> e o nome são informados pelo cliente. Esta página verifica o conteúdo com <code>finfo</code>, trata o código de erro e gera um nome próprio. Os arquivos ficam em <code>/tmp/aula6-uploads</code>, fora da pasta pública, e são descartados ao remover o contêiner.</p>

    <h2>Bloco 7 — $_COOKIE e setcookie()</h2>
    <p class="explicacao">Cookies são valores armazenados pelo navegador e enviados nas próximas requisições. <code>setcookie()</code> envia um cabeçalho HTTP e deve ser executado antes do HTML. O cookie novo só aparece em <code>$_COOKIE</code> na requisição seguinte.</p>
    <?php exemplo('criando e lendo uma preferência de cor', <<<'PHP'
<?php
// Execute antes de qualquer echo. expires recebe uma data Unix futura.
setcookie('cor', '#ff0', ['expires' => time() + 600, 'path' => '/',
    'httponly' => true, 'samesite' => 'Lax']);
// No console, simulamos o cookie devolvido pelo navegador na próxima visita.
$_COOKIE = ['cor' => '#ff0'];
echo 'Cor recebida: ' . ($_COOKIE['cor'] ?? '#fcfcfd') . "\n";
echo "Duração configurada: 600 segundos (10 minutos).\n";
// Para remover no navegador: envie o mesmo nome/path com expires no passado.
?>
PHP); ?>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>109 a 132</strong>. Altere as cores e a duração. O resultado está nas linhas <strong>425 a 428</strong>; o fundo usa a cor validada no estilo de <code>body</code>.</p>
    <div class="resultado">
        <p><strong>2. Resultado:</strong> <?= escapar($mensagemCookie) ?></p>
        <p>Cookie <code>cor</code> recebido: <?= escapar(texto($_COOKIE, 'cor', '(ausente)')) ?>. Cor aplicada: <?= escapar($corFundo) ?>.</p>
    </div>
    <form method="post" action="/index.php#form-cookie" id="form-cookie">
        <label for="cor">Cor de fundo: <select id="cor" name="cor">
            <?php foreach ($coresPermitidas as $cor => $nomeCor): ?>
                <option value="<?= escapar($cor) ?>" <?= $cor === $corFundo ? 'selected' : '' ?>><?= escapar($nomeCor) ?></option>
            <?php endforeach; ?>
        </select></label>
        <button name="acao" value="salvar_cor">Salvar cookie</button>
        <button name="acao" value="remover_cor">Remover cookie</button>
    </form>
    <p class="dica"><code>Secure</code> restringe o envio a conexões HTTPS; <code>HttpOnly</code> impede a leitura pelo JavaScript. São opções distintas. O navegador pode bloquear cookies, e valores recebidos devem ser validados.</p>

    <h2>Bloco 8 — $_SESSION: informações entre páginas</h2>
    <p class="explicacao"><code>session_start()</code> inicia ou retoma uma sessão antes do HTML. Os dados ficam no servidor e o navegador normalmente guarda um cookie com o identificador. Outra página pode consultar os mesmos valores usando o mesmo nome de sessão e <code>session_start()</code>.</p>
    <?php exemplo('gravando e consultando uma sessão', <<<'PHP'
<?php
session_start(); // Antes de qualquer saída.
$_SESSION['topico'] = 'Trabalhando com sessões em PHP';
$_SESSION['ler'] = 'sim';
if (($_SESSION['ler'] ?? '') === 'sim') {
    echo 'Você está habilitado a acessar o tópico ' . $_SESSION['topico'] . "\n";
} else {
    echo "Você não está habilitado a acessar este tópico!\n";
}
session_write_close(); // Grava os dados e libera a sessão.
?>
PHP); ?>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>136 a 163</strong>. Altere o tópico ou troque <code>'sim'</code> por <code>'não'</code> e clique em criar sessão. A consulta está nas linhas <strong>456 a 461</strong>.</p>
    <div class="resultado">
        <p><strong>2. Resultado:</strong> <?= escapar($mensagemSessao) ?></p>
        <p><?= $podeLer ? 'Você está habilitado a acessar o tópico ' . escapar(texto($_SESSION, 'topico')) : 'Você não está habilitado a acessar este tópico!' ?></p>
        <p>Requisições desde a criação: <?= (int) ($_SESSION['visitas'] ?? 0) ?>. Atualize a página para consultar novamente.</p>
        <p>Coleta de dados antigos: <code>session.gc_maxlifetime = <?= escapar((string) ini_get('session.gc_maxlifetime')) ?></code> segundos. Cookie: <code>session.cookie_lifetime = <?= escapar((string) ini_get('session.cookie_lifetime')) ?></code> segundos.</p>
    </div>
    <form method="post" action="/index.php#form-session" id="form-session">
        <button name="acao" value="criar_sessao">Criar / reiniciar dados da sessão</button>
        <button name="acao" value="encerrar_sessao">Encerrar sessão</button>
        <a href="/index.php#form-session">Consultar em outra requisição</a>
    </form>
    <p class="dica">A comparação de <code>ler</code> é apenas uma demonstração, não um sistema de login. Não há duração universal de 180 minutos: a configuração e a aplicação determinam a expiração. <code>session_cache_expire()</code> controla o cache, não o tempo de autenticação.</p>

    <h2>Bloco 9 — Encerrando e gerenciando sessões</h2>
    <p class="explicacao"><code>session_unset()</code> limpa as variáveis; <code>session_destroy()</code> destrói os dados persistidos. Para encerrar também a identificação no navegador, expire o cookie de sessão. O botão acima realiza essas etapas antes do HTML.</p>
    <?php exemplo('limpando os dados da sessão', <<<'PHP'
<?php
session_start();
$_SESSION['topico'] = 'Trabalhando com sessões em PHP';
echo 'Antes: ' . $_SESSION['topico'] . "\n";
session_unset();
session_destroy();
echo 'Depois: ' . ($_SESSION['topico'] ?? '(sessão sem dados)') . "\n";
// Em uma página web, expire também o cookie, antes de qualquer echo.
?>
PHP); ?>
    <p class="localizacao"><strong>Onde alterar no arquivo:</strong> linhas <strong>149 a 157</strong>. Consulte o tratamento de <code>encerrar_sessao</code>; o estado resultante aparece nas linhas <strong>483 a 486</strong>.</p>
    <div class="resultado">
        <p><strong>2. Estado atual dos dados:</strong></p>
        <pre><?= escapar(print_r($_SESSION, true)) ?></pre>
    </div>
    <table>
        <thead><tr><th scope="col">Função</th><th scope="col">Uso</th></tr></thead>
        <tbody>
            <tr><td><code>session_start()</code></td><td>Inicia ou retoma a sessão.</td></tr>
            <tr><td><code>session_status()</code></td><td>Consulta o estado da sessão.</td></tr>
            <tr><td><code>session_name()</code> / <code>session_id()</code></td><td>Consulta ou define nome / identificador.</td></tr>
            <tr><td><code>session_regenerate_id()</code></td><td>Gera outro identificador; útil após autenticação.</td></tr>
            <tr><td><code>session_write_close()</code> / <code>session_commit()</code></td><td>Grava os dados e libera a sessão.</td></tr>
            <tr><td><code>session_abort()</code> / <code>session_reset()</code></td><td>Descarta alterações e fecha / restaura os dados originais.</td></tr>
            <tr><td><code>session_unset()</code> / <code>session_destroy()</code></td><td>Limpa variáveis / destrói dados armazenados.</td></tr>
            <tr><td><code>session_encode()</code> / <code>session_decode()</code></td><td>Serializa / desserializa dados da sessão.</td></tr>
            <tr><td><code>session_get_cookie_params()</code> / <code>session_set_cookie_params()</code></td><td>Consulta / configura o cookie.</td></tr>
            <tr><td><code>session_save_path()</code> / <code>session_module_name()</code> / <code>session_set_save_handler()</code></td><td>Configura o armazenamento.</td></tr>
            <tr><td><code>session_cache_expire()</code> / <code>session_cache_limiter()</code></td><td>Configura o cache HTTP.</td></tr>
            <tr><td><code>session_register_shutdown()</code></td><td>Registra o fechamento da sessão ao terminar o script.</td></tr>
        </tbody>
    </table>
    <p class="dica">As funções antigas <code>session_register()</code>, <code>session_unregister()</code> e <code>session_is_registered()</code> foram removidas. Use atribuição em <code>$_SESSION</code>, <code>unset()</code> e <code>isset()</code>. A grafia correta é <code>$_SESSION</code>, em maiúsculas.</p>

    <h2>Atividade final do material</h2>
    <ol>
        <li>Qual o tempo limite padrão de uma sessão? Alternativas: A) 180 minutos; B) 20 minutos; C) 3 horas; D) 10800 segundos; E) Não existe tempo limite.</li>
        <li>Quais variáveis capturam dados de formulários? A) <code>$_POST, $_GET, $_REQUEST</code>; B) <code>REQUEST.POST, REQUEST.QUERYSTRING</code>; C) <code>$_SERVER, $_GET, $_REQUEST</code>; D) <code>$_POST, $_GET</code>; E) <code>$_POST, $_REQUEST</code>.</li>
        <li>Qual alternativa inicia uma sessão? A) <code>session_start()</code>; B) <code>$_session['variavel']</code>; C) <code>session_name</code>; D) <code>session_id</code>; E) <code>session_unset()</code>.</li>
        <li>O PDF repete a questão sobre criação de sessões. Confirme a função correta e explique por que ela deve vir antes do HTML.</li>
    </ol>
    <details>
        <summary>Respostas explicadas e correções do material</summary>
        <p><strong>1.</strong> A questão não tem resposta técnica única válida como escrita. O texto cita 180 minutos, mas A, C e D representam o mesmo tempo. Isso não é um limite universal de sessão: <code>session.gc_maxlifetime</code> tem padrão de 1440 segundos (24 minutos) para elegibilidade à coleta, sem garantir expiração exata. A duração do cookie e as regras da aplicação também influenciam. “Não existe tempo limite” tampouco descreve todas as configurações.</p>
        <p><strong>2. A.</strong> GET e POST recebem os respectivos campos; REQUEST pode reuni-los conforme a configuração.</p>
        <p><strong>3 e 4. A.</strong> <code>session_start()</code> inicia ou retoma a sessão e pode enviar cabeçalhos HTTP antes da saída.</p>
    </details>
    <details>
        <summary>Resumo para praticar</summary>
        <ul>
            <li>Inclua uma banda e observe o resultado de <code>$GLOBALS</code>.</li>
            <li>Envie os mesmos dados por GET e POST e compare URL e método.</li>
            <li>Compare a banda enviada pela URL com a enviada no formulário REQUEST.</li>
            <li>Envie uma imagem válida, um arquivo de outro tipo e um arquivo grande.</li>
            <li>Salve uma cor, atualize a página, remova o cookie e atualize novamente.</li>
            <li>Crie a sessão, faça outra requisição e encerre a sessão.</li>
        </ul>
    </details>
    <p>Referências atualizadas: <a href="https://www.php.net/manual/pt_BR/reserved.variables.request.php">$_REQUEST</a>, <a href="https://www.php.net/manual/pt_BR/function.setcookie.php">setcookie()</a>, <a href="https://www.php.net/manual/pt_BR/session.configuration.php">configuração de sessões</a> e <a href="https://www.php.net/manual/pt_BR/features.file-upload.php">upload de arquivos</a>, no manual oficial do PHP.</p>
    <script>
        // JavaScript roda no navegador. Aqui ele cuida somente dos botões de cópia.
        // querySelectorAll busca todos os botões com a classe copiar-codigo.
        document.querySelectorAll('.copiar-codigo').forEach((botao) => {
            botao.addEventListener('click', async () => {
                // closest encontra o painel do botão; textContent lê seu código como texto.
                const codigo = botao.closest('.codigo').querySelector('pre code').textContent;
                const iconeOriginal = botao.innerHTML;
                try {
                    if (navigator.clipboard && window.isSecureContext) {
                        // await aguarda a cópia terminar antes de mostrar a confirmação.
                        await navigator.clipboard.writeText(codigo);
                    } else {
                        // Alternativa para navegadores sem a API de cópia: usa um campo temporário.
                        const area = document.createElement('textarea');
                        area.value = codigo;
                        document.body.appendChild(area);
                        area.select();
                        const copiado = document.execCommand('copy');
                        area.remove();
                        if (!copiado) throw new Error('Cópia indisponível');
                    }
                    botao.textContent = '✓';
                    botao.setAttribute('aria-label', 'Código copiado');
                    botao.title = 'Código copiado!';
                    setTimeout(() => {
                        // Após 1.800 milissegundos, o botão volta ao ícone e à descrição iniciais.
                        botao.innerHTML = iconeOriginal;
                        botao.setAttribute('aria-label', 'Copiar código do exemplo');
                        botao.title = 'Copiar código';
                    }, 1800);
                } catch (erro) {
                    botao.title = 'Não foi possível copiar; selecione o código manualmente';
                }
            });
        });
    </script>
</body>
</html>
