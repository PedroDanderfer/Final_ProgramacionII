<?php 
    if(!isLoggedAdmin()){
        return header('Location: index.php?section=home');
    }
    
    $users = [];

    $querySelectUsers = <<<SELECTUSERS
    SELECT * FROM users;
    SELECTUSERS;

    $rtaSelectUsers = select($querySelectUsers);

    if(count($rtaSelectUsers) > 0){
        $users = $rtaSelectUsers;
    }
?>
<section id="users">
    <ul>
        <?php for ($i=0; $i < count($users); $i++): ?>
            <li>
                <div>
                    <p><?= $users[$i]['name'].' '.$users[$i]['surname'] ?></p>
                    <p><?= $users[$i]['dni'] ?></p>
                </div>
                <?php if($users[$i]['id'] !== $_SESSION['user']['id']): ?>
                    <form action="./back/controller/user/ban.php" method="post">
                        <input type="hidden" name="user" value="<?= $users[$i]['id'] ?>">
                        <?php if($users[$i]['banned'] == 1): ?>
                            <input type="submit" value="Desbloquear usuario" class="unban-icon">
                        <?php else: ?>
                            <input type="submit" value="Bloquear usuario" class="ban-icon">
                        <?php endif; ?>
                    </form>
                    <form action="./back/controller/user/changeRol.php" method="post">
                        <input type="hidden" name="user" value="<?= $users[$i]['id'] ?>">
                        <?php if($users[$i]['role'] === 'admin'): ?>
                            <input type="submit" value="Rebajar a usuario" class="useradmin-icon">
                        <?php else: ?>
                            <input type="submit" value="Ascender a administrador" class="user-icon">
                        <?php endif; ?>
                    </form>
                <?php endif; ?>
            </li>
        <?php endfor; ?>
    </ul>
</section>