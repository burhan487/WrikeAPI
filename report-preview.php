<?php
include "functions.php";
require("postmark.php");
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

    <title>Preview report for <?php echo $_POST['foldername'];?> - Wrike Reporter</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Blank -->

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">



<script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
        selector: "textarea",
        plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor"
        ],

        toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
        toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | inserttime preview | forecolor backcolor",
        toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

        menubar: false,
        toolbar_items_size: 'small',

        style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],

        templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
        ]
});</script>
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
							$recieveremail=trim($_POST['emailto']);
							$sendername=trim($_POST['emailsendername']);
							$emailmessage=trim($_POST['emailmessage']);
						/*	$htmlemailbody="<div class='col-lg-6'><p>Dear ".$sendername ."</p><p>".$emailmessage."</p>".if(!empty($_POST['task1'])){
							. "<h3>Tasks Active</h3><ul>".foreach($_POST['task1'] as $value1){."<li>".$value1."</li>".}."</ul>".}};
							*/
			$htmlemailbody="<div class='col-lg-6' style='width:80%;'><p>Dear ".$sendername .","."</p><p>".$emailmessage."</p>";	
				if(!empty($_POST['task2'])){
				$htmlemailbody.="<h3>Tasks completed in last 10 days</h3><ul>";
				$task2=$_POST['task2'];
				$responsibleperson=$_POST['task2responsibleuser'];
				$startdate=$_POST['completestartdate'];
				$duedate=$_POST['completetaskduedate'];
				
				/*foreach($_POST['task2'] as $value2){
				$htmlemailbody.= "<li>".$value2."</li>";
				}*/
				for($i=0;$i<count($task2);$i++){
				$htmlemailbody.= "<li>".$task2[$i]."&nbsp;&nbsp;<i><strong>Responsible User:</strong>".$responsibleperson[$i]."</i>&nbsp;&nbsp;"."<i><strong>Start date:</strong>".$startdate[$i]."</i>&nbsp;&nbsp;"."<i><strong>Due date:</strong>".$duedate[$i]."</i>"."</li>";
				}
				$htmlemailbody.= "</ul>";
				}
				
				
				if(!empty($_POST['task1'])){
				$htmlemailbody.="<h3>Tasks due in next 10 days</h3><ul>";
				$task1=$_POST['task1'];
				$responsibleperson=$_POST['responsibleuser'];
				$startdate=$_POST['startdate'];
				$duedate=$_POST['duedate'];
				for($i=0;$i<count($task1);$i++){
				$htmlemailbody.= "<li>".$task1[$i]."&nbsp;&nbsp;<i><strong>Responsible User:</strong>".$responsibleperson[$i]."</i>&nbsp;&nbsp;"."<i><strong>Start date:</strong>".$startdate[$i]."</i>&nbsp;&nbsp;"."<i><strong>Due date:</strong>".$duedate[$i]."</i>"."</li>";
				}
				/*foreach($_POST['task1'] as $value1){
				$htmlemailbody.= "<li>".$value1."</li>";
				}*/
				
				
				if(!empty($_POST['subfoldertasks_due'])){
				$subfoldertasks_due=$_POST['subfoldertasks_due'];
				$subfoldresponsibleuser_due=$_POST['subfoldresponsibleuser_due'];
				$subfoldstartdate_due=$_POST['subfoldstartdate_due'];
				$subfoldendate_due=$_POST['subfoldendate_due'];
				for($i=0;$i<count($subfoldertasks_due);$i++){
				$htmlemailbody.= "<li>".$subfoldertasks_due[$i]."&nbsp;&nbsp;<i><strong>Responsible User:</strong>".	$subfoldertasks_due[$i]."</i>&nbsp;&nbsp;"."<i><strong>Start date:</strong>".$subfoldstartdate_due[$i]."</i>&nbsp;&nbsp;"."<i><strong>Due date:</strong>".$subfoldendate_due[$i]."</i>"."</li>";
				}
				
				}
				
				
				$htmlemailbody.= "</ul>";
				}
				
				
			
				
				
				
				if(!empty($_POST['overdue'])){
				$htmlemailbody.="<h3>Overdue tasks</h3><ul>";
				$overdue=$_POST['overdue'];
				$responsibleperson=$_POST['overdueresponsibleuser'];
				$startdate=$_POST['overduestartdate'];
				$duedate=$_POST['overdueendate'];
				
				/*foreach($_POST['task2'] as $value2){
				$htmlemailbody.= "<li>".$value2."</li>";
				}*/
				for($i=0;$i<count($overdue);$i++){
				$htmlemailbody.= "<li>".$overdue[$i]."&nbsp;&nbsp;<i><strong>Responsible User:</strong>".$responsibleperson[$i]."</i>&nbsp;&nbsp;"."<i><strong>Start date:</strong>".$startdate[$i]."</i>&nbsp;&nbsp;"."<i><strong>Due date:</strong>".$duedate[$i]."</i>"."</li>";
				}
				
				if(!empty($_POST['subfoldertasks_overdue'])){
				$subfoldertasks_overdue=$_POST['subfoldertasks_overdue'];
				$subfoldresponsibleuser_overdue=$_POST['subfoldresponsibleuser_overdue'];
				$subfoldstartdate_overdue=$_POST['subfoldstartdate_overdue'];
				$subfoldendate_overdue=$_POST['subfoldendate_overdue'];
				
				/*foreach($_POST['task2'] as $value2){
				$htmlemailbody.= "<li>".$value2."</li>";
				}*/
				for($i=0;$i<count($subfoldertasks_overdue);$i++){
				$htmlemailbody.= "<li>".$subfoldertasks_overdue[$i]."&nbsp;&nbsp;<i><strong>Responsible User:</strong>".$subfoldresponsibleuser_overdue[$i]."</i>&nbsp;&nbsp;"."<i><strong>Start date:</strong>".$subfoldstartdate_overdue[$i]."</i>&nbsp;&nbsp;"."<i><strong>Due date:</strong>".$subfoldendate_overdue[$i]."</i>"."</li>";
				}	
				}
				
				$htmlemailbody.= "</ul>";
				}
				
				
				

				
				if(!empty($_POST['remainingtasks'])){
			    
				$htmlemailbody.="<h3>All Remaining Task Assigned</h3><ul>";
				$remainingtasks=$_POST['remainingtasks'];
				$responsibleperson=$_POST['remainingresponsibleuser'];
				$startdate=$_POST['remainingtaskstartdate'];
				$duedate=$_POST['remainingtasksduedate'];
				for($i=0;$i<count($remainingtasks);$i++){
				$htmlemailbody.= "<li>".$remainingtasks[$i]."&nbsp;&nbsp;<i><strong>Responsible User:</strong>".$responsibleperson[$i]."</i>&nbsp;&nbsp;"."<i><strong>Start date:</strong>".$startdate[$i]."</i>&nbsp;&nbsp;"."<i><strong>Due date:</strong>".$duedate[$i]."</i>"."</li>";
				}
				$htmlemailbody.= "</ul>";
				}
				
				
				
				/*if(!empty($_POST['subfoldertasks'])){
			    $parentfoldername=$_POST['parentfoldername'];
				$htmlemailbody.="<h3>".$parentfoldername." Sub Folders Tasks</h3><ul>";
				$subfoldertasks=$_POST['subfoldertasks'];
				$subresponsibleperson=$_POST['subfoldresponsibleuser'];
				$substartdate=$_POST['subfoldstartdate'];
				$subduedate=$_POST['subfoldendate'];
				for($i=0;$i<count($subfoldertasks);$i++){
				$htmlemailbody.= "<li>".$subfoldertasks[$i]."&nbsp;&nbsp;<i><strong>Responsible User:</strong>".$subresponsibleperson[$i]."</i>&nbsp;&nbsp;"."<i><strong>Start date:</strong>".$substartdate[$i]."</i>&nbsp;&nbsp;"."<i><strong>Due date:</strong>".$subduedate[$i]."</i>"."</li>";
				}
				$htmlemailbody.= "</ul>";
				}*/
				
				if(!empty($_POST['task3'])){
				$htmlemailbody.="<h3>Tasks deferred in last 10 days</h3><ul>";
				foreach($_POST['task3'] as $value3){
				$htmlemailbody.= "<li>".$value3."</li>";
				}
				$htmlemailbody.= "</ul>";
				}
				if(!empty($_POST['task4'])){
				$htmlemailbody.="<h3>Tasks canceled in last 10 days</h3><ul>";
				foreach($_POST['task4'] as $value4){
				$htmlemailbody.= "<li>".$value4."</li>";
				}
				$htmlemailbody.= "</ul>";
				}
				$htmlemailbody.="<p>If you have any questions please don't hesitate to get in touch.</p></div>";
						$apikey=$row['apikey'];	
				//$postmark = new Postmark("cf1026e6-eda0-4e47-9918-f496da9d0487","dan@webversed.co.uk","dan@webversed.co.uk");
				$organizationname=$row['organizationname'];
				//$postmark = new Postmark($apikey,"dan@webversed.co.uk","dan@webversed.co.uk");
				$fromemail=$row['sendfrom'];
				$nameto=$row['sendto'];
				
				$postmark = new Postmark($apikey,$fromemail,$nameto);		
		$result = $postmark->to("$recieveremail")
		//->subject("Report Wrike Api Task")
		->subject("$organizationname")
		//->plain_message("This is a plain text message.")
		->html_message("$htmlemailbody")
		//->attachment('File.pdf', $file_as_string, 'application/pdf')
		->send();
	
	if($result === true){
		echo "<h3 align='center'>Email send Successfully</h3>";
		}else {
		echo "Error in sending message";
		}		
							?>
							<?php
							}else {
							?>

                                <div class="col-lg-6" style="width:80%;">
								<form method="post">
                        <p>Dear <?php echo $_POST['emailsendername'];?>,<input type="hidden" name="emailsendername" value="<?php echo $_POST['emailsendername'];?>"></p>

						<p><?php echo $_POST['emailmessage'];?>
						<!--<input type="hidden"  value="<?php echo $_POST['emailmessage'];?>" name="emailmessage"/>-->
						
						 <textarea  class="form-control" rows="3" name="emailmessage" style="display:none;"><?php echo $_POST['emailmessage'];?></textarea>
						
						</p>


<?php 
if(!empty($_POST['task2'])){
?>
                         
			<h3>Tasks completed in last 10 days<input type="hidden" name="taskcompleted" value="<?php echo "completed";?>"></h3>
                                    <ul>
									<?php
							$total=count($_POST['task2']);
							
							//echo $total;
for($i=0;$i<$total;$i++){
/*echo $_POST['task2'][$i]."-----------".$_POST['task2responsibleuser'][$i]."-------------".$_POST['completestartdate'][$i]."----".$_POST['completetaskduedate'][$i]."<br/>";*/
?>
 <li><?php echo $_POST['task2'][$i];?><input type="hidden" name="task2[]" value="<?php echo $_POST['task2'][$i];?>">
 <i><?php  echo "<strong>Responsible User:</strong> ".$_POST['task2responsibleuser'][$i];?></i>
 <input type="hidden" name="task2responsibleuser[]" value="<?php echo $_POST['task2responsibleuser'][$i];?>">
 <i><?php echo "<strong>Start Date:</strong> ".$_POST['completestartdate'][$i];?></i>
	<input type="hidden" name="completestartdate[]" value="<?php echo $_POST['completestartdate'][$i];?>">
	<i><?php echo "<strong>Due Date:</strong> ".$_POST['completetaskduedate'][$i];?></i><input type="hidden" name="completetaskduedate[]" value="<?php echo $_POST['completetaskduedate'][$i];?>">
	</li>
  								
											
<?php
}
?>


							
							
							
                                    </ul>
<?php }?>
<?php 
if(!empty($_POST['task1'])){

?>
                        
<h3>Tasks due in next 10 days<input type="hidden" name="taskactive" value="<?php echo "Active";?>"></h3>
                                    <ul>
									<?php 
									//foreach($_POST['task1'] as $value1){
									for($i=0;$i<count($_POST['task1']);$i++){
									
									?>
                                 
	<li><?php  echo $_POST['task1'][$i]; //echo $value1;?><input type="hidden" name="task1[]" value="<?php echo $_POST['task1'][$i];?>">
	<i><?php  echo "<strong>Responsible User:</strong> ".$_POST['responsibleuser_due'][$i];?></i><input type="hidden" name="responsibleuser[]" value="<?php echo $_POST['responsibleuser_due'][$i];?>">&nbsp;<i><?php echo "<strong>Start Date:</strong> ".$_POST['startdate'][$i];?></i>
		<input type="hidden" name="startdate[]" value="<?php echo $_POST['startdate'][$i];?>">&nbsp;<i><?php echo "<strong>Due Date:</strong> ".$_POST['duedate'][$i];?></i><input type="hidden" name="duedate[]" value="<?php echo $_POST['duedate'][$i];?>">
										
										</li>										
									<?php }?>	
									
							<?php 
if(!empty($_POST['subfoldertasks_due'])){
?>  
<?php 
									$total2=count($_POST['subfoldertasks_due']);
									for($i=0;$i<$total2;$i++){
									?>
                                        <li><?php echo $_POST['subfoldertasks_due'][$i];?><input type="hidden" name="subfoldertasks_due[]" value="<?php echo $_POST['subfoldertasks_due'][$i];?>">
										<i><?php  echo "<strong>Responsible User:</strong> ".$_POST['subfoldresponsibleuser_due'][$i];?></i><input type="hidden" name="subfoldresponsibleuser_due[]" value="<?php echo $_POST['subfoldresponsibleuser_due'][$i];?>">&nbsp;<i><?php echo "<strong>Start Date:</strong> ".$_POST['subfoldstartdate_due'][$i];?></i><input type="hidden" name="subfoldstartdate_due[]" value="<?php echo $_POST['subfoldstartdate_due'][$i];?>">&nbsp;<i><?php echo "<strong>Due Date:</strong> ".$_POST['subfoldendate_due'][$i];?></i><input type="hidden" name="subfoldendate_due[]" value="<?php echo $_POST['subfoldendate_due'][$i];?>">
										
										</li>										
									<?php }?>	
									<?php }?> 

									
										
                                    </ul>
<?php }?>





<?php 
if(!empty($_POST['task3'])){
?>
                         
									 <h3>Tasks deferred in last 10 days<input type="hidden" name="taskdeferred" value="<?php echo "deferred";?>"></h3>
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
                         
									 <h3>Tasks canceled in last 10 days<input type="hidden" name="taskcanceled" value="<?php echo "canceled";?>"></h3>
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
             
			 

   
   <?php 
if(!empty($_POST['overdue'])){
?>
                         
									 <h3>Over due Tasks</h3>
                                    <ul>
									<!--<input type="hidden" name="overdue" value="<?php echo $_POST['overdue'];?>">-->
									<?php 
									$total=count($_POST['overdue']);
									for($i=0;$i<$total;$i++){
									//foreach($_POST['overdue'] as $value1){
									?>
                   <li><?php echo $_POST['overdue'][$i];?><input type="hidden" name="overdue[]" value="<?php echo $_POST['overdue'][$i];?>">
							<i><?php  echo "<strong>Responsible User:</strong> ".$_POST['overdueresponsibleuser'][$i];?></i><input type="hidden" name="overdueresponsibleuser[]" value="<?php echo $_POST['overdueresponsibleuser'][$i];?>">&nbsp;<i><?php echo "<strong>Start Date:</strong> ".$_POST['overduestartdate'][$i];?></i><input type="hidden" name="overduestartdate[]" value="<?php echo $_POST['overduestartdate'][$i];?>">&nbsp;<i><?php echo "<strong>Due Date:</strong> ".$_POST['overdueendate'][$i];?></i><input type="hidden" name="overdueendate[]" value="<?php echo $_POST['overdueendate'][$i];?>">		
										</li>										
									<?php }?>	
									
									<?php 
if(!empty($_POST['subfoldertasks_overdue'])){
?>    
<?php 
									$total2=count($_POST['subfoldertasks_overdue']);
									for($i=0;$i<$total2;$i++){
									?>
                                        <li><?php echo $_POST['subfoldertasks_overdue'][$i];?><input type="hidden" name="subfoldertasks_overdue[]" value="<?php echo $_POST['subfoldertasks_overdue'][$i];?>">
										<i><?php  echo "<strong>Responsible User:</strong> ".$_POST['subfoldresponsibleuser_overdue'][$i];?></i><input type="hidden" name="subfoldresponsibleuser_overdue[]" value="<?php echo $_POST['subfoldresponsibleuser_overdue'][$i];?>">&nbsp;<i><?php echo "<strong>Start Date:</strong> ".$_POST['subfoldstartdate_overdue'][$i];?></i><input type="hidden" name="subfoldstartdate_overdue[]" value="<?php echo $_POST['subfoldstartdate_overdue'][$i];?>">&nbsp;<i><?php echo "<strong>Due Date:</strong> ".$_POST['subfoldendate_overdue'][$i];?></i><input type="hidden" name="subfoldendate_overdue[]" value="<?php echo $_POST['subfoldendate_overdue'][$i];?>">
										
										</li>										
									<?php }?>		
									<?php }?>
										
                                    </ul>
<?php }?>






<?php 
if(!empty($_POST['responsibleuserid'])){

?>
                         
 <h3>All remaining tasks assigned to you<input type="hidden" name="taskactive" value="<?php echo "Active";?>"></h3>
                                    <ul>
									<?php 
									$total2=count($_POST['remainingtasks']);
									for($i=0;$i<$total2;$i++){
									if($_POST['responsibleusersid'][$i]==$_POST['responsibleuserid']){
									?>
                                        <li><?php echo $_POST['remainingtasks'][$i];?><input type="hidden" name="remainingtasks[]" value="<?php echo $_POST['remainingtasks'][$i];?>">
										<i><?php  echo "<strong>Responsible User:</strong> ".$_POST['remainingresponsibleuser'][$i];?></i><input type="hidden" name="remainingresponsibleuser[]" value="<?php echo $_POST['remainingresponsibleuser'][$i];?>">&nbsp;<i><?php echo "<strong>Start Date:</strong> ".$_POST['remainingtaskstartdate'][$i];?></i><input type="hidden" name="remainingtaskstartdate[]" value="<?php echo $_POST['remainingtaskstartdate'][$i];?>">&nbsp;<i><?php echo "<strong>Due Date:</strong> ".$_POST['remainingtasksduedate'][$i];?></i><input type="hidden" name="remainingtasksduedate[]" value="<?php echo $_POST['remainingtasksduedate'][$i];?>">
										
										</li>										
									<?php }
									
									}?>		
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
