# FireHouse

## Descrição
O **FireHouse** é um sistema web desenvolvido em PHP para organização e gerenciamento de eventos.  
O projeto utiliza arquitetura simples em PHP com integração ao MySQL, sendo executado no ambiente **XAMPP**.  

Principais funcionalidades:
- Cadastro e autenticação de usuários  
- Criação e listagem de eventos  
- Área pública e área autenticada  
- Comentários em eventos  

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
