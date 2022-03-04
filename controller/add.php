<?php

if(isset($_POST['title'])){
    require '../pdo/dbConn.php';

    $title = $_POST['title'];

    if(empty($title)){
        header("Location: ../lembrete.php?mess=error");
    }else {
        $stmt = $conn->prepare("INSERT INTO tb_todo(title) VALUE(?)");
        $res = $stmt->execute([$title]);

        if($res){
            header("Location: ../lembrete.php?mess=success"); 
        }else {
            header("Location: ../lembrete.php");
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../lembrete.php?mess=error");
}