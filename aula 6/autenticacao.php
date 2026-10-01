<?php
// O PHP executa este trecho no servidor, antes de montar a página do navegador.
// strict_types pede que os tipos declarados nas funções sejam respeitados
// nas chamadas feitas neste arquivo. Isso ajuda a identificar valores incorretos.
declare(strict_types=1);

/**
 * ARQUIVO DE APOIO: reúne o código usado pelas outras páginas da aula.
 * Aqui ficam a configuração do login, a sessão e as funções de apresentação.
 * As outras páginas carregam este arquivo com require_once antes do HTML.
 * Definir uma função não a executa: ela só trabalha quando é chamada pelo nome.
 */
// const cria um valor fixo que pode ser consultado nas outras páginas.
const LOGIN_USUARIO = 'aluno';
// Este hash foi gerado com password_hash('php123', PASSWORD_DEFAULT).
// Um hash é um resultado usado para conferir a senha, não para recuperá-la.
// login.php usa password_verify() para comparar a senha digitada com este hash.
// Para trocar a senha de demonstração, gere outro hash. Não coloque a senha aqui.
const LOGIN_SENHA_HASH = '$2y$10$Wp8bHpiug6LM/JtS/QlKU.Qaqcox0RNDz2L29jIKCIr.63c/x3AjC';
// O tempo é medido em segundos: 900 / 60 = 15 minutos sem acessar estes exemplos.
const LOGIN_TEMPO_INATIVO = 900;

// 1. INICIAR A SESSÃO
// session_name escolhe o nome do cookie que identifica esta sessão.
// Ele é diferente do usado no index.php; criar a sessão do bloco 8 não faz login.
session_name('AULA6LOGIN');
// session_start inicia uma sessão ou recupera os dados de uma sessão existente.
// Os dados ficam no servidor. O navegador recebe um cookie com o identificador.
// O array abaixo usa 'chave' => valor para configurar o funcionamento da sessão.
session_start([
    'use_strict_mode' => true, // Aceita somente identificadores já conhecidos pelo servidor.
    'cookie_httponly' => true, // Impede que JavaScript leia o cookie da sessão.
    'cookie_samesite' => 'Lax', // Limita o envio do cookie em acessos vindos de outros sites.
    // Usa cookie exclusivo de HTTPS quando a requisição atual é HTTPS.
    'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
]);
// header envia uma instrução HTTP antes do HTML. no-store pede para não guardar
// uma cópia da resposta no cache, inclusive quando ela contém dados do usuário.
header('Cache-Control: no-store');

// 2. FUNÇÕES PARA LER DADOS E MOSTRAR TEXTO
// $dados é o array consultado; $chave é o nome do campo; $padrao é usado se faltar.
// Exemplo: exemploTexto($_POST, 'usuario') lê o campo name="usuario" do formulário.
// array e string indicam os tipos dos parâmetros; : string indica o retorno.
function exemploTexto(array $dados, string $chave, string $padrao = ''): string
{
    // isset verifica se o valor existe e não é null; is_string verifica se é texto.
    // && significa "e": as duas verificações precisam ser verdadeiras.
    // condição ? valorA : valorB escolhe um valor; return o devolve para quem chamou.
    // Um campo enviado como array, por exemplo usuario[]=Ana, não é aceito como texto.
    return isset($dados[$chave]) && is_string($dados[$chave]) ? $dados[$chave] : $padrao;
}

function exemploEscapar(string $texto): string
{
    // Converte sinais como <, > e aspas para que apareçam como texto no HTML.
    // Assim, um nome digitado com tags não vira um comando HTML na página.
    // ENT_QUOTES inclui as aspas; ENT_SUBSTITUTE trata texto com codificação inválida.
    // UTF-8 é a codificação utilizada para exibir os acentos da aula.
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// : void indica que a função não devolve um valor para ser usado em outra expressão.
function exemploRedirecionar(string $pagina): void
{
    // O ponto (.) junta textos. Location informa ao navegador o endereço de destino.
    // O código 303 orienta a abrir esse destino com GET, inclusive após um POST.
    header('Location: ' . $pagina, true, 303);
    // header não encerra o PHP sozinho. exit impede a continuação do conteúdo protegido.
    exit;
}

// 3. VERIFICAR SE O LOGIN CONTINUA VÁLIDO
// : bool significa que a resposta da função será true (sim) ou false (não).
function exemploLogado(): bool
{
    // $_SESSION é o array com os dados da sessão. ['usuario'] acessa uma chave.
    // ?? usa o valor da direita quando a chave não existe ou seu valor é null.
    // === compara valor e tipo. && exige que TODAS as condições abaixo sejam verdadeiras.
    // Conferimos o usuário, um horário inteiro, um horário que não esteja no futuro
    // e um intervalo de inatividade menor que o limite. Ter apenas um cookie não basta.
    // time() informa o horário atual em segundos desde 01/01/1970 (horário Unix).
    return ($_SESSION['usuario'] ?? null) === LOGIN_USUARIO
        && isset($_SESSION['ultimo_acesso']) && is_int($_SESSION['ultimo_acesso'])
        && $_SESSION['ultimo_acesso'] <= time()
        && time() - $_SESSION['ultimo_acesso'] < LOGIN_TEMPO_INATIVO;
}

// Este trecho roda sempre que uma página inclui este arquivo.
// ! inverte a resposta: !exemploLogado() significa "o login não está válido".
// A aplicação controla sua expiração, independentemente da limpeza automática do PHP.
$exemploSessaoExpirada = isset($_SESSION['usuario']) && !exemploLogado();
if ($exemploSessaoExpirada) {
    // Se havia usuário e o prazo venceu, limpamos os dados e trocamos o identificador.
    session_unset();
    session_regenerate_id(true);
} elseif (exemploLogado()) {
    // Se o login é válido, este acesso reinicia a contagem de inatividade.
    $_SESSION['ultimo_acesso'] = time();
}

// Cada página protegida chama esta função antes de mostrar qualquer conteúdo.
function exemploExigirLogin(): void
{
    // global permite consultar aqui a variável criada fora desta função.
    global $exemploSessaoExpirada;
    if (!exemploLogado()) {
        // ?motivo=... envia uma informação pela URL; login.php a lê em $_GET.
        exemploRedirecionar('login.php?motivo=' . ($exemploSessaoExpirada ? 'expirada' : 'necessario'));
    }
}

// 4. CONFERIR A ORIGEM DOS FORMULÁRIOS QUE ALTERAM DADOS
// O token é um código aleatório guardado na sessão e enviado em um campo escondido.
// Na volta do formulário, comparamos os dois códigos. Isso ajuda a impedir que
// outra página envie ações em nome do visitante; o token não substitui o login.
if (!isset($_SESSION['token']) || !is_string($_SESSION['token'])) {
    // || significa "ou". Criamos o código se estiver faltando ou não for texto.
    // random_bytes gera bytes aleatórios; bin2hex os transforma em texto hexadecimal.
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
function exemploTokenValido(): bool
{
    // hash_equals compara o token guardado com o token recebido por POST.
    return hash_equals($_SESSION['token'], exemploTexto($_POST, 'token'));
}

// 5. MONTAR O HTML COMUM ÀS PÁGINAS
// Esta função abre o documento, mostra o menu e usa $titulo no título da página.
// Ao fechar a tag PHP, podemos escrever HTML; ao abrir a tag novamente, voltamos ao PHP.
function exemploInicio(string $titulo): void
{
    ?>
    <!doctype html>
    <html lang="pt-BR">
    <head>
        <!-- charset define os acentos; viewport adapta a página à largura da tela. -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= exemploEscapar($titulo) ?> — Aula 6</title>
        <style>
            /* CSS cuida da aparência. O ponto seleciona classes usadas no HTML. */
            body { background: #fcfcfd; font: 1rem/1.6 Arial, sans-serif; color: #202124; margin: 2rem auto; max-width: 960px; padding: 0 1rem; }
            h1, code { color: #5b2c6f; }
            a { color: #5b2c6f; }
            nav { display: flex; flex-wrap: wrap; gap: 1rem; }
            .dica { background: #eaf4ff; border-left: 4px solid #2878c8; padding: 1rem; }
            .resultado { background: #f3e5f5; border-left: 4px solid #8e44ad; padding: 1rem; }
            .erro { background: #fff0ee; border-left: 4px solid #c0392b; padding: 1rem; }
            form { background: #fff; border: 1px solid #ddd; padding: 1rem; margin: 1rem 0; }
            label { display: block; margin: .75rem 0; }
            input, button { font: inherit; max-width: 100%; padding: .4rem; box-sizing: border-box; }
            pre { background: #f6f8fa; white-space: pre-wrap; overflow-wrap: anywhere; padding: 1rem; }
        </style>
    </head>
    <body>
        <!-- nav agrupa os links; href informa o endereço que cada link vai abrir. -->
        <nav aria-label="Exemplos da aula 6">
            <a href="index.php#exemplos-arquivos">Voltar à aula 6</a>
            <a href="login.php">Login</a>
            <a href="area-restrita.php">Área restrita</a>
            <a href="perfil.php">Perfil</a>
            <a href="logout.php">Sair</a>
            <a href="formulario.php">Formulários GET e POST</a>
        </nav>
        <!-- A tag PHP com sinal de igual é uma forma curta de escrever echo. -->
        <h1><?= exemploEscapar($titulo) ?></h1>
    <?php
}

function exemploFim(): void
{
    // Fecha as tags abertas em exemploInicio. echo envia texto para a resposta.
    echo '</body></html>';
}

// 6. EXPLICAR ESTE ARQUIVO QUANDO ELE FOR ABERTO DIRETAMENTE
// SCRIPT_FILENAME informa o arquivo solicitado; __FILE__ informa este arquivo.
// realpath resolve o caminho completo. Se forem iguais, mostramos a explicação.
// Quando outra página usa require_once, este trecho não monta uma página extra.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    exemploInicio('Como funciona autenticacao.php');
    ?>
    <p>Este arquivo é incluído com <code>require_once __DIR__ . '/autenticacao.php';</code> antes do HTML das outras páginas. Ele inicia a sessão <code>AULA6LOGIN</code>, verifica a expiração e oferece funções comuns.</p>
    <ol>
        <li><code>exemploLogado()</code> verifica o usuário e a última atividade registrada no servidor.</li>
        <li><code>exemploExigirLogin()</code> redireciona visitantes sem login e encerra o script com <code>exit</code>.</li>
        <li><code>exemploTokenValido()</code> confere o token dos formulários POST.</li>
        <li><code>exemploEscapar()</code> permite mostrar textos recebidos em HTML.</li>
    </ol>
    <p class="dica">A sessão expira após <?= LOGIN_TEMPO_INATIVO ?> segundos de inatividade. Para testar mais rápido, altere <code>LOGIN_TEMPO_INATIVO</code> neste arquivo para <code>10</code>, faça login, aguarde e abra a área restrita.</p>
    <p>Usuário de demonstração: <strong><?= exemploEscapar(LOGIN_USUARIO) ?></strong>. Senha: <strong>php123</strong>. A senha é conferida com <code>password_verify()</code> usando um hash fixo; o exemplo não usa banco de dados.</p>
    <?php
    exemploFim();
}
