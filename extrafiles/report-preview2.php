<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Preview report for <?php echo $_POST['foldername'];?> - Wrike Reporter</title>

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
                    <h1 class="page-header">Preview report for Folder 1</h1>
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
								<form action="sendemail.php" method="post">
                        <p>Dear <?php echo $_POST['emailsendername'];?>,<input type="hidden" name="emailsendername" value="<?php echo $_POST['emailsendername'];?>"></p>

                                    <p><?php echo $_POST['emailmessage'];?><input type="hidden"  value="<?php echo $_POST['emailmessage'];?>" name="emailmessage"/></p>
<p>Tasks:<?php echo $_POST['task'];?><input type="hidden" name="task" value="<?php echo $_POST['task'];?>"></p>
                                   <!-- <h3>Tasks completed in last 10 days</h3>

                                    <ul>
                                        <li>Task 1</li>
                                        <li>Task 2</li>
                                        <li>Task 3</li>
                                    </ul>

                                    <h3>Tasks due in next 10 days</h3>

                                    <ul>
                                        <li>Task 4 <span>due 10th March</span></li>
                                        <li>Task 5 <span>due 10th March</span></li>
                                        <li>Task 6 <span>due 10th March</span></li>
                                    </ul>

                                    <h3>All remaining tasks assigned to you</h3>

                                    <ul>
                                        <li>Task 4 <span>due 10th March</span></li>
                                        <li>Task 5 <span>due 10th March</span></li>
                                        <li>Task 6 <span>due 10th March</span></li>
                                    </ul>
-->
                                    <p>If you have any questions please don't hesitate to get in touch.</p>

                                   <!-- <a href="#" class="btn btn-primary btn-sm">Send</a>-->
								   <input type="hidden" name="emailto" value="<?php echo $_POST['emailto'];?>">
								    <input type="hidden" name="recipient" value="<?php echo $_POST['recipient'];?>">
									<button type="submit">Send</button>
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
