<?php
/**
 * Arquivo: exemplo.php
 * Disciplina: Programação Web / Linguagens de Programação
 * Conteúdo: Sintaxe básica, delimitadores, instruções de saída, comentários,
 *            concatenação, tipos primitivos, escopo de variáveis, variáveis
 *            dinâmicas, superglobais e constantes.
 */

// ============================================================================
// BLOCO 1: SINTAXE BÁSICA E DELIMITADORES PHP
// Finalidade: Demonstrar a abertura/fechamento do PHP e a integração com HTML.
// Explicação:
//  - O interpretador PHP varre o arquivo até encontrar o delimitador '<?php' e
//    executa todo o código até a tag ? >.
//  - Todo o texto fora dessas tags é repassado diretamente ao navegador.
//  - O uso do ponto e vírgula (;) é obrigatório ao final de cada instrução.
//  - O PHP é 'case-sensitive' em nomes de variáveis (diferencia maiúsculas e minúsculas).
// ============================================================================

echo "<br><strong>Bloco 1 (SINTAXE BÁSICA E DELIMITADORES PHP)</strong><br>";
echo "Olá mundo!<br/>";


// ============================================================================
// BLOCO 2: INSTRUÇÕES DE SAÍDA (ECHO vs PRINT)
// Finalidade: Exibir dados no navegador e demonstrar a diferença entre echo e print.
// Explicação:
//  - echo: Instrução nativa do PHP utilizada para imprimir textos, HTML e variáveis.
//          Não possui valor de retorno.
//  - print: Função/instrução de exibição que sempre retorna o valor inteiro 1.
//  - Por não ter valor de retorno, o 'echo' é ligeiramente mais rápido que o 'print'.
// ============================================================================

echo "<br><strong>Bloco 2 (INSTRUÇÕES DE SAÍDA - ECHO vs PRINT)</strong><br>";
echo("Prefiro o calor do que frio<br/>");
echo "Prefiro o calor do que frio<br/>";

print("Prefiro o calor do que frio<br/>");
$clima2 = "calor";
print "Prefiro o calor do que $clima2<br/>";


// ============================================================================
// BLOCO 3: SINTAXE DE COMENTÁRIOS
// Finalidade: Demonstrar as três formas válidas de documentação de código no PHP.
// Explicação:
//  - Single-line (linha única): Pode ser feito com '//' ou '#'.
//  - Multi-line (múltiplas linhas): Delimitado por '/* ... */'.
// ============================================================================

echo "<br><strong>Bloco 3 (SINTAXE DE COMENTÁRIOS)</strong><br>";

// 1ª forma: Comentário de uma única linha com barras duplas
# 2ª forma: Comentário de uma única linha com hashtag
/* 
   3ª forma: Comentário de duas ou mais linhas.
   Muito utilizado para documentar funções, classes e blocos complexos.
*/


// ============================================================================
// BLOCO 4: CONCATENAÇÃO EM PHP
// Finalidade: Unir strings e variáveis de diferentes tipos de dados.
// Explicação:
//  - 1ª Forma: Utilização do operador ponto (.). Unir valores e variáveis.
//  - 2ª Forma: Atribuição acumulativa com o operador (x .= y), onde a variável à
//              esquerda recebe o valor atual concatenado ao valor da direita.
// ============================================================================

echo "<br><strong>Bloco 4 (CONCATENAÇÃO EM PHP)</strong><br>";

// 1ª Forma (operador ponto .)
$dia = 14;
$mes = "abril";
$ano = 1912;
$anocompleto = $dia . " de " . $mes . " de " . $ano;
echo $anocompleto . "<br/>";

// 2ª Forma (operador .=)
$anocompleto2 = 14;
$anocompleto2 .= " de abril de ";
$anocompleto2 .= 1912;
echo $anocompleto2 . "<br/>";


// ============================================================================
// BLOCO 5: VARIÁVEIS E OS 8 TIPOS PRIMITIVOS DE DADOS
// Finalidade: Ilustrar como declarar variáveis e apresentar a tipagem fraca do PHP.
// Explicação:
//  - Variáveis iniciam obrigatoriamente com '$' seguido de letra ou underscore (_).
//  - Não exigem declaração explícita de tipo (linguagem fracamente tipada).
//  - O PHP aloca e determina o tipo automaticamente com base no valor atribuído.
// ============================================================================

echo "<br><strong>Bloco 5 (VARIÁVEIS E OS 8 TIPOS PRIMITIVOS DE DADOS)</strong><br>";

// --- TIPOS ESCALARES (4) ---

// 1. Boolean (verdadeiro ou falso: true/false ou 1/0)
$_varBool = true;

// 2. Integer (números inteiros pertencentes ao conjunto Z)
$a_dec = 1234;   // Notação Decimal
$a_neg = -123;   // Número Negativo
$a_oct = 0123;   // Notação Octal (equivalente a 83 em decimal)
$a_hex = 0x1A;   // Notação Hexadecimal (equivalente a 26 em decimal)

// 3. Float / Double (ponto flutuante / números reais)
$f1 = 1.234;
$f2 = 1.2e3;     // Notação científica (1200)
$f3 = 7E-10;

// 4. String (sequência de caracteres; limite depende apenas da memória do servidor)
$_varString = "Hello world!!";

// --- TIPOS COMPOSTOS (2) ---

// 5. Array (mapa ordenado que relaciona chaves a valores)
$arr = array("foo" => "bar", 12 => true);
echo "Valor do chave 'foo': " . $arr["foo"] . "<br/>";
echo "Valor da chave 12: " . ($arr[12] ? "true" : "false") . "<br/>";

// 6. Object (instância de uma classe, criada utilizando a instrução 'new')
class Teste {
    function hello() {
        echo "Hello World vindo de um Objeto!!<br/>";
    }
}
$objeto = new Teste;
$objeto->hello();

// --- TIPOS ESPECIAIS (2) ---

// 7. Resource (referência a um recurso externo, como conexões de banco de dados ou arquivos)
// 8. NULL (representa uma variável sem valor atribuído; a palavra-chave é case-insensitive)
$varNula = NULL;


// ============================================================================
// BLOCO 6: ESCOPO DE VARIÁVEIS (LOCAL, GLOBAL, ESTÁTICA E DINÂMICA)
// Finalidade: Explicar a visibilidade e o ciclo de vida das variáveis.
// Explicação:
//  - Local: Existência restrita ao bloco/função onde foi criada. Destruída ao encerrar a função.
//  - Global: Acessível em todo o script. Dentro de funções, deve ser declarada com a palavra 'global'.
//  - Estática (static): Variável local que preserva seu valor entre chamadas sucessivas da função.
//  - Dinâmica ($$): Variável cujo nome é definido pelo conteúdo de outra variável.
// ============================================================================

echo "<br><strong>Bloco 6 (ESCOPO DE VARIÁVEIS - LOCAL, GLOBAL, ESTÁTICA E DINÂMICA)</strong><br>";

// Variável Local (gera erro 'Notice: Undefined variable' se acessada fora do escopo)
function quadradoLocal() {
    $numeroLocal = 3;
    $numeroLocal = $numeroLocal * $numeroLocal;
}
quadradoLocal();
// echo $numeroLocal; // Descomentar esta linha gerará um Notice de variável não definida

// Variável Global
$numeroGlobal = 3;
function quadradoGlobal() {
    global $numeroGlobal; // Importa a variável do escopo global para o escopo local
    $numeroGlobal = $numeroGlobal * $numeroGlobal;
}
quadradoGlobal();
echo "O número ao quadrado (Escopo Global) é: $numeroGlobal <br/>";

// Variável Estática (Static)
function somatorio() {
    static $soma = 0; // Inicializada apenas na primeira execução e preservada nas demais
    $soma = $soma + 1;
    echo "Valor da variável estática \$soma: $soma <br/>";
}
somatorio(); // Imprime 1
somatorio(); // Imprime 2
somatorio(); // Imprime 3

// Variável Dinâmica (Variáveis Variáveis - $$)
$var = "Curso";
$$var = "Tecnologia em Análise e Desenvolvimento de Sistemas";
// A instrução acima criou a variável $Curso com o valor "Tecnologia em Análise..."
echo "Conteúdo da variável \$var: $var <br/>";
echo "Conteúdo da variável dinâmica criada (\$Curso): $Curso <br/>";


// ============================================================================
// BLOCO 7: VARIÁVEIS SUPERGLOBAIS (PRÉ-DEFINIDAS)
// Finalidade: Apresentar as variáveis globais nativas do ambiente PHP.
// Explicação: Estão sempre disponíveis em qualquer parte do script sem declaração prévia.
//  - $_SERVER: Informações sobre o ambiente do servidor web e execução do script.
//  - $_GET: Parâmetros passados via URL/formulário (método GET).
//  - $_POST: Dados enviados por formulários (método POST).
//  - $_COOKIE: Dados armazenados nos cookies HTTP do cliente.
//  - $_FILES: Arquivos enviados via upload POST.
//  - $_ENV: Variáveis do ambiente do servidor.
//  - $_REQUEST: Agrupa o conteúdo de $_GET, $_POST e $_COOKIE.
//  - $_SESSION: Variáveis gravadas na sessão do usuário.
//  - $GLOBALS: Array associativo com todas as variáveis do escopo global.
// ============================================================================

echo "<br><strong>Bloco 7 (VARIÁVEIS SUPERGLOBAIS - PRÉ-DEFINIDAS)</strong><br>";
echo "Arquivo em execução (\$_SERVER['PHP_SELF']): " . $_SERVER['PHP_SELF'] . "<br/>";


// ============================================================================
// BLOCO 8: CONSTANTES
// Finalidade: Demonstrar a criação de identificadores com valores imutáveis.
// Explicação:
//  - São declaradas obrigatoriamente através da função define().
//  - Convenção: Nomes sempre em letras MAIÚSCULAS.
//  - Não possuem o prefixo cifrão ($).
//  - Possuem escopo global automático (acessíveis em qualquer lugar sem passar 'global').
//  - Não podem ser redefinidas nem eliminadas após a criação.
//  - Aceitam apenas valores escalares (boolean, integer, float, string).
// ============================================================================

echo "<br><strong>Bloco 8 (CONSTANTES)</strong><br>";
define("CONSTANT", "Hello world!");
echo "Valor da constante CONSTANT: " . CONSTANT . "<br/>";

?>
