# Aula 6 — Variáveis pré-definidas (superglobais) em PHP

Material baseado no PDF `aula6.pdf`, do Prof. Adriano Kleber Milanez, adaptado para PHP 8.3 e organizado conforme o modelo visual e didático da aula 3.

## Executar com Docker

Pré-requisito: Docker Desktop instalado e em execução, com contêineres Linux habilitados.

No terminal, a partir da raiz do repositório:

```bash
cd "aula 6"
docker compose up -d


docker compose ps
```

Abra [http://localhost:8084](http://localhost:8084). A porta 8084 permite executar esta aula junto das aulas anteriores. O ambiente usa PHP 8.3 FPM e Nginx, com a pasta da aula montada em `/var/www/html`. Salve as alterações em `index.php` e atualize o navegador para ver o resultado.

Para verificar a configuração e consultar os logs:

```bash
docker compose config
docker compose logs app web
```

Para encerrar e remover os contêineres:

```bash
docker compose down
```

## Conteúdo e prática

### Exemplos em arquivos separados

Os links e o roteiro estão no início de `index.php`. Abra [login.php](http://localhost:8084/login.php) com usuário **aluno** e senha **php123**. O exemplo usa uma credencial didática fixa, com hash verificado por `password_verify()`, sem banco de dados.

| Arquivo | Finalidade |
| --- | --- |
| `autenticacao.php` | Apoio comum: inicia `AULA6LOGIN`, valida usuário e inatividade, oferece proteção, tokens e apresentação. Ao abrir diretamente, explica seu funcionamento. |
| `login.php` | Recebe credenciais por POST, regenera o identificador e grava o usuário na sessão. |
| `area-restrita.php` | Exige sessão autenticada antes de enviar qualquer conteúdo. |
| `perfil.php` | Segunda página protegida; altera o nome na mesma sessão e redireciona após POST. |
| `logout.php` | Confirmação de saída; o POST limpa variáveis, destrói a sessão e remove o cookie. |
| `formulario.php` | Formulários públicos GET/POST com destino em outro arquivo. |
| `receber.php` | Valida os campos e compara os três arrays de entrada; responde 422 para dados inválidos. |

Para testar a proteção, abra a área restrita sem login; faça login com senha incorreta e depois com a correta; altere o nome no perfil; volte à área restrita; saia e tente acessar novamente pelo endereço direto. Uma janela anônima também deve exigir login. Os formulários de login, perfil e saída verificam um token armazenado na sessão.

A expiração por inatividade é controlada por `LOGIN_TEMPO_INATIVO` em `autenticacao.php`, inicialmente 900 segundos. Para testar, altere para 10 segundos, faça login, aguarde sem acessar os exemplos e abra uma página protegida. Depois, restaure o valor. A sessão dos blocos da aula (`AULA6SESSID`) não autentica o visitante nas páginas novas (`AULA6LOGIN`).

Para testar GET/POST, abra `formulario.php`, envie cada formulário e compare os arrays e a URL em `receber.php`. Tente um e-mail inválido enviando uma requisição diretamente: o servidor deve rejeitá-lo mesmo sem a validação do navegador. Esses exemplos públicos apenas exibem os dados recebidos.

### Blocos da página principal

| Bloco | Assunto | O que experimentar |
| --- | --- | --- |
| 1 | `$GLOBALS` e escopo | Alterar as bandas e combinar arrays dentro de uma função. |
| 2 | `$_SERVER` | Consultar host, navegador, método, caminhos e outros índices. |
| 3 | `$_GET` | Enviar nome e e-mail e observar a URL. |
| 4 | `$_POST` | Enviar os mesmos campos no corpo da requisição. |
| 5 | `$_REQUEST` | Comparar a mesma chave enviada por GET e POST. |
| 6 | `$_FILES` | Enviar JPEG/GIF com menos de 20.000 bytes e consultar os atributos. |
| 7 | `$_COOKIE` | Salvar/remover uma cor e atualizar a página. |
| 8 | `$_SESSION` | Criar dados, consultar em outra requisição e contar visitas. |
| 9 | Gerenciamento de sessões | Limpar variáveis, destruir dados e remover o cookie da sessão. |

Cada bloco possui explicação, código comentado, botão de cópia, link para o OneCompiler, indicação das linhas para edição e resultado calculado pelo PHP. Os exemplos de console são independentes e usam `echo` com `"\n"`. GET, POST, REQUEST, FILES e COOKIE usam dados simulados nesses exemplos, porque o console não recebe requisições do navegador. Os formulários da página usam as superglobais reais.

O formulário GET substitui a consulta da URL; cada formulário demonstra seu próprio assunto. Nome e e-mail mostram os valores iniciais antes de um envio. Cookies recém-criados ou removidos são observados na requisição seguinte: atualize a página ou abra novamente a URL. O nome `AULA6SESSID` distingue a sessão desta aula das sessões das outras aulas em localhost.

O upload valida o conteúdo com `finfo`, verifica o tamanho e usa `move_uploaded_file()` com nome gerado. Os arquivos ficam em `/tmp/aula6-uploads`, dentro do contêiner PHP e fora da pasta pública. Não são publicados nem versionados e são descartados quando o contêiner é removido. Os limites do PHP também aparecem na página. Para testar, use uma imagem pequena; arquivos de outro tipo e acima do limite devem ser rejeitados.

## Atividade final e atualização do PDF

A página inclui as quatro questões do material (a última repete a terceira) e as respostas comentadas em uma área expansível.

- A primeira questão tem alternativas equivalentes: 180 minutos, 3 horas e 10800 segundos. O texto do PDF não corresponde a um limite universal do PHP. O padrão de `session.gc_maxlifetime` é 1440 segundos para elegibilidade à coleta, e o cookie e a aplicação também influenciam a duração. Confira a [configuração oficial de sessões](https://www.php.net/manual/pt_BR/session.configuration.php).
- As variáveis para receber formulários são `$_GET`, `$_POST` e `$_REQUEST` (alternativa A).
- `session_start()` inicia ou retoma uma sessão (alternativa A nas questões 3 e 4).

As adaptações também esclarecem que POST não criptografa dados, REQUEST não inclui SESSION, `Secure` e `HttpOnly` são opções diferentes, e as funções antigas `session_register()`, `session_unregister()` e `session_is_registered()` foram removidas. Consulte [$_REQUEST](https://www.php.net/manual/pt_BR/reserved.variables.request.php), [cookies](https://www.php.net/manual/pt_BR/function.setcookie.php) e [upload](https://www.php.net/manual/pt_BR/features.file-upload.php) no manual oficial.

## Exercícios

1. Acrescente uma banda em cada array e explique o uso de `$GLOBALS`.
2. Compare GET e POST enviando os mesmos campos.
3. Explique qual banda aparece em REQUEST considerando a configuração exibida.
4. Teste um upload válido, um formato não permitido e um arquivo acima do limite.
5. Salve uma cor por dez minutos e confirme o cookie na próxima requisição.
6. Crie uma sessão, consulte-a novamente e encerre seus dados.
