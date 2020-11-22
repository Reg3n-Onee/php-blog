<?php
  session_start();
  require '../config/config.php';

  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }
  if($_SESSION['role'] != 1){
    header("Location: login.php");
  }
  if($_POST){
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file,PATHINFO_EXTENSION);

      if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
         echo "<script>alert('Image must be png, jpg or jpeg')</script>";
      }else {
          $title = $_POST['title'];
          $content = $_POST['content'];
          $image = $_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'],$file);

          $stmt = $pdo->prepare("INSERT INTO posts(title,content,author_id,image) VALUES (:title,:content,:author_id,:image)");
          $result = $stmt->execute(
            array(':title'=>$title,':content'=>$content,':author_id'=>$_SESSION['user_id'],':image'=>$image)
          );
          if ($result) {
            echo "<script>alert('Successfully Added')</script>";
            echo "<script>window.location='index.php'</script>";
            
          }
      }
  }
?>

<?php
  include('header.php');
?>
    <!-- Main content -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            <form class="" action="add.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="title" value="" required>
                </div>
                <div class="form-group">
                    <label for="">Content</label><br>
                    <textarea name="content" id="" cols="30" rows="10"></textarea>
                </div>                
                <div class="form-group">
                    <label for="">Image</label><br>
                    <input type="file" class="form-control" name="image" value="" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" name="" value="Submit">
                    <a href="index.php" class="btn btn-default">Back</a>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- /.content -->
  <?php include('footer.php');?>