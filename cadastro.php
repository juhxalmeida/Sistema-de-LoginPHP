<?php
include("conexao.php");

if(!isset($_SESSION)) session_start();

$mensagem = "";

// Só processa se o formulário for enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Recebe os dados do formulário
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $sexo = $_POST['sexo'];
    $email = $_POST['email'];
    $senha_pura = $_POST['senha'];

    // 2. Validação simples
    if(empty($nome) || empty($email) || empty($senha_pura)) {
        $mensagem = "<div class='alert error'>Preencha os campos obrigatórios!</div>";
    } else {
        
        // 3. Criptografa a senha (Segurança Máxima)
        $senha_hash = password_hash($senha_pura, PASSWORD_DEFAULT);

        // 4. Verifica se o e-mail já existe (Usando Prepared Statement para segurança)
        $stmt_check = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if($stmt_check->num_rows > 0) {
            $mensagem = "<div class='alert error'>Este e-mail já está em uso!</div>";
        } else {
            
            // 5. Insere no banco (Apenas as colunas que temos certeza que existem)
            $sql = "INSERT INTO usuarios (nome, sobrenome, sexo, email, senha) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $mysqli->prepare($sql);
            $stmt_insert->bind_param("sssss", $nome, $sobrenome, $sexo, $email, $senha_hash);

            if($stmt_insert->execute()) {
                // 6. Login automático e Redirecionamento
                $_SESSION['usuario'] = $mysqli->insert_id;
                header("Location: maquiagens.php");
                exit();
            } else {
                $mensagem = "<div class='alert error'>Erro ao salvar: " . $mysqli->error . "</div>";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Beauty System 🌸</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: #fce4ec; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
        }

        .card-cadastro { 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 15px 35px rgba(233, 30, 99, 0.1); 
            width: 100%; 
            max-width: 400px; 
            text-align: center; 
        }

        h2 { color: #e91e63; margin-bottom: 30px; font-weight: 600; }
        h2::after { content: ' 🌸'; }

        .input-group { margin-bottom: 15px; text-align: left; }
        
        input, select { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #f8bbd0; 
            border-radius: 10px; 
            box-sizing: border-box; 
            outline: none; 
            transition: 0.3s;
            font-size: 14px;
        }

        input:focus, select:focus { border-color: #e91e63; box-shadow: 0 0 8px rgba(233, 30, 99, 0.2); }

        .btn-cadastrar { 
            width: 100%; 
            padding: 14px; 
            background: #e91e63; 
            color: white; 
            border: none; 
            border-radius: 10px; 
            cursor: pointer; 
            font-weight: 600; 
            font-size: 16px; 
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-cadastrar:hover { background: #ad1457; transform: translateY(-2px); }

        .alert { padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        
        .login-link { margin-top: 25px; font-size: 14px; color: #888; }
        .login-link a { color: #e91e63; text-decoration: none; font-weight: 600; }
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="card-cadastro">
        <h2>Criar Conta</h2>
        
        <?php echo $mensagem; ?>

        <form method="POST">
            <div class="input-group">
                <input type="text" name="nome" placeholder="Seu nome" required>
            </div>
            
            <div class="input-group">
                <input type="text" name="sobrenome" placeholder="Seu sobrenome" required>
            </div>

            <div class="input-group">
                <select name="sexo" required>
                    <option value="">Selecione o sexo</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>

            <div class="input-group">
                <input type="email" name="email" placeholder="Seu melhor e-mail" required>
            </div>

            <div class="input-group">
                <input type="password" name="senha" placeholder="Crie uma senha forte" required>
            </div>

            <button type="submit" class="btn-cadastrar">Cadastrar Agora</button>
        </form>

        <div class="login-link">
            Já tem uma conta? <a href="login.php">Entrar agora</a>
        </div>
    </div>

</body>
</html>