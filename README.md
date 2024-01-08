# Hey Professor

Hey Professor é uma plataforma desenvolvida com Laravel que permite que os alunos enviem perguntas aos professores de forma organizada e segura.

## Funcionalidades

- **Envio de Perguntas:** Os alunos podem enviar perguntas aos professores através da plataforma.
- **Gerenciamento de Perguntas:** Os professores têm a capacidade de visualizar, responder e gerenciar as perguntas recebidas.
- **Votação de Perguntas:** Os usuários podem votar nas perguntas existentes para indicar interesse ou relevância.
- **Login com GitHub:** Os usuários podem autenticar-se na plataforma usando suas contas do GitHub.
- **Testes com Pest:** Testes foram implementados utilizando Pest para garantir a robustez do código.
- **Proteção de Rotas e Permissões:** As rotas foram protegidas e implementadas com controle de acesso para garantir a segurança dos dados.
- **Integração Contínua (CI):** O projeto inclui CI para construção e teste automatizados.

## Configuração

1. **Requisitos:**
   - PHP (versão X.X.X)
   - Composer
   - Banco de Dados (MySQL, PostgreSQL, etc.)

2. **Instalação:**

```bash
  git clone https://github.com/gabrielfpereira/hey-professor.git
  cd hey-professor
  composer install
  cp .env.example .env
  php artisan key:generate
```

2.1 **Instalação com Docker:**

```bash
  docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

## Configure o arquivo .env com as credenciais do banco de dados e do GitHub OAuth ##


3. **Testes:**

```bash
  php artisan test
  ou
  sail artisan test
```


## Integração Contínua

Este projeto inclui Integração Contínua (CI) para testes e construção automatizados. A CI ajuda a manter a qualidade do código e garante que novas mudanças não quebrem funcionalidades existentes.

## Contribuição

Contribuições são bem-vindas! Se deseja contribuir para o projeto, siga estas etapas:

1. Faça fork do projeto
2. Crie sua branch de feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Faça push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um pull request

## Creditos
Este projeto faz parte do curso da plataforma -[Pinguim Academy](https://pinguim.academy)

## Licença

Este projeto é licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para mais detalhes.
