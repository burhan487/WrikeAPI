<?php
ob_start();
$con=mysql_connect('external-db.s149580.gridserver.com','db149580_wrike','uehfud76g');
mysql_select_db('db149580_wrikereporter',$con);
$query1=mysql_query("select * from wrikeapi");
$row=mysql_fetch_array($query1);
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wrike Reporter Settings</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Blank -->

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Wrike Reporter</a>
            </div>
            <!-- /.navbar-header -->
        </nav>
        <!-- /.navbar-static-top -->

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php"><i class="fa fa-table fa-fw"></i> Folders</a>
                    </li>
                    <li>
                        <a href="settings.php"><i class="fa fa-cog fa-fw"></i> Settings</a>
                    </li>
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Settings</h1>
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
						<?php 
						if(isset($_POST['update'])){
						$sendto=$_POST['sendto'];
						$sendfrom=$_POST['sendfrom'];
						$organizationname=$_POST['organizationname'];
						$message=$_POST['message'];
						$apikey=$_POST['apikey'];
						$id=$_POST['id'];
						$query=mysql_query("UPDATE wrikeapi SET sendto='$sendto',sendfrom='$sendfrom',organizationname='$organizationname',message='$message',apikey='$apikey' WHERE id='$id'");
						header("location:settings.php");
						}else if(isset($_POST['Save'])){
						$sendto=$_POST['sendto'];
						$sendfrom=$_POST['sendfrom'];
						$organizationname=$_POST['organizationname'];
						$message=$_POST['message'];
						$apikey=$_POST['apikey'];
						//echo $query="INSERT INTO wrikeapi(sendto, sendfrom,organizationname,message,apikey)VALUES('$sendto',$sendfrom','$organizationname','$message','$apikey')";
						
						$query="INSERT INTO wrikeapi(sendto,sendfrom,organizationname,message,apikey)VALUES('$sendto','$sendfrom','$organizationname','$message','$apikey')"; 
						$result=mysql_query($query);
						header("location:settings.php");
						
						}
						?>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form method="post">
                                        <div class="form-group">
                                            <label>Name to send from</label>
                                            <input class="form-control" name="sendto" value="<?php if(!empty($row['sendto'])){echo $row['sendto'];}else {echo '';}?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Email address to send from</label>
                                            <input class="form-control" name="sendfrom"  value="<?php if(!empty($row['sendfrom'])){echo $row['sendfrom'];}else {echo '';}?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Organisation name</label>
                                            <input class="form-control"  name="organizationname" value="<?php if(!empty($row['organizationname'])){echo $row['organizationname'];}else {echo '';}?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Default message text</label>
                                            <textarea class="form-control" rows="3" name="message"><?php if(!empty($row['message'])){echo $row['message'];}else {echo '';}?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Postmark API key</label>
                                            <input class="form-control" name="apikey" value="<?php if(!empty($row['apikey'])){echo $row['apikey'];}else {echo '';}?>">
                                        </div>
                                        <!--<a href="#" class="btn btn-primary btn-sm">Save</a>-->
										<?php
										if(mysql_num_rows($query1)>0){
										
										?>
										<input type="hidden" name="id" value="<?php echo $row['id'];?>">
										<button type="submit" name="update" class="btn btn-primary btn-sm">Update</button>
										<?php
										}else{ 
										?>
										<button type="submit" name="Save" class="btn btn-primary btn-sm">Save</button>
									<?php } ?>					
	               					 </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Blank -->

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Blank - Use for reference -->

</body>

</html>
