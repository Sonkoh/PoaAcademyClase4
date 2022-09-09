<?php
    require 'config.php';
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        if (strlen($_POST['name']) > 3 && strlen($_POST['name']) < 16) {
            if (strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 32) {
                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $query = $conn->prepare("SELECT * FROM `users` WHERE `email` = :email OR `name` = :name LIMIT 1");
                    $query->bindParam(':email', $_POST['email']);
                    $query->bindParam(':name', $_POST['name']);
                    if ($query->execute()) {
                        if ($query->rowCount() == 1) {
                            $msg =  'ya existe un usuario con esos datos';
                        } else {
                            $crearusuario = $conn->prepare("INSERT INTO `users`( `name`, `email`, `password`) VALUES (:name, :email, :password)");
                            $crearusuario->bindParam(':name', $_POST['name']);
                            $crearusuario->bindParam(':email', $_POST['email']);
                            $crearusuario->bindParam(':password', md5($_POST['password']));
                            if ($crearusuario->execute()) {
                                header('Location: /login.php');
                            } else {    
                                $msg =  'ha ocurrido un error (sql:2)';
                            }
                        }
                    } else {    
                        $msg =  'ha ocurrido un error (sql)';
                    }
                } else {
                    $msg =  'Email invalido';
                }
            } else {
                $msg = 'tu contraseña no es valido (min: 6; max: 32)';
            }
        } else {
            $msg =  'tu nombre no es valido (min: 3; max: 16)';
        }
    }

    if (isset($msg)) {
        echo "<script>alert('$msg')</script>";
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./toastr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>