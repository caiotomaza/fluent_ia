<?php
    require_once __DIR__ . '/../controllers/user_control.php';

    $controller = new UserController();
    $usuarios = $controller->listarTodos();
?>

<h2>Lista de Usuários</h2>
<ul>
    <?php foreach ($usuarios as $user): ?>
        <li>
            <?= $user->getNome(); ?> - <?= $user->getEmail(); ?>
        </li>
    <?php endforeach; ?>
</ul>
