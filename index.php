<?php
ob_start();
ini_set('safe_mode', false);
include "functions.php";
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wrike Reporter</title>

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
                <a class="navbar-brand" href="index.html">Wrike Reporter</a>
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
                    <h1 class="page-header">Folders</h1>
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Folder Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
									
                                    <tbody>
				<?php					
			if (isset($_GET["oauth_token"])) {
			$token = $_GET["oauth_token"];
			$token_secret = $_GET["oauth_token_secret"];
			getAccessToken($token, $token_secret);
			}
			else if (isset($_GET["access_token"])) {
			$token = $_GET["access_token"];
	        $token_secret = $_GET["access_token_secret"];
			$result1=getProfile($token,$token_secret);
			$result2=getFolders($token,$token_secret);
			$jsonString=$result2;
            $jsonStringArray = json_decode($jsonString)->foldersTree->folders;
			foreach ($jsonStringArray as $jsonObj) {
			$folderid=$jsonObj->idPath;
			
			$var1=substr($folderid, 0,9);
			$var2=substr($folderid,9);
			
			if(!empty($jsonObj->id)){
			?>
                                  <!--      <tr class="odd gradeA">
                                            <td> <?php echo $jsonObj->title;?></td>
                      <td><a href="report-create.php?idpath=<?php echo str_replace('/','', $folderid);?>&foldername=<?php echo $jsonObj->title;?>&token=<?php echo $_GET["access_token"];?>&token_secret=<?php echo $_GET["access_token_secret"];?>" class="btn btn-primary btn-sm">Create email report</a></td>
                                        </tr>-->
										
										  <tr class="odd gradeA">
                                            <td> <?php if(strlen($folderid)>9){echo "&#9492;".$jsonObj->title;}else {echo $jsonObj->title;}?></td>
                      <td><a href="report-create.php?idpath=<?php if(strlen($folderid)>9){echo str_replace('/','', $var2);}else {echo str_replace('/','', $folderid);}?>&foldername=<?php echo $jsonObj->title;?>&token=<?php echo $_GET["access_token"];?>&token_secret=<?php echo $_GET["access_token_secret"];?>" class="btn btn-primary btn-sm">Create email report</a></td>
                                        </tr>
										
										<?php 
										}/*empty condition*/
										
										}
										
										}else {
									   getRequestToken();
								      }
										?>
										
                                 <!--       <tr class="even gradeA">
                                            <td>Folder 2</td>
                                            <td><a href="report-create.php" class="btn btn-primary btn-sm">Create email report</a></td>
                                        </tr>
                                        <tr class="odd gradeA">
                                            <td>Folder 3</td>
                                            <td><a href="report-create.php" class="btn btn-primary btn-sm">Create email report</a></td>
                                        </tr>
                                        <tr class="even gradeA">
                                            <td>Folder 4</td>
                                            <td><a href="#" class="btn btn-primary btn-sm">Create email report</a></td>
                                        </tr>
                                        <tr class="odd gradeA">
                                            <td>Folder 5</td>
                                            <td><a href="report-create.php" class="btn btn-primary btn-sm">Create email report</a></td>
                                        </tr>-->
                                    </tbody>
                                
								</table>
                            </div>
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
