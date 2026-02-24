<?php 

require_once '../connexion.php';




if($_SERVER["REQUEST_METHOD"] === 'POST'){

    if($_POST['btn'] == 'add'){

        $title = $_GET['task_title'] ?? '';
        
        
        
        if($title){
            $insert_query = "INSERT INTO todo (title) VALUES (:title) ";
        
        $stmt = $todo->prepare($insert_query);
        
        
        $stmt->execute([':title' => $title]);
        
        echo 'insertion réussi';
        
        }else{
            
            echo 'error <br>';
            
            }

    
        
}else{
    echo 'not-found';
}
    }           


//recuperation du table todo apartir du base de donnees 
    $get_query =  "SELECT * FROM todo";
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
    <link rel="stylesheet" href="">
    <title>My To Do</title>
    
</head>
<body>
    <div class="container ">
        
        <form action="" method="POST">
        <div class="d-flex gap-2 mt-3">
            <input type="text" class="form-control p-3 fs-5" placeholder="task title....." name="task_title">
            <button class="btn btn-primary" value="add" name="btn" ><i class="bi bi-plus-circle"></i></button>
        </div>
    </form>


        <?php foreach ($table_columns as $col) : ?> 
        <div class="d-flex   align-items-center gap-3 mt-3 border border-2 p-3 rounded">

        <form action="" method="POST">
                
                <input type="text" hidden name="id"  value="<?= $col['id']?>"> </input>
                <button value="check"  name="btn" class="form-check-input me-3" type="button" onclick="checked()"  ></button>
                <span class="col fs-5  " id="title"><?= $col['title']  ?> </span>
        </form>

        </div>
        <?php endforeach; ?> 
    </div>

    <script src="../javascript/index.js"></script>
</body>
</html>