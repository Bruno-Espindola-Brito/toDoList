<?php
require 'pdo/dbConn.php';
?>
<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>To-Do List!</title>
        <link rel="stylesheet" href="css/style.css"/>
    </head>
    <body>
        
        <div class="main">
            <div class="add">
                <form action="controller/add.php" method="POST" autocomplete="off">
                    <?php if (isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                        <input type="text" 
                               name="title"
                               style="border-color: #ff6666"
                               placeholder="Digite os seus lembretes (este campo é obrigatório)"/>
                        <button type="submit">adicionar </button>

                    <?php } else { ?>
                        <input type="text" 
                               name="title" 
                               placeholder="Digite os seus lembretes"/>
                        <button type="submit">adicionar </button>
                    <?php } ?>
                </form> 
            </div>
            <?php
            $tb_todo = $conn->query("SELECT * FROM tb_todo ORDER BY id DESC");
            ?>
            <div class="show-todo-section">
                <?php if ($tb_todo->rowCount() <= 0) { ?>
                    <div class="todo-item">
                        <div class="empty">
                            <img src="" alt=""/>
                            <img src="" alt=""/>
                        </div>
                    </div>
                <?php } ?>

                <?php while ($tb_todos = $tb_todo->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="todo-item">
                        <span id="<?php echo $tb_todos['id']; ?>"
                              class="remove-to-do">x</span>
                              <?php if ($tb_todos['checked']) { ?>
                            <input type="checkbox" 
                                   class="check-box" 
                                   data-todo-id ="<?php echo $tb_todos['id']; ?>"
                                   checked />
                            <h2 class="checked"><?php echo $tb_todos['title'] ?> </h2>
                            <small>finalizado em: <?php echo date('y-m-d') ?></small>
                            
                        <?php } else { ?>
                            <input type="checkbox" 
                                   data-todo-id ="<?php echo $tb_todos['id']; ?>"
                                   class="check-box" />
                            <h2><?php echo $tb_todos['title'] ?> </h2>
                            
                        <?php } ?>
                        <br>
                        <small>criado em: <?php echo $tb_todos['date_time'] ?></small>
                    </div>
                
                <?php } ?>

            </div>
        </div>

        <script src="js/jquery-3.2.1.min.js"></script>

        <script>
            $(document).ready(function () {
                $('.remove-to-do').click(function () {
                    const id = $(this).attr('id');

                    $.post("controller/remove.php",
                            {
                                id: id
                            },
                            (data) => {
                        if (data) {
                            $(this).parent().hide(600);
                        }
                    }
                    );
                });

                $(".check-box").click(function (e) {
                    const id = $(this).attr('data-todo-id');

                    $.post('controller/check.php',
                            {
                                id: id
                            },
                            (data) => {
                        if (data != 'error') {
                            const h2 = $(this).next();
                            if (data === '1') {
                                h2.removeClass('checked');
                            } else {
                                h2.addClass('checked');
                            }
                        }
                    }
                    );
                });
            });
        </script>
        <p>
            <a href="view/reset-password.php" class="btn btn-warning">Redefina sua senha</a>
            <a href="view/logout.php" class="btn btn-danger ml-3">Sair da conta</a>
    </p>
    </body>
</html>


