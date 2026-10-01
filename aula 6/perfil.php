<?php
// PERFIL: demonstra como outra página consulta e altera a mesma sessão do login.
declare(strict_types=1);
// O arquivo de apoio inicia a sessão e define as funções usadas abaixo.
require_once __DIR__ . '/autenticacao.php';
// Impede acessar ou alterar o perfil sem um login válido. Vem antes do HTML.
exemploExigirLogin();
// Texto vazio indica que ainda não existe mensagem de erro.
$erro = '';
// GET apenas exibe o perfil. POST indica que o visitante enviou o formulário.
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    // 'nome' é a chave definida por name="nome" no campo HTML.
    // trim remove espaços no começo e no fim do texto digitado.
    $nome = trim(exemploTexto($_POST, 'nome'));
    if (!exemploTokenValido()) {
        // Recusa um envio que não tenha o mesmo token guardado na sessão.
        http_response_code(403);
        $erro = 'Formulário inválido. Atualize a página.';
    } elseif ($nome === '' || strlen($nome) > 100) {
        // || significa "ou": recusamos nome vazio OU maior que o limite.
        // strlen conta bytes; caracteres com acento podem ocupar mais de um byte.
        $erro = 'Informe um nome com até 100 bytes.';
    } else {
        // Atribui o novo nome à sessão: area-restrita.php verá esse mesmo valor.
        $_SESSION['nome'] = $nome;
        // Depois de salvar, abrimos o perfil com GET. Assim, atualizar não repete o POST.
        // salvo=1 é só um aviso pela URL; não altera o nome nem autentica ninguém.
        exemploRedirecionar('perfil.php?salvo=1');
    }
}
// As verificações terminaram; agora podemos escrever o HTML da página.
exemploInicio('Perfil — mesma sessão em outra página');
?>
<p>Esta segunda página protegida lê o mesmo usuário de <code>$_SESSION</code>. O nome salvo aqui aparecerá também na área restrita, sem enviá-lo pela URL.</p>
<!-- As funções leem a sessão e convertem os valores para texto seguro no HTML. -->
<p class="resultado">Usuário: <?= exemploEscapar(exemploTexto($_SESSION, 'usuario')) ?>. Nome atual: <?= exemploEscapar(exemploTexto($_SESSION, 'nome')) ?>.</p>
<!-- Estes if mostram mensagens somente quando houver erro ou aviso de salvamento. -->
<?php if ($erro !== ''): ?><p class="erro" role="alert"><?= exemploEscapar($erro) ?></p><?php endif; ?>
<?php if (exemploTexto($_GET, 'salvo') === '1'): ?><p>Nome atualizado na sessão.</p><?php endif; ?>
<!-- O formulário volta para este arquivo: a parte PHP no início trata o POST. -->
<form method="post" action="perfil.php">
    <!-- hidden envia o código de conferência sem criar um campo visível. -->
    <input type="hidden" name="token" value="<?= exemploEscapar($_SESSION['token']) ?>">
    <!-- for/id ligam o rótulo ao campo. name define a chave; value mostra o nome atual. -->
    <!-- maxlength/required ajudam no navegador; o PHP também valida os dados recebidos. -->
    <label for="nome">Nome: <input id="nome" name="nome" maxlength="100" value="<?= exemploEscapar(exemploTexto($_SESSION, 'nome')) ?>" required></label>
    <button type="submit">Salvar na sessão</button>
</form>
<p><a href="area-restrita.php">Voltar à área restrita e conferir o nome</a>. O nome está armazenado apenas na sessão; será descartado ao sair.</p>
<?php exemploFim(); // Fecha o documento da página. ?>
