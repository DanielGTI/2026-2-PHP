<?php
// LOGOUT: encerra o acesso do usuário quando ele confirma a saída pelo formulário.
declare(strict_types=1);
// Carrega as funções e recupera a sessão existente antes de qualquer HTML.
require_once __DIR__ . '/autenticacao.php';
// Para sair desta conta, primeiro é preciso estar autenticado.
exemploExigirLogin();
$erro = '';
// Abrir o link faz um GET e só mostra a confirmação. A saída acontece no POST.
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!exemploTokenValido()) {
        // O código recebido precisa corresponder ao token da sessão atual.
        http_response_code(403);
        $erro = 'Formulário inválido. Atualize a página e confirme novamente.';
    } else {
        // 1. Remove as variáveis de $_SESSION nesta execução.
        session_unset();
        // 2. Destrói os dados da sessão que estavam armazenados no servidor.
        session_destroy();
        // 3. Consulta as opções para remover o mesmo cookie criado no login.
        $cookie = session_get_cookie_params();
        // setcookie envia um cabeçalho HTTP. Ele precisa vir antes do HTML.
        // O nome é o mesmo da sessão; o valor vazio e a data passada removem o cookie.
        setcookie(session_name(), '', [
            'expires' => time() - 3600, // Uma hora atrás: o cookie já está vencido.
            'path' => $cookie['path'], // Mantém o caminho do cookie original.
            'domain' => $cookie['domain'], // Mantém o domínio do cookie original.
            'secure' => $cookie['secure'], // Mantém a regra de envio por HTTPS.
            'httponly' => $cookie['httponly'], // Mantém a proteção contra leitura por JavaScript.
            'samesite' => $cookie['samesite'], // Mantém a regra para acessos de outros sites.
        ]);
        // Volta ao login com um aviso na URL. A função também encerra este arquivo.
        exemploRedirecionar('login.php?motivo=saiu');
    }
}
// Se o POST não aconteceu ou foi recusado, mostramos a confirmação abaixo.
exemploInicio('Logout — encerrar a sessão');
?>
<p>Confirme a saída para limpar <code>$_SESSION</code>, destruir os dados no servidor e remover o cookie <code>AULA6LOGIN</code>. Apenas abrir este link não encerra a sessão: a ação exige POST.</p>
<?php if ($erro !== ''): ?><p class="erro" role="alert"><?= exemploEscapar($erro) ?></p><?php endif; ?>
<!-- O botão envia para este arquivo; o trecho PHP acima confere o token e sai. -->
<form method="post" action="logout.php">
    <!-- O navegador envia este código junto com a confirmação da saída. -->
    <input type="hidden" name="token" value="<?= exemploEscapar($_SESSION['token']) ?>">
    <button type="submit">Confirmar saída</button>
</form>
<p>Depois de sair, tente acessar <a href="area-restrita.php">a área restrita</a> ou <a href="perfil.php">o perfil</a> diretamente.</p>
<?php exemploFim(); // Fecha as tags do documento HTML. ?>
