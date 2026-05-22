<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Guia de Maquiagem 🌸</title>
    <?php
session_start();

if(!isset($_SESSION['id'])) {
header("Location: login.php");
exit;
}
?>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fce4ec; margin: 0; padding: 40px; color: #444; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { color: #d81b60; font-size: 36px; }
        .container { max-width: 900px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 8px 20px rgba(240, 98, 146, 0.15); transition: 0.3s; }
        .card:hover { transform: translateY(-5px); }
        .card h3 { color: #f06292; margin-top: 0; border-bottom: 2px solid #fce4ec; padding-bottom: 10px; }
        .card p { line-height: 1.6; font-size: 15px; }
        .footer { text-align: center; margin-top: 50px; }
        .btn-voltar { background: #f06292; color: white; padding: 12px 25px; text-decoration: none; border-radius: 10px; font-weight: bold; transition: 0.3s; }
        .btn-voltar:hover { background: #d81b60; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Guia Essencial de Maquiagem 🌸</h1>
        <p>Aprenda o que cada item faz e como usar para realçar sua beleza!</p>
    </div>

    <div class="container">
        <div class="card">
            <h3>1. Primer</h3>
            <p>O primeiro passo! Ele prepara a pele, fecha os poros e faz a maquiagem durar muito mais tempo. É como uma "tela" lisa para começar a pintura.</p>
        </div>

        <div class="card">
            <h3>2. Base</h3>
            <p>Serve para uniformizar o tom da pele e esconder imperfeições. Existem bases líquidas, em bastão ou pó, com coberturas leves ou pesadas.</p>
        </div>

        <div class="card">
            <h3>3. Corretivo</h3>
            <p>O melhor amigo para esconder olheiras, espinhas ou manchas específicas que a base não cobriu totalmente. Aplique em pontos estratégicos.</p>
        </div>

        <div class="card">
            <h3>4. Pó Compacto/Solto</h3>
            <p>Serve para "selar" a maquiagem líquida, tirando o brilho excessivo de oleosidade e garantindo que nada saia do lugar durante o dia.</p>
        </div>

        <div class="card">
            <h3>5. Blush</h3>
            <p>Dá aquele ar de saúde no rosto! Aplicado nas maçãs da face, ele devolve o corado natural que a base acaba escondendo.</p>
        </div>

        <div class="card">
            <h3>6. Iluminador</h3>
            <p>O toque de brilho! É usado nos pontos altos do rosto (como o topo do nariz e acima das maçãs) para refletir a luz e dar um glow especial.</p>
        </div>

        <div class="card">
            <h3>7. Máscara de Cílios (Rímel)</h3>
            <p>Serve para alongar, dar volume e curvar os cílios, abrindo o olhar e deixando os olhos muito mais expressivos.</p>
        </div>

        <div class="card">
            <h3>8. Batom / Gloss</h3>
            <p>O toque final! O batom dá cor e definição aos lábios, enquanto o gloss traz brilho e uma aparência de lábios mais volumosos.</p>
        </div>
    </div>

    <div class="footer">
        <a href="login.php" class="btn-voltar">Sair do Sistema</a>
    </div>

</body>
</html>