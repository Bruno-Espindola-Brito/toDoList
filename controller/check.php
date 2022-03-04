<?php

if(isset($_POST['id'])){
    require '../pdo/dbConn.php';

    $id = $_POST['id'];

    if(empty($id)){
       echo 'error';
    }else {
        $tb_todo = $conn->prepare("SELECT id, checked FROM tb_todo WHERE id=?");
        $tb_todo->execute([$id]);

        $tb_todos = $tb_todo->fetch();
        $uId = $tb_todos['id'];
        $checked = $tb_todos['checked'];

        $uChecked = $checked ? 0 : 1;

        $res = $conn->query("UPDATE tb_todo SET checked=$uChecked WHERE id=$uId");

        if($res){
            echo $checked;
            
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../lembrete.php?mess=error");
}