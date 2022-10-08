<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['alogin'])==0)
    {
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$courseName=$_POST['courseName'];
$videopath=$_POST['videopath'];
$photo=$_FILES["photo"]["name"];
$yourDir = "/onlinecourse07/admin/studentphoto";
$completePathtoYourFile = $yourDir . "/" . $photo;
move_uploaded_file($_FILES["photo"]["tmp_name"],"studentphoto/".$_FILES["photo"]["name"]);
$ret=mysqli_query($con,"insert into session(studentPhoto,videopath,courseName) values('$photo','$completePathtoYourFile','$courseName')");
if($ret)
{
echo '<script>alert("Student Record updated Successfully !!")</script>';
echo '<script>window.location.href=my-profile.php</script>';
}else{
echo '<script>alert("Something went wrong . Please try again.!")</script>';
echo '<script>window.location.href=my-profile.php</script>';
}
}

// Code for Deletion
if(isset($_GET['del']))
{
mysqli_query($con,"delete from session where id = '".$_GET['id']."'");
echo '<script>alert("Session Deleted")</script>';
echo '<script>window.location.href=session.php</script>';
      }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Student Profile</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
      <style>
body {
  margin:0;
  padding:0;
  font-family: sans-serif;
  background: linear-gradient(#141e30, #243b55);
  background-image: url('studentphoto/ad20.jpg');
  background-size: cover;
 background-repeat: no-repeat;
 background-position:fixed ;
 background-attachment: fixed;

}
</style>
</head>

<body>
<?php if($_SESSION['alogin']!="")
{
 include('includes/menubar.php');
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Upload Dacuments</h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          Upload Dacuments
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>

                        <div class="panel-body">
                       <form name="dept" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="session">Upload</label>
    <input type="file" class="form-control" id="photo" name="photo"  value="<?php echo htmlentities($row['studentPhoto']);?>" />
  </div>

 <div class="form-group">
    <label for="session">Name</label>
    <input type="text" class="form-control" id="courseName" name="courseName" placeholder="Name" value="<?php echo htmlentities($row['courseName']);?>"  />
  </div>

  <?php } ?>

 <button type="submit" name="submit" id="submit" class="btn btn-default">Upload</button>
</form>
                            </div>
                            </div>
                    </div>

                </div>

            </div>


 <div class="col-md-12" >
                    <!--  Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Uploaded Dacuments
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                             <th>Name</th>
                                             <th>Dacuments path</th>
                                        </tr>
                                    </thead>
                                    <tbody>

 <?php
$sql=mysqli_query($con,"select * from session");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                              <td><?php echo htmlentities($row['courseName']);?></td>
                                              <td><a href="<?php echo htmlentities($row['videopath']);?>">
                                              <?php echo htmlentities($row['videopath']);?></a></td>
                                               <td><a href="session.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
                                            <button class="btn btn-danger">Delete</button>
</a></td>

                                        </tr>
<?php
$cnt++;
} ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     <!--  End  Bordered Table  -->
                </div>
            </div>





        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>
<?php ?>
