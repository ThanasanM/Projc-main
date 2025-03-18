<?php 

    session_start();
    require_once '../config/db.php';

    if (isset($_POST['signin'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

      
        if (empty($email)) {
            $_SESSION['error'] = 'pease enter email';
            header("location:index.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'email  not is invalid';
            header("location:index.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'please enter password';
            header("location:index.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'password must be 5-20 characters';
            header("location:index.php");
        } else {
            try {

                $check_data = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $check_data->bindParam(":email", $email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if ($check_data->rowCount() > 0) {

                    if ($email == $row['email']) {
                        if (password_verify($password, $row['password'])) {
                        if ($row['urole'] == 'admin') {
                            $_SESSION['admin_login'] = $row['id'];
                            header("location: ..\adminhub\index.html");
                        } elseif ($row['urole'] == 'teacher') {
                            $_SESSION['teacher_login'] = $row['id'];
                            header("location:../thhub\index.html");
                        } else {
                            $_SESSION['user_login'] = $row['id'];
                            header("location: ..\homepage.html");
                        }
                            
                        } else {
                            $_SESSION['error'] = 'passwrong is wrong';
                            header("location:index.php");
                        }
                    } else {
                        $_SESSION['error'] = 'email is wrong';
                        header("location:index.php");
                    }
                } else {
                    $_SESSION['error'] = "not have email ";
                    header("location:index.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>