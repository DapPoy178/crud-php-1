<?php
$host       = 'localhost';
$user       = 'root';
$pass       = '';
$db         = 'students';

$connection = mysqli_connect($host, $user, $pass, $db);
if (!$connection) {
    die('failed to connect to the db');
}

$id_student         = '';
$name               = '';
$address            = '';
$faculty            = '';
$success            = '';
$error              = '';

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = '';
}

if ($op == 'delete') {
    $id     = $_GET['id'];
    $sql1   = "delete from users WHERE id = '$id' ";
    $q1     = mysqli_query($connection, $sql1);

    if($q1){
        $success = "Success to delete the data";
    }else{
        $error   = "Error to delete the data";
    }
}

if ($op == 'edit') {
    $id     = $_GET['id'];
    $sql1   = "select * from users WHERE id = '$id'";
    $q1     = mysqli_query($connection, $sql1);
    $r1     = mysqli_fetch_array($q1);
    $id_student = $r1['id_student'];
    $name       = $r1['name'];
    $address    = $r1['address'];
    $faculty    = $r1['faculty'];

    if ($id_student == '') {
        $error = "failed to update the data";
    }
}

if (isset($_POST['submit'])) {
    $id_student      = $_POST['id_student'];
    $name            = $_POST['name'];
    $address         = $_POST['address'];
    $faculty         = $_POST['faculty'];

    if ($id_student && $name && $address && $faculty) {
        if ($op == 'edit') { // edit func
            $sql1   = "update users set id_student= '$id_student', name= '$name', address= '$address', faculty= '$faculty' where id= '$id'";
            $q1     = mysqli_query($connection, $sql1);
            if ($q1) {
                $success    = "Edit data success";
            } else {
                $error      = "Error to edit the data";
            }
        } else { // insert func
            $sql1       = "insert into users(id_student,name,address,faculty) values ('$id_student','$name','$address','$faculty')";
            $q1         = mysqli_query($connection, $sql1);
            if ($q1) {
                $success    = "success to insert the data";
            } else {
                $error      = "error to insert the data";
            }
        }
    } else{
        $error  = "Please input the data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header"> Create / Edit Data </div>
            <?php
            if($error){
            ?>
                <div class="alert alert-danger" role="danger">
                <?php echo $error ?>
                </div>
            <?php
            header("refresh:5;url=index.php");
            }
            ?>
            <?php
            if($success){
            ?>
                <div class="alert alert-success " role="danger">
                <?php echo $success ?>
                </div>
            <?php
            header("refresh:5;url=index.php");
            }
            ?>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3 row">
                        <label for="id_student" class="col-sm-2 col-form-label">ID Student</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="id_student" id="id_student" value="<?php echo $id_student ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo $name ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-sm-2 col-form-label">address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo $address ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="faculty" class="col-sm-2 col-form-label">Faculty</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="faculty" id="faculty">
                                <option value="">- Select Faculty -</option>
                                <option value="science" <?php if ($faculty == "science") echo "selected" ?>>Science</option>
                                <option value="computer" <?php if ($faculty == "computer") echo "selected" ?>>Computer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="submit" value="Save Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-white bg-secondary">Name of Students</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID Student</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Faculty</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2           = "select * from users order by id desc";
                        $q2             = mysqli_query($connection, $sql2);
                        $ordered        = 1;
                        while ($r2      = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $id_student = $r2['id_student'];
                            $name       = $r2['name'];
                            $address    = $r2['address'];
                            $faculty    = $r2['faculty'];
                            ?>
                        <tr>
                            <th scope="row"><?php echo $ordered++ ?></th>
                            <th scope="row"><?php echo $id_student ?></th>
                            <th scope="row"><?php echo $name ?></th>
                            <th scope="row"><?php echo $address ?></th>
                            <th scope="row"><?php echo $faculty ?></th>
                            <th scope="row">
                                <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('are you sure you want to delete this?')"><button type="button" class="btn btn-danger">Delete</button></a>
                            </th>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>