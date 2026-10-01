<?php
// LOGIN: recebe o formulário, confere a senha e cria os dados de autenticação.
// strict_types exige os tipos declarados nas funções nas chamadas deste arquivo.
declare(strict_types=1);
// __DIR__ é a pasta deste arquivo. O ponto junta a pasta ao nome do arquivo de apoio.
// require_once carrega esse arquivo uma única vez e disponibiliza suas funções.
// Ele também inicia a sessão; por isso vem antes de qualquer HTML.
require_once __DIR__ . '/autenticacao.php';

// 1. Quem já fez login pode ir direto para a área restrita.
if (exemploLogado()) {
    exemploRedirecionar('area-restrita.php');
}

// 2. Preparar os dados. Texto vazio significa que ainda não há erro para mostrar.
$erro = '';
// A chave 'usuario' corresponde ao atributo name="usuario" do campo no formulário.
// exemploTexto aceita apenas texto e devolve '' se o campo não foi enviado.
$usuario = exemploTexto($_POST, 'usuario');
// Só conferimos a senha quando o formulário chega por POST.
// Ao abrir o link normalmente, a requisição é GET e apenas mostramos o formulário.
// ?? fornece um valor padrão caso REQUEST_METHOD não esteja disponível.
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    // O token recebido deve ser igual ao código que foi guardado na sessão.
    if (!exemploTokenValido()) {
        // 403 informa ao navegador que esta ação foi recusada.
        http_response_code(403);
        $erro = 'Formulário inválido. Atualize a página e tente novamente.';
    } elseif ($usuario === LOGIN_USUARIO && password_verify(exemploTexto($_POST, 'senha'), LOGIN_SENHA_HASH)) {
        // === compara valor e tipo; && exige usuário E senha corretos.
        // password_verify confere a senha digitada usando o hash do arquivo de apoio.
        // 3. Login aceito: trocamos o identificador e descartamos o identificador antigo.
        session_regenerate_id(true);
        // Cada chave abaixo guarda um dado que as outras páginas poderão consultar.
        // A senha não é armazenada na sessão.
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nome'] = 'Aluno da aula 6';
        $_SESSION['ultimo_acesso'] = time(); // Horário usado para controlar a expiração.
        // O formulário do próximo acesso usará um novo código aleatório.
        $_SESSION['token'] = bin2hex(random_bytes(32));
        // Envia o visitante à página protegida e encerra a execução deste arquivo.
        exemploRedirecionar('area-restrita.php');
    } else {
        // O login falhou: guardamos uma mensagem para exibir junto do formulário.
        $erro = 'Usuário ou senha incorretos.';
    }
}

// 4. A partir daqui montamos a página. Cabeçalhos e redirecionamentos já foram tratados.
exemploInicio('Login com $_POST e $_SESSION');
// 'motivo' vem da URL, por exemplo login.php?motivo=expirada. Não concede acesso.
$motivo = exemploTexto($_GET, 'motivo');
?>
<p>Envie as credenciais por POST. Após a validação, o servidor registra o usuário em <code>$_SESSION</code> e redireciona para a área restrita.</p>
<!-- if, elseif e endif escolhem a mensagem que será incluída no HTML da resposta. -->
<?php if ($motivo === 'expirada' || $exemploSessaoExpirada): ?>
    <p class="erro" role="alert">Sua sessão expirou por inatividade. Faça login novamente.</p>
<?php elseif ($motivo === 'necessario'): ?>
    <p class="erro" role="alert">Faça login para visualizar a página solicitada.</p>
<?php elseif ($motivo === 'saiu'): ?>
    <p class="resultado">Você saiu. A sessão anterior foi encerrada.</p>
<?php endif; ?>
<!-- A mensagem só aparece se houver erro. Escapar permite exibir o texto no HTML. -->
<?php if ($erro !== ''): ?>
    <p class="erro" role="alert"><?= exemploEscapar($erro) ?></p>
<?php endif; ?>
<p class="dica">Teste com usuário <strong>aluno</strong> e senha <strong>php123</strong>. Experimente primeiro uma senha incorreta.</p>
<!-- method="post" envia no corpo da requisição; action indica quem recebe os dados. -->
<form method="post" action="login.php">
    <!-- hidden envia o token sem mostrar um campo para digitação. Ele não é uma senha. -->
    <input type="hidden" name="token" value="<?= exemploEscapar($_SESSION['token']) ?>">
    <!-- for liga o rótulo ao id; name vira a chave em $_POST; value preenche o campo. -->
    <label for="usuario">Usuário: <input id="usuario" name="usuario" value="<?= exemploEscapar($usuario) ?>" autocomplete="username" required></label>
    <!-- password oculta a digitação na tela; required pede preenchimento no navegador. -->
    <label for="senha">Senha: <input id="senha" name="senha" type="password" autocomplete="current-password" required></label>
    <button type="submit">Entrar</button>
</form>
<p>Apenas iniciar uma sessão não autentica o visitante. A área restrita exige o usuário validado e uma sessão dentro do prazo.</p>
<?php exemploFim(); // Fecha o documento HTML aberto por exemploInicio(). ?>
