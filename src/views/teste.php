<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Chat com Gemini</title>
</head>
<body>
    <h1>Chat com Gemini</h1>

    <form action="" method="post">
        <label>Digite sua pergunta:</label><br>
        <textarea name="mensagem" rows="5" cols="50" required></textarea><br><br>
        <input type="submit" value="Enviar">
    </form>

    <?php if (!empty($resposta)): ?>
        <h2>Resposta da IA:</h2>
        <p><?= htmlspecialchars($resposta) ?></p>
    <?php endif; ?>
</body>
</html>