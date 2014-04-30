<?php
require("postmark.php");

?>

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
				<?php
					if(isset($_POST['sendemail'])){
					?>
                    <h1 class="page-header"></h1>
					<?php }else {?>
					<h1 class="page-header">Preview report for <?php echo $_POST['foldername'];?></h1>
   
					<?php }?>
					<div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
							<?php
							if(isset($_POST['sendemail'])){
							$recieveremail=$_POST['emailto'];
							$sendername=$_POST['emailsendername'];
							$emailmessage=$_POST['emailmessage'];
						/*	$htmlemailbody="<div class='col-lg-6'><p>Dear ".$sendername ."</p><p>".$emailmessage."</p>".if(!empty($_POST['task1'])){
							. "<h3>Tasks Active</h3><ul>".foreach($_POST['task1'] as $value1){."<li>".$value1."</li>".}."</ul>".}};
							*/
							$htmlemailbody="<div class='col-lg-6'><p>Dear ".$sendername .","."</p><p>".$emailmessage."</p>";
				if(!empty($_POST['task1'])){
				$htmlemailbody.="<h3>Tasks Active</h3><ul>";
				foreach($_POST['task1'] as $value1){
				$htmlemailbody.= "<li>".$value1."</li>";
				}
				$htmlemailbody.= "</ul>";
				}
				if(!empty($_POST['task2'])){
				$htmlemailbody.="<h3>Tasks completed</h3><ul>";
				foreach($_POST['task2'] as $value2){
				$htmlemailbody.= "<li>".$value2."</li>";
				}
				$htmlemailbody.= "</ul>";
				}
				
				if(!empty($_POST['task3'])){
				$htmlemailbody.="<h3>Tasks deferred</h3><ul>";
				foreach($_POST['task3'] as $value3){
				$htmlemailbody.= "<li>".$value3."</li>";
				}
				$htmlemailbody.= "</ul>";
				}
				if(!empty($_POST['task4'])){
				$htmlemailbody.="<h3>Tasks canceled</h3><ul>";
				foreach($_POST['task4'] as $value4){
				$htmlemailbody.= "<li>".$value4."</li>";
				}
				$htmlemailbody.= "</ul>";
				}
				$htmlemailbody.="<p>If you have any questions please don't hesitate to get in touch.</p></div>";
							
				$postmark = new Postmark("cf1026e6-eda0-4e47-9918-f496da9d0487","dan@webversed.co.uk","dan@webversed.co.uk");		
		$result = $postmark->to("$recieveremail")
		->subject("Report Wrike Api Task")
		//->plain_message("This is a plain text message.")
		->html_message("$htmlemailbody")
		//->attachment('File.pdf', $file_as_string, 'application/pdf')
		->send();
	
	if($result === true){
		echo "<h3 align='center'>Email send Successfully</h3>";
		}else {
		echo "error in sending message";
		}		
							?>
							<?php
							}else {
							?>

                                <div class="col-lg-6">
								<form method="post">
                        <p>Dear <?php echo $_POST['emailsendername'];?>,<input type="hidden" name="emailsendername" value="<?php echo $_POST['emailsendername'];?>"></p>

                     <p><?php echo $_POST['emailmessage'];?><input type="hidden"  value="<?php echo $_POST['emailmessage'];?>" name="emailmessage"/></p
<?php 
if(!empty($_POST['task1'])){
?>
                         
									 <h3>Tasks Active<input type="hidden" name="taskactive" value="<?php echo "Active";?>"></h3>
                                    <ul>
									<?php 
									foreach($_POST['task1'] as $value1){
									?>
                                        <li><?php echo $value1;?><input type="hidden" name="task1[]" value="<?php echo $value1;?>"></li>										
									<?php }?>		
                                    </ul>
<?php }?>
<?php 
if(!empty($_POST['task2'])){
?>
                         
									 <h3>Tasks completed<input type="hidden" name="taskcompleted" value="<?php echo "completed";?>"></h3>
                                    <ul>
									<?php 
									foreach($_POST['task2'] as $value2){
									?>
                                        <li><?php echo $value2;?><input type="hidden" name="task2[]" value="<?php echo $value2;?>"></li>
                                       <!-- <li>Task 2</li>
                                        <li>Task 3</li>-->
										
									<?php }?>	
										
                                    </ul>
<?php }?>

<?php 
if(!empty($_POST['task3'])){
?>
                         
									 <h3>Tasks deferred<input type="hidden" name="taskdeferred" value="<?php echo "deferred";?>"></h3>
                                    <ul>
									<?php 
									foreach($_POST['task3'] as $value3){
									?>
                                        <li><?php echo $value3;?><input type="hidden" name="task3[]" value="<?php echo $value3;?>"></li>
                                       <!-- <li>Task 2</li>
                                        <li>Task 3</li>-->
										
									<?php }?>	
										
                                    </ul>
<?php }?>

<?php 
if(!empty($_POST['task4'])){
?>
                         
									 <h3>Tasks canceled<input type="hidden" name="taskcanceled" value="<?php echo "canceled";?>"></h3>
                                    <ul>
									<?php 
									foreach($_POST['task4'] as $value4){
									?>
                                        <li><?php echo $value4;?><input type="hidden" name="task4[]" value="<?php echo $value4;?>"></li>
                                       <!-- <li>Task 2</li>
                                        <li>Task 3</li>-->
										
									<?php }?>	
										
                                    </ul>
<?php }?>
             
   
                                    <p>If you have any questions please don't hesitate to get in touch.</p>
           						   <input type="hidden" name="emailto" value="<?php echo $_POST['emailto'];?>">
								    <input type="hidden" name="recipientkey" value="<?php echo isset($_POST['recipientkey']);?>">
									<button type="submit" class="btn btn-primary btn-sm" name="sendemail">Send</button>
									</form>
									
									
									<?php 
				
							?>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            <?php }?>
				
							
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
