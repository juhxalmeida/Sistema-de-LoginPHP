<?php
include("conexao.php");
if(!isset($_SESSION)) session_start();

// Proteção: Se não estiver logado, volta para o login
if(!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['usuario'];

// --- LÓGICA PARA ADICIONAR TAREFA ---
if(isset($_POST['nova_tarefa']) && strlen($_POST['nova_tarefa']) > 0) {
    $tarefa = $mysqli->real_escape_string($_POST['nova_tarefa']);
    $prioridade = $_POST['prioridade'];
    $horario = $_POST['horario'];
   
    // Adicionando com prioridade e horário
    $mysqli->query("INSERT INTO tarefas (usuario_id, tarefa, prioridade, horario) VALUES ('$id_usuario', '$tarefa', '$prioridade', '$horario')");
}

// --- LÓGICA PARA CONCLUIR/DESMARCAR ---
if(isset($_GET['toggle'])) {
    $id_t = $_GET['toggle'];
    $mysqli->query("UPDATE tarefas SET concluida = 1 - concluida WHERE id = '$id_t' AND usuario_id = '$id_usuario'");
    header("Location: sucesso.php");
}

// --- LÓGICA PARA EXCLUIR TAREFA ---
if(isset($_GET['excluir'])) {
    $id_tarefa = $_GET['excluir'];
    $mysqli->query("DELETE FROM tarefas WHERE id = '$id_tarefa' AND usuario_id = '$id_usuario'");
    header("Location: sucesso.php");
}

// Busca dados do usuário
$dados_usuario = $mysqli->query("SELECT * FROM usuarios WHERE codigo = '$id_usuario'")->fetch_assoc();

// Busca as tarefas (Ordena pelas não concluídas primeiro)
$lista_tarefas = $mysqli->query("SELECT * FROM tarefas WHERE usuario_id = '$id_usuario' ORDER BY concluida ASC, horario ASC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Meu Camarim Rosa 💄</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fff5f8; margin: 0; padding-bottom: 50px; }
        .navbar { background: #f06292; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(240, 98, 146, 0.3); }
        .main { max-width: 800px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 5px 15px rgba(240, 98, 146, 0.1); margin-bottom: 20px; border: 1px solid #f8bbd0; }
        h2 { color: #d81b60; margin-top: 0; }
       
        /* Formulário */
        .todo-input { display: flex; gap: 10px; margin-bottom: 25px; flex-wrap: wrap; }
        input[type="text"], select, input[type="time"] { padding: 12px; border: 2px solid #f8bbd0; border-radius: 10px; outline: none; background: #fff9fb; }
        input[type="text"] { flex: 2; }
        .btn-add { background: #f06292; color: white; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .btn-add:hover { background: #d81b60; }
       
        /* Itens da Lista */
        .task-item { display: flex; align-items: center; padding: 15px; background: white; border-radius: 15px; margin-bottom: 10px; border-left: 6px solid #f06292; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .task-info { flex: 1; margin-left: 15px; }
        .task-name { font-weight: bold; color: #ad1457; font-size: 16px; }
        .task-meta { font-size: 12px; color: #f48fb1; margin-top: 4px; }
        .done { text-decoration: line-through; color: #f8bbd0 !important; }
       
        /* Badges de Prioridade */
        .badge { padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: bold; color: white; text-transform: uppercase; }
        .Alta { background: #ff1493; }
        .Média { background: #f06292; }
        .Baixa { background: #f8bbd0; }
       
        .btn-del { color: #f48fb1; text-decoration: none; font-size: 11px; font-weight: bold; margin-left: 15px; }
        .btn-del:hover { color: #d81b60; }
        .check-icon { font-size: 22px; text-decoration: none; }
    </style>
</head>
<body>

<div class="navbar">
    <span>Olá, Princesa <b><?php echo $dados_usuario['nome']; ?></b> 🌸</span>
    <a href="logout.php" style="color: white; text-decoration: none; font-weight: bold; background: #d81b60; padding: 8px 15px; border-radius: 10px;">Sair</a>
</div>

<div class="main">
    <div class="card">
        <h2>💄 Minha Rotina de Beleza</h2>
       
        <!-- Formulário para Adicionar -->
        <form method="POST" class="todo-input">
            <input type="text" name="nova_tarefa" placeholder="O que vamos fazer hoje?" required>
            <select name="prioridade">
                <option value="Alta">Urgente 💖</option>
                <option value="Média" selected>Desejo ✨</option>
                <option value="Baixa">Pode esperar 🌸</option>
            </select>
            <input type="time" name="horario" required>
            <button type="submit" class="btn-add">Adicionar</button>
        </form>

        <!-- Lista de Tarefas -->
        <div class="tasks-container">
            <?php if($lista_tarefas->num_rows == 0): ?>
                <p style="text-align:center; color:#f48fb1;">Nenhum item na sua lista ainda. ✨</p>
            <?php else: ?>
                <?php while($t = $lista_tarefas->fetch_assoc()): ?>
                    <div class="task-item" style="border-left-color: <?php echo ($t['concluida'] ? '#fce4ec' : '#f06292'); ?>">
                        <a href="sucesso.php?toggle=<?php echo $t['id']; ?>" class="check-icon">
                            <?php echo $t['concluida'] ? '💖' : '🤍'; ?>
                        </a>
                        <div class="task-info">
                            <div class="task-name <?php if($t['concluida']) echo 'done'; ?>">
                                <?php echo $t['tarefa']; ?>
                            </div>
                            <div class="task-meta">
                                <span class="badge <?php echo $t['prioridade']; ?>"><?php echo $t['prioridade']; ?></span>
                                | 🕒 <?php echo date('H:i', strtotime($t['horario'])); ?>
                            </div>
                        </div>
                        <a href="sucesso.php?excluir=<?php echo $t['id']; ?>" class="btn-del" onclick="return confirm('Remover da lista?')">EXCLUIR</a>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>