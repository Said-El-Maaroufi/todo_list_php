<?php 
require_once "connexion.php";

$msg = '';
$edit = '';
$style =' list-group-item m-2 align-items-center bg-success-subtle p-3 rounded';


if($_SERVER["REQUEST_METHOD"] === "POST"){

if($_POST['btn'] === 'insert'){

    $title = trim($_POST['title']) ?? '';
    if(empty($title)){
        $msg = 'un texte vide';
    }else{
            
        $msg = 'insertion reussi';
        
        $sql_insert = "INSERT INTO todo (title) VALUES (?) ";
        $stmt = $todo->prepare($sql_insert);
        $stmt->execute([$title]);
    }
}elseif($_POST['btn'] === 'delete'){
    
    $id = $_POST['id'];
    $sql_delete = " DELETE FROM todo WHERE id = ? ";
    $stmt = $todo->prepare($sql_delete);
    $stmt->execute([$id]);

    $msg = 'the task is deleted';
}elseif($_POST['btn'] === 'fini'){
    $new_val = $_POST['new_val'];
    $task_id = $_POST['id_act'];
    $sql_update = 'UPDATE todo SET title = :title WHERE id = :id ';
    $stmt = $todo->prepare($sql_update);
    $stmt->execute([
        ':title' => $new_val,
        ':id' => $task_id
    ]);

    $edit = '';
    $msg = 'task is edited';
    
    }else{
        $edit = 'en cours dédition';
        $style = ' list-group-item m-2 align-items-center bg-warning-subtle p-3 rounded';
    $id_act = $_POST['id_act'];
    $val_act = $_POST['val_act'];
    
}
}

$sql_affiche = 'SELECT * FROM todo';
$todos = $todo->query($sql_affiche);

if( count($todos->fetchAll()) === 0 ){
    $sql_delete = "TRUNCATE TABLE todo ";
    $todo->query($sql_delete);
}else{
    $todos = $todo->query($sql_affiche);
}










?> 




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>


<body>


    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">TodoList</span>
        </div>
    </nav>
    <p class="text-dark"><?=  htmlspecialchars($msg) ?> </p>

    <div class="container mt-4" >
        <div class="row justify-content-center">
            
            <form action="" method="POST" class="d-flex gap-2 col-md-6">
                    <input type="text" class="form-control" name="title" placeholder="Task Title">
                    <button name="btn" value="insert" class="btn btn-primary" >add</button>
                </form>
        </div>
    </div>



    
    
    
    
    
<div class="container mt-3 d-flex justify-content-center">
        <ul class=" list-group col-md-6">
            <?php foreach($todos as $todo): ?> 
                <li class="<?= htmlspecialchars($style) ?>"> 
                    <?php if(htmlspecialchars($edit)): ?> 
                        <form action="" method="post" class="d-flex  gap-2 " >
                                <div class="col">
                                    <input type="text" name="new_val" class="form-control" value="<?= $todo['title'] ?>"> 
                                    <input type="text" hidden name="id_act" value="<?= $todo['id'] ?>">
                                </div>
                                
                                <button name="btn" value="fini" class="btn btn-sm btn-primary">Done</button>
                        </form>
                        <?php else: ?> 
                                    <div class="d-flex justify-content-between ">

                                    <span ><?= $todo['title'] ?> </span>
                                    <div class="d-flex gap-2" >
                                        <form action="" method="post" >

                                            <input type="text" hidden name="val_act"  value="<?= $todo['title'] ?>">
                                            <input type="text" hidden name="id_act" value="<?= $todo['id'] ?>">
                                            <button name="btn" value="update" class="btn btn-sm btn-primary">undo</button>
                                            
                                        </form>
                                        <form action="" method="POST">
                                            <input type="text" name="id" value="<?= $todo['id'] ?>" hidden>
                                            <button name="btn" value="delete" class="btn btn-sm btn-danger">X</button>
                                        </form>
                                    </div>
                                    </div>

                                    <?php endif; ?> 
                                </li>
                                    <?php endforeach; ?> 
    </ul>
</div>
        
</body>
</html>