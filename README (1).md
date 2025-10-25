# FireHouse

🔥 Conceito do Site FireHouse

O FireHouse é um sistema web de gerenciamento de eventos que conecta organizadores e colaboradores/prestadores de serviço de forma prática e centralizada.
Seu principal objetivo é facilitar a criação, administração e execução de eventos, oferecendo ferramentas para cadastro, acompanhamento e vinculação de serviços necessários para cada ocasião.

⚙️ Mecânicas principais

Cadastro e autenticação de usuários: permite que organizadores e colaboradores criem contas e acessem suas respectivas áreas.

Criação e edição de eventos: o organizador cadastra detalhes como título, data, local e tipo de evento.

Seleção e vinculação de serviços: o organizador escolhe serviços (como buffet, som, decoração, segurança etc.) e pode vinculá-los diretamente a colaboradores por meio de um código único.

Atualização de status: cada evento pode estar nos estados Aberto, Em andamento ou Finalizado, permitindo o acompanhamento do progresso.

Feedback e avaliação: após o evento, os organizadores podem avaliar os colaboradores, criando um ciclo de confiança entre os usuários.

🎯 Propósito geral

O FireHouse busca automatizar e profissionalizar o processo de organização de eventos, tornando-o mais eficiente, transparente e colaborativo.
A ideia central é reunir, em uma única plataforma, todos os aspectos do evento — desde o planejamento até a avaliação final —, promovendo comunicação direta, controle e confiabilidade entre as partes envolvidas.

---

## Integrantes
- Anthony Marcelo Mendoza de Melo – 22301631  
- Daniel Ramos Nadalin Vaz da Costa – 22301739  
- João Pedro de Freitas Carvalho – 22300953  
- Gabriel Cédric Damázio Carvalho – 22301640  
- Pedro do Nascimento Scarabelli – 12300187  

---

## Estrutura de Diretórios
```
firehouse-php/
├── app/              # Lógica principal do sistema (controladores, modelos, etc.)
├── auth/             # Autenticação de usuários (login, registro, sessão)
├── config/           # Configurações do sistema e banco de dados
├── eventos/          # Funcionalidades relacionadas a eventos
├── MySQL/            # Scripts de banco de dados (separados por contexto)
├── public/           # Arquivos acessíveis publicamente (index.php, assets, CSS, JS)
├── sql/              # Arquivos .sql para criação/importação do banco de dados
├── views/            # Views do sistema (HTML + PHP)
├── bootstrap.php     # Inicialização do projeto
└── README.md         # Documentação do projeto
```

---

## Como Executar o Projeto

### 1. Pré-requisitos
- **XAMPP** (Apache + MySQL)  
- **PHP 8+** (incluso no XAMPP)  
- **Git** para clonar o repositório  
- **VS Code** (opcional, recomendado)  

### 2. Instalação
Abra o terminal e rode:  

```bash
# Vá até a pasta do XAMPP
cd C:\xampp\htdocs

# Clone o repositório
git clone https://github.com/AnthonyMelo22301631/firehouse-php.git

# Acesse a pasta do projeto
cd firehouse-php
```

### 3. Banco de Dados
1. Abra o **phpMyAdmin**: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)  
2. Crie um banco de dados chamado `firehouse`  
3. Importe o arquivo SQL que está na pasta `sql/` do projeto  

### 4. Execução
1. Inicie o **Apache** e o **MySQL** no XAMPP.  
2. Abra o navegador e acesse:  
   [http://localhost/firehouse-php/public](http://localhost/firehouse-php/public)  

---

## Observações
- O usuário e senha do banco devem ser configurados no arquivo `config/config.php` (ou equivalente).  
- Usuário padrão (se configurado): `admin`  
- Senha padrão (se configurada): `admin123`  
