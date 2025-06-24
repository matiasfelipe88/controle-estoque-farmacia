# Sistema de Estoque - Farmácia

Um sistema simples para gerenciar o estoque de uma farmácia. Feito com PHP e MySQL.

## O que o sistema faz

- **Produtos**: Cadastrar, editar e controlar produtos
- **Categorias**: Organizar produtos por tipo
- **Fornecedores**: Guardar informações dos fornecedores
- **Usuários**: Controle de quem pode acessar o sistema
- **Movimentações**: Registrar entradas e saídas de produtos

## Como instalar

### 1. Baixar o projeto
- Coloque a pasta `estoque-farmacia` dentro de `C:\xampp\htdocs\`

### 2. Configurar o banco de dados
- Abra o XAMPP e inicie Apache e MySQL
- Acesse: http://localhost/phpmyadmin
- Crie um banco chamado `farmacia_estoque`
- Importe o arquivo `banco.sql`

### 3. Configurar a conexão
- Abra o arquivo `config/database.php`
- Verifique se as informações estão corretas:
  ```php
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'farmacia_estoque');
  define('DB_USER', 'root');
  define('DB_PASS', 'root');
  ```

### 4. Adicionar as imagens
- Coloque `LOGO_farmacia.png` na pasta `assets/`
- Coloque `LOGO_farmacia.ico` na pasta `assets/`

## Como usar

### Primeiro acesso
- Acesse: http://localhost/estoque-farmacia/
- **Email**: admin@farmacia.com
- **Senha**: admin

### Criar novos usuários
- Acesse: http://localhost/estoque-farmacia/config/CriarUsuario.php
- Preencha os dados e clique em "Criar Usuário"

### Usar o sistema
1. **Criar categorias** (ex: Medicamentos, Cosméticos)
2. **Cadastrar fornecedores** (nome, email, telefone)
3. **Adicionar produtos** (nome, preço, quantidade)
4. **Registrar movimentações** (entradas e saídas)

## Estrutura das pastas

```
estoque-farmacia/
├── app/                    # Código principal
│   ├── controllers/        # Controladores
│   ├── models/            # Modelos
│   └── views/             # Páginas
├── assets/                # Imagens e CSS
├── config/                # Configurações
├── public/                # Arquivo principal
├── banco.sql             # Script do banco
└── README.md             # Este arquivo
```

## Problemas comuns

### Página não carrega
- Verifique se o XAMPP está rodando
- Confirme se a pasta está em `htdocs`

### Erro de banco de dados
- Verifique se o MySQL está ativo
- Confirme se o banco `farmacia_estoque` existe
- Teste a conexão em: http://localhost/estoque-farmacia/public/test_db.php

### Não consegue adicionar categorias/fornecedores
- Execute no MySQL:
  ```sql
  ALTER TABLE categorias ADD COLUMN descricao TEXT AFTER nome;
  ALTER TABLE fornecedores ADD COLUMN endereco TEXT AFTER email;
  ```

## Tecnologias usadas

- **PHP**: Linguagem do servidor
- **MySQL**: Banco de dados
- **Bootstrap**: Estilo das páginas
- **HTML/CSS**: Estrutura e aparência

## Segurança

- Senhas são criptografadas
- Controle de sessão
- Validação de dados
- Proteção contra SQL Injection

## Personalizar

### Mudar o logo
- Substitua `assets/LOGO_farmacia.png` pelo seu logo
- Substitua `assets/LOGO_farmacia.ico` pelo seu ícone

### Mudar cores
- Edite os arquivos CSS nas pastas `assets/` e `app/views/`

## Dúvidas?

Se algo não funcionar:
1. Verifique se o XAMPP está rodando
2. Confirme se o banco foi criado
3. Teste a conexão com o banco
4. Verifique os logs de erro

---

**Sistema desenvolvido para facilitar o controle de estoque de farmácias** 
