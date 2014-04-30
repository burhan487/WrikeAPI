<?php
include "functions.php";
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create report for <?php echo $_GET['foldername']; ?>- Wrike Reporter</title>

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
                    <h1 class="page-header">Create report for <?php echo $_GET['foldername']; ?></h1>
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form action="report-preview.php" method="post">
                                        <div class="form-group">
                                            <label>Name to send to</label>
                                            <input class="form-control" name="emailsendername">
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address to send to</label>
                                            <input class="form-control" name="emailto">
                                        </div>
                                        <div class="form-group">
                                            <label>Recipient Wrike UID (Optional)</label>
                                            <input class="form-control" name="recipientkey">
                                        </div>
										<?php
										$orignalstring=$_GET['idpath'];
							            $token=$_GET['token'];
										$token_secret=$_GET['token_secret'];
										$jsonString=getTasks($token,$token_secret, $orignalstring);
										$jsonStringArray = json_decode($jsonString,true);
							
										foreach ($jsonStringArray as $jsonObj) {
										/*echo $jsonObj['id']."------".$jsonObj['status'];*/
										$taskstatus=$jsonObj['status'];
										if($taskstatus==0){
										?>
										
                                      <div class="form-group">
                                            <label>Tasks Active</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="<?php echo $jsonObj['title'];?>" name="task1[]"><?php echo $jsonObj['title'];?>
													<input type="hidden" name="taskstatus" value="active">
                                                </label>
                                            </div>
                            
                                        </div>
                                        
										<?php }if($taskstatus==1){?>
										<div class="form-group">
                                            
											<label>Tasks completed</label>
                                            
											<div class="checkbox">
                                                <label>
												    
                                                    <input type="checkbox" value="<?php echo $jsonObj['title'];?>" name="task2[]"><?php echo $jsonObj['title'];?>
                                                </label>
                                            </div>
                                            
											
                                        </div>
										
										<?php }if($taskstatus==2){?>
										<div class="form-group">
                                            
											<label>Tasks deferred</label>
                                            
											<div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="<?php echo $jsonObj['title'];?>" name="task3[]"><?php echo $jsonObj['title'];?>
                                                </label>
                                            </div>
                                        </div>
										<?php }if($taskstatus==3){?>
													<div class="form-group">
                                            
											<label>Tasks canceled</label>
                                            
											<div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="<?php echo $jsonObj['title'];?>" name="task4[]"><?php echo $jsonObj['title'];?>
                                                </label>
                                            </div>
                                        </div>
										<?php }
										
										}/*end foreach*/?>
										
                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea class="form-control" rows="3" name="emailmessage"></textarea>
											<input type="hidden" name="folderid" value="<?php echo $_GET['idpath'];?>"/>
											<input type="hidden" name="foldername" value="<?php echo $_GET['foldername'];?>"/>
                                        </div>
                                       <!-- <a href="#" class="btn btn-primary btn-sm">Preview and send</a>-->
										<button type="submit" value="" class="btn btn-primary btn-sm"  value="Preview and send">Preview and send</button>
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
