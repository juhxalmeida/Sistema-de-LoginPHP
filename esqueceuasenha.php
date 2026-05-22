<?php
include("conexao.php");
$msg = "";
if(isset($_POST['email'])) {
    $e = $mysqli->real_escape_string($_POST['email']);
    $q = $mysqli->query("SELECT senha FROM usuarios WHERE email = '$e'");
    if($q && $q->num_rows > 0) {
        $u = $q->fetch_assoc();
        $msg = "<div class='alert success'>Sua senha é: <b>".$u['senha']."</b></div>";
    } else {
        $msg = "<div class='alert error'>E-mail não encontrado.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Recuperar Senha</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fce4ec; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(240, 98, 146, 0.2); width: 100%; max-width: 350px; text-align: center; }
        h2 { color: #d81b60; margin-bottom: 25px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 2px solid #f8bbd0; border-radius: 10px; box-sizing: border-box; outline: none; }
        button { width: 100%; padding: 12px; background: #f06292; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 16px; margin-top: 15px; }
        button:hover { background: #d81b60; }
        a { color: #ad1457; text-decoration: none; display: block; margin-top: 20px; font-size: 14px; }
        .alert { padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .success { background: #e8f5e9; color: #2e7d32; }
        .error { background: #fdecea; color: #d32f2f; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Recuperar Senha 🌸</h2>
        <?php echo $msg; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Seu e-mail" required>
            <button type="submit">Ver Senha</button>
        </form>
        <a href="login.php">Voltar ao Login</a>
    </div>
</body>
</html>