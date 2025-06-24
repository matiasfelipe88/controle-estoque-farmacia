<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Farmácia Fema</title>
    <link rel="icon" type="image/x-icon" href="../../assets/LOGO_farmacia.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background-color: #f8f9fa; }
        .login-container { max-width: 400px; padding: 2rem; border: 1px solid #dee2e6; border-radius: 0.5rem; background-color: #fff; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Farmácia Fema</h2>
        <?php if (isset($erro) && $erro): ?>
            <div class="alert alert-danger">E-mail ou senha inválidos.</div>
        <?php endif; ?>
        <form action="index.php?controller=auth&action=autenticar" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
        </form>
    </div>
</body>
</html>
