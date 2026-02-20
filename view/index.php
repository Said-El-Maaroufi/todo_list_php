<?php 

require_once '../connexion.php';


if($_SERVER["REQUEST_METHOD"] === 'GET'){
    $title = $_GET['task_title'] ?? '';
    
    
if($_GET['btn'] == 'add' ){

    
    if($title){
        $insert_query = 
        "INSERT INTO todo (title)  
        VALUES (:title) ";
        
        $stmt = $todo->prepare($insert_query);
        
        
        $stmt->execute([':title' => $title]);
        
        echo 'insertion réussi';
        
        }else{
            
            echo 'error <br>';
            
            }
    }elseif ($_GET['btn'] == 'check') {
                $id = $_GET['id'];
                $update_query = 
                "UPDATE todo 
                SET done = 1 
                WHERE id = :id";

                $stmt = $todo->prepare($update_query);
                $stmt->execute([
                    ':id' => $id
                ]);
                echo 'bien checked';
                }else{
                    echo 'you have a problem';
                }
        
};






$get_query = 
"SELECT *
FROM todo";

$stmt = $todo->query($get_query);
$table_columns = $stmt->fetchAll();





?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <title>My To Do</title>
    
</head>
<body>
    <form action="" method="get">
    <div class="container ">

        <div class="d-flex gap-2 mt-3">
            <input type="text" class="form-control p-3 fs-5" placeholder="task title....." name="task_title">
            <button class="btn btn-primary" value="add" name="btn" ><i class="bi bi-plus-circle"></i></button>
        </div>

        <?php foreach ($table_columns as $col) : ?> 
        <div class="d-flex   align-items-center gap-3 mt-3 border border-2 p-3 rounded">

            <form action="" method="get">
                <input type="text" hidden name="id"  value="<?= $col['id']?>">
                    <button type="checkbox" name="btn" value="check"   <?= $col['done'] == 0 ? '' : 'checked' ?>  class="form-check-input fs-5 "  id=""></button>
                    <span class="col fs-5 "><?= $col['title']  ?> </span>
                </form>

        </div>
        <?php endforeach; ?> 
    </div>
    </form>
</body>
</html>