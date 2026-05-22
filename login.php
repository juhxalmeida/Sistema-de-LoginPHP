<?php
session_start();
include("conexao.php");

$msg = "";

if(isset($_POST['email'])) {

$email = $mysqli->real_escape_string($_POST['email']);
$senha = $mysqli->real_escape_string($_POST['senha']);

$sql = "SELECT * FROM usuarios
WHERE email = '$email'
AND senha = '$senha'";

$resultado = $mysqli->query($sql);

if($resultado && $resultado->num_rows > 0) {

$usuario = $resultado->fetch_assoc();

$_SESSION['id'] = $usuario['id'];
$_SESSION['nome'] = $usuario['nome'];

header("Location: maquiagens.php");
exit;

} else {

$msg = "<div class='alert error'>
E-mail ou senha incorretos.
</div>";
}
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:'Segoe UI', sans-serif;
background:#fce4ec;

display:flex;
justify-content:center;
align-items:center;

min-height:100vh;
margin:0;
}

.container{
background:#fff;
width:350px;
padding:35px;
border-radius:20px;
box-shadow:0 10px 25px rgba(240,98,146,0.2);
}

h2{
color:#d81b60;
margin-bottom:25px;
text-align:center;
}

input{
width:100%;
padding:12px;
margin-top:12px;
border:2px solid #f8bbd0;
border-radius:10px;
outline:none;
font-size:15px;
box-sizing:border-box;
}

input:focus{
border-color:#f06292;
}

button{
width:100%;
padding:12px;
margin-top:15px;
background:#f06292;
color:white;
border:none;
border-radius:10px;
font-size:16px;
font-weight:bold;
cursor:pointer;
box-sizing:border-box;
transition:0.3s;
}

button:hover{
background:#d81b60;
}

.links{
margin-top:15px;
}

.links a{
display:block;
margin-top:8px;
color:#ad1457;
text-decoration:none;
font-size:14px;
text-align:center;
}

.alert{
padding:12px;
border-radius:10px;
margin-bottom:20px;
text-align:center;
font-size:14px;
}

.success{
background:#e8f5e9;
color:#2e7d32;
}

.error{
background:#fdecea;
color:#d32f2f;
}

</style>
</head>

<body>

<div class="container">

<h2>Login 🌸</h2>

<?php echo $msg; ?>

<form method="POST">

<input
type="email"
name="email"
placeholder="Seu e-mail"
required
>

<input
type="password"
name="senha"
placeholder="Sua senha"
required
>

<button type="submit">
Entrar
</button>

</form>

<div class="links">

<a href="esqueceuasenha.php">
Esqueceu a senha?
</a>

<a href="cadastro.php">
Criar conta
</a>

</div>

</div>

</body>
</html>