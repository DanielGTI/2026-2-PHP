<?php
// FORMULÁRIO PÚBLICO: mostra duas formas de enviar dados para receber.php.
declare(strict_types=1);
// Carrega as funções de apresentação. Não chamamos exemploExigirLogin aqui,
// pois o aluno pode testar estes formulários mesmo sem estar autenticado.
require_once __DIR__ . '/autenticacao.php';
exemploInicio('Formulários — enviar para outro arquivo PHP');
?>
<p>Os dois formulários enviam os mesmos campos para <code>receber.php</code>. O atributo <code>action</code> escolhe a página de destino; <code>method</code> determina como os dados serão enviados; <code>name</code> define as chaves dos arrays.</p>
<p class="dica">Este exemplo é público: não exige login. Compare a URL e os arrays na página de resultado. Use dados fictícios.</p>
<?php
// O array tem dois pares chave => valor. foreach repete o HTML para cada par.
// Na primeira volta: $metodo = 'get' e $rotulo = 'GET'; na segunda: 'post' e 'POST'.
// $metodo configura o envio; $rotulo é o texto mostrado para o aluno.
foreach (['get' => 'GET', 'post' => 'POST'] as $metodo => $rotulo): ?>
    <h2>Enviar por <?= $rotulo ?></h2>
    <!-- method recebe get ou post; action indica o arquivo PHP que receberá o envio. -->
    <form method="<?= $metodo ?>" action="receber.php">
        <!-- name="nome" cria a chave 'nome' em $_GET ou $_POST. -->
        <!-- for/id ligam o rótulo ao campo; os ids get-nome/post-nome são diferentes. -->
        <label for="<?= $metodo ?>-nome">Nome: <input id="<?= $metodo ?>-nome" name="nome" value="Ana" maxlength="100" required></label>
        <!-- type="email" e required ajudam a validar no navegador. -->
        <!-- value preenche um valor inicial; receber.php fará a validação no servidor. -->
        <label for="<?= $metodo ?>-email">E-mail: <input id="<?= $metodo ?>-email" name="email" type="email" value="ana@example.com" required></label>
        <button type="submit">Enviar por <?= $rotulo ?></button>
    </form>
<?php endforeach; // Encerra a repetição iniciada no foreach. ?>
<p>POST usa o corpo da requisição e não aparece na URL; HTTPS é necessário para proteger o transporte dos dados.</p>
<?php exemploFim(); // Fecha o documento HTML aberto no início. ?>
