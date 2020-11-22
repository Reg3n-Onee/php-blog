<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header("Location: login.php");
}
if($_SESSION['role'] != 1){
  header("Location: login.php");
}
if($_POST){
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  if(empty($_POST['role'])){
      $role = 0 ;
  }
  else{
      $role = 1;
  }

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND id != :id ");

    $stmt->execute(array(':email'=>$email,':id'=>$id));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
      echo "<script>alert('Email duplicated')</script>";
    }else{
    $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='$role' WHERE id='$id'");
    $result = $stmt->execute();
    if($result){
      echo "<script>alert('Successfully Updated');window.location.href='user_list.php';</script>";
    }
  
}
  }



$stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$stmt->execute();

$result = $stmt->fetchAll();

include 'header.php';
?>
 <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post">
                <div class="form-group">
                  <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                  <label>Name</label>
                  <input type="text" name="name" class="form-control" value="<?php echo $result[0]['name'] ?>" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" value="<?php echo $result[0]['email'] ?>" required>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="text" name="password" class="form-control" value="<?php echo $result[0]['password'] ?>" required>
                </div>
                <div>
                  <label>Admin</label>
                  <input type="checkbox" name="role" <?php echo $result[0]['role'] == 1 ? 'checked' : ''?> >
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                  <a href="user_list.php" class="btn btn-warning">Back</a>
                </div>
              </div>
            </div>
            <!-- /.card -->

            
             
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php 
  include 'footer.php';
   ?>

  
