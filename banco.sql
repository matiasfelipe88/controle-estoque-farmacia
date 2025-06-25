<<<<<<< HEAD
CREATE DATABASE IF NOT EXISTS farmacia_estoque DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE farmacia_estoque;

=======
-- Usando sua excelente sugestão para criar o banco de dados de forma robusta
CREATE DATABASE IF NOT EXISTS farmacia_estoque DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE farmacia_estoque;

-- Tabela de Usuários com armazenamento de senha SEGURO
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
<<<<<<< HEAD
=======
    -- VARCHAR(255) para ser compatível com bcrypt (password_hash())
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

<<<<<<< HEAD
=======
-- Tabela Normalizada para Categorias (boa prática)
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao TEXT
);

<<<<<<< HEAD
=======
-- Tabela Normalizada para Fornecedores (boa prática)
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
CREATE TABLE fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco TEXT
);

<<<<<<< HEAD
=======
-- Tabela de Produtos completa, com sua sugestão de 'validade' e chaves estrangeiras
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    preco_venda DECIMAL(10, 2) NOT NULL,
    quantidade_estoque INT NOT NULL DEFAULT 0,
<<<<<<< HEAD
    validade DATE,
    id_categoria INT,
    id_fornecedor INT,
=======
    validade DATE, -- Sua ótima sugestão!
    id_categoria INT,
    id_fornecedor INT,
    -- Chaves estrangeiras para garantir a integridade dos dados
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
    FOREIGN KEY (id_categoria) REFERENCES categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (id_fornecedor) REFERENCES fornecedores(id) ON DELETE SET NULL
);

<<<<<<< HEAD
=======
-- Tabela de Movimentações com auditoria (id_usuario)
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    tipo ENUM('entrada', 'saida') NOT NULL,
    quantidade INT NOT NULL,
<<<<<<< HEAD
    data_movimentacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
=======
    -- TIMESTAMP é mais preciso que DATE, e o DEFAULT facilita a vida
    data_movimentacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT, -- Essencial para auditoria
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
    observacao VARCHAR(255),
    FOREIGN KEY (id_produto) REFERENCES produtos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE SET NULL
);

<<<<<<< HEAD
=======
-- Inserindo o usuário padrão com senha 'admin' usando bcrypt
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
INSERT INTO usuarios (nome, email, senha) VALUES ('Administrador', 'admin@farmacia.com', '$2y$10$9j6zO.ASz6O8l3.p4.V5UOvB0iYkXzJ.K2G6.Y1Zz.O9C3.W7e');
