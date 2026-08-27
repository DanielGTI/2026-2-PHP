# 🚀 Ambiente de Desenvolvimento PHP + Nginx com Docker

Seja bem-vindo(a)! Este repositório fornece uma estrutura simples, pronta e moderna para rodar aplicações **PHP 8.3** com o servidor web **Nginx** utilizando **Docker** e **Docker Compose**.

Ele foi projetado para ser didático, rápido de configurar e sem complicações de ambiente na sua máquina local.

---

## 📋 Pré-requisitos

Antes de começar, certifique-se de que você possui o **Docker Desktop** instalado e em execução na sua máquina.

* [Download do Docker Desktop](https://www.docker.com/products/docker-desktop/)
* Teste se o Docker está rodando no seu terminal:
  ```bash
  docker --version
  docker compose version
  ```

---

## 📁 Estrutura do Projeto

Dentro da pasta `modelo/`, você encontrará os arquivos necessários para subir o ambiente:

```text
.
└── modelo/
    ├── docker-compose.yml   # Configuração e orquestração dos contêineres
    ├── default.conf         # Configuração de roteamento do Nginx
    └── index.php            # Arquivo principal PHP de teste
```

---

## 🛠️ Passo a Passo: Como Iniciar

### 1️⃣ Clonar o repositório
Abra o seu terminal e clone o projeto (ou faça o download dos arquivos):

```bash
git clone <URL_DO_SEU_REPOSITORIO>
cd <NOME_DA_PASTA_DO_PROJETO>
```

### 2️⃣ Entrar na pasta `modelo`
Entre no diretório onde os arquivos de configuração estão localizados:

```bash
cd modelo
```

### 3️⃣ Subir os contêineres Docker
Execute o comando abaixo para baixar as imagens necessárias e iniciar o servidor em segundo plano (`-d`):

```bash
docker compose up -d
```

> 💡 **O que acontece ao rodar esse comando?**
> - O Docker baixa a imagem leve do **PHP 8.3 FPM** e do **Nginx Alpine**.
> - Inicia dois contêineres conectados entre si em uma rede isolada.
> - Mapeia a porta `8080` do seu computador para o Nginx.

### 4️⃣ Testar no Navegador
Abra o seu navegador e acesse:

👉 [http://localhost:8080](http://localhost:8080)

Se tudo estiver correto, você verá a tela oficial de informações do **PHP (`phpinfo()`)**.

---

## 💡 Como os Arquivos Funcionam?

* **`docker-compose.yml`**: É o "maestro" do ambiente. Ele define dois serviços:
  * `app`: O motor do PHP executando a versão `8.3-fpm`.
  * `web`: O servidor Nginx escutando na porta `8080` do seu computador.
* **`default.conf`**: Ensina o Nginx a enviar qualquer requisição que termine em `.php` para o contêiner do PHP (`app:9000`).
* **`index.php`**: O código do seu sistema. Qualquer alteração feita neste arquivo será refletida imediatamente no seu navegador!

---

## 🎮 Comandos Úteis do Dia a Dia

Todos os comandos devem ser executados dentro da pasta `modelo`:

| Ação | Comando |
| :--- | :--- |
| **Subir o ambiente** | `docker compose up -d` |
| **Parar o ambiente** | `docker compose down` |
| **Verificar o status dos contêineres** | `docker compose ps` |
| **Acompanhar os logs em tempo real** | `docker compose logs -f` |
| **Reiniciar os serviços** | `docker compose restart` |

---

## 📝 Desenvolvendo seu Projeto

Para começar a desenvolver seu sistema PHP:
1. Edite ou substitua o arquivo `index.php` na pasta `modelo`.
2. Adicione novos arquivos PHP e assets (HTML, CSS, JS) na mesma pasta.
3. Atualize a página no navegador (`http://localhost:8080`) para ver as mudanças na hora, sem precisar reiniciar o Docker!

---

✨ *Pronto para codar! Se tiver dúvidas ou sugestões, sinta-se à vontade para abrir uma issue ou PR.*
