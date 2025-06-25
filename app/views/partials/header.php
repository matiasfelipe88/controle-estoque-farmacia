<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Estoque - Farmácia</title>
    <link rel="icon" type="image/x-icon" href="../assets/LOGO_farmacia.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<<<<<<< HEAD
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
=======
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
>>>>>>> 86d728bb717f09bfb3cc0ef58e2af6cf3cbbba3a
        <div class="container">
            <a class="navbar-brand" href="index.php?controller=produto&action=index">
                <img src="../assets/LOGO_farmacia.png" alt="Logo Farmácia" style="height: 40px; margin-right: 10px;">
                Farmácia - Estoque
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'produto') || !isset($_GET['controller']) ? 'active' : ''; ?>" 
                           href="index.php?controller=produto&action=index">
                            <i class="fas fa-boxes me-1"></i>Produtos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'categoria') ? 'active' : ''; ?>" 
                           href="index.php?controller=categoria&action=index">
                            <i class="fas fa-tags me-1"></i>Categorias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'fornecedor') ? 'active' : ''; ?>" 
                           href="index.php?controller=fornecedor&action=index">
                            <i class="fas fa-truck me-1"></i>Fornecedores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'usuario') ? 'active' : ''; ?>" 
                           href="index.php?controller=usuario&action=index">
                            <i class="fas fa-users me-1"></i>Usuários
                        </a>
                    </li>
                </ul>
                
                <div class="navbar-nav">
                    <span class="navbar-text me-3">
                        <i class="fas fa-user-circle me-1"></i>
                        Olá, <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuário'; ?>!
                    </span>
                    <a class="nav-link" href="index.php?controller=auth&action=logout">
                        <i class="fas fa-sign-out-alt me-1"></i>Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">