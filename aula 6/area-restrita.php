<?php
// PÁGINA PROTEGIDA: somente visitantes com login válido podem ler seu conteúdo.
declare(strict_types=1);
// Carrega as funções e recupera a sessão usando o cookie do visitante.
// __DIR__ aponta para esta pasta; require_once evita carregar o apoio duas vezes.
require_once __DIR__ . '/autenticacao.php';
// A proteção vem antes do HTML, mesmo quando o visitante digita a URL diretamente.
// Sem login, a função envia para login.php e usa exit para encerrar o PHP.
exemploExigirLogin();
// Só chegamos aqui se o login foi aceito e a sessão ainda está dentro do prazo.
exemploInicio('Área restrita — acesso autorizado');
?>
<!-- class escolhe a aparência definida pelo CSS do arquivo de apoio. -->
<div class="resultado">
    <p><strong>Conteúdo exclusivo da turma autenticada.</strong></p>
    <!-- Lemos o nome e o usuário da sessão e escapamos os textos antes de exibir. -->
    <p>Bem-vindo, <?= exemploEscapar(exemploTexto($_SESSION, 'nome')) ?>! Usuário: <?= exemploEscapar(exemploTexto($_SESSION, 'usuario')) ?>.</p>
</div>
<p>Esta página não envia seu conteúdo para visitantes sem login. O acesso direto pela URL também passa por <code>exemploExigirLogin()</code>, que redireciona para <code>login.php</code> e encerra a execução.</p>
<p>Abra <a href="perfil.php">perfil.php</a> para ler e alterar um dado na mesma sessão. Depois, use <a href="logout.php">logout.php</a> e tente abrir esta página novamente. Em uma janela anônima, o acesso também exigirá login.</p>
<p class="dica">O acesso renova a última atividade. Após <?= LOGIN_TEMPO_INATIVO ?> segundos sem acessar os exemplos de login, a sessão deixa de permitir acesso.</p>
<!-- Este formulário envia a ação de saída para outro arquivo: logout.php. -->
<form method="post" action="logout.php">
    <!-- O token liga este envio à sessão que abriu a página. -->
    <input type="hidden" name="token" value="<?= exemploEscapar($_SESSION['token']) ?>">
    <button type="submit">Encerrar sessão e sair</button>
</form>
<?php exemploFim(); // Fecha o HTML que a função exemploInicio abriu. ?>
