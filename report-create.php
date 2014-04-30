<?php
ob_start();
include "functions.php";
error_reporting(0);

$con=mysql_connect('external-db.s149580.gridserver.com','db149580_wrike','uehfud76g');
mysql_select_db('db149580_wrikereporter',$con);
$query1=mysql_query("select * from wrikeapi");
$row=mysql_fetch_array($query1);
/* $taskdate='2014-03-10 09:00:00';
print date('Y-m-d h:i:s', strtotime('-7 days') );
echo strtotime($taskdate);*/
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
                    <h1 class="page-header">Create report for <?php echo $_GET['foldername']; ?></h1>
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row" >
                                <div class="col-lg-6" style="width:80%;">
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
                                            <input class="form-control" name="responsibleuserid">
                                        </div>
										<?php
										$orignalstring=$_GET['idpath'];
							            $token=$_GET['token'];
										$token_secret=$_GET['token_secret'];
										$jsonString=getTasks($token,$token_secret, $orignalstring);
										/*$jsonStringArray = json_decode($jsonString,true);
							
										foreach ($jsonStringArray as $jsonObj) {
										/*echo $jsonObj['id']."------".$jsonObj['status'];*/
										//$taskstatus=$jsonObj['status'];
										
										
										//if($taskstatus==1){*/
										
		
	                                   ?>		
										
						
												<style type="text/css">
												.displaynone{
												display:none;}
												</style>
																	
											          <?php
								$test1=getFilterTasks($token,$token_secret,$orignalstring);
		                        $decodestring1= json_decode($test1)->filteredList;	
								
								if(empty($decodestring1)){
							
										$hidedate='displaynone';
										}else{
										foreach($decodestring1 as $value1){
										
										
										foreach($value1 as $value22){
								if($value22->status==1){	
								
								
								$duedate=$value22->dueDate;
								/*$duedate='2014-04-16';*/
								$enddate=strtotime($duedate);
                                $dayLimit = strtotime('-10 days');
								if($enddate>$dayLimit){
				
							    }else{
								$hidedate='displaynone';
							    }
	
								}
								
								}/*tasks status*/
								
								}		
								}
										?>						
										<div class="form-group <?php echo $hidedate;?>">
                                  
											<label>Tasks completed in last next 10 days</label>
                                        
											 <?php
								
							
							    foreach($decodestring1 as $value11){
								foreach($value11 as $value22){
								$duedate=$value22->dueDate;
								$enddate=strtotime($duedate);
                                $dayLimit = strtotime('-10 days');
								
								
								if($value22->status==1){			
											?>
											<div class="checkbox">
                                                <label>
												    
                           <input type="checkbox" value="<?php echo $value22->title;?>" name="task2[]"><?php echo $value22->title;?>
						   <?php
						   	$contacts=getfullnameContacts($token,$token_secret,$value22->responsibleUsers[0]);
							$jsonStringArray = json_decode($contacts)->contacts->list;
							foreach($jsonStringArray as $value1){
							
								?>					  
								<i><input type="hidden" name="task2responsibleuser[]" value="<?php  echo $value1->firstName; ?>"><?php  echo "<strong>Responsible User:</strong> ".$value1->firstName;?></i>&nbsp;&nbsp;
								<?php }?>
								
			<i><input type="hidden" name="completestartdate[]" value="<?php echo $value22->startDate;?>"><?php echo "<strong>Start Date:</strong> ".$value22->startDate;?></i>&nbsp;&nbsp;<input type="hidden" name="completetaskduedate[]" value="<?php echo $value22->dueDate;?>"><i><?php echo "<strong>Due Date:</strong> ".$value22->dueDate;?></i>
                                                </label>
                                            </div>
                                            	<?php }
												
										
												
												}}?>
											
                                        </div>
										
										<?php //}if($taskstatus==0){?>
				
										
										   <?php
								$test1=getFilterTasks($token,$token_secret,$orignalstring);
		                        $decodestring1= json_decode($test1)->filteredList;	
								
								if(empty($decodestring1)){
							
										$hidedate='displaynone';
										}else{
										foreach($decodestring1 as $taskdue1){
										
										
										foreach($taskdue1 as $taskdue2){
								if($taskdue2->status==0){	
								
								
								$duedate=$taskdue2->dueDate;
								/*$duedate='2014-04-16';*/
								$enddate=strtotime($duedate);
                                $dayLimit = strtotime('+10 days');
								if($enddate>$dayLimit){
				
							    }else{
								$hidedate='displaynone';
							    }
	
								}
								
								}/*tasks status*/
								
								}		
								}
										?>						
										
										
										 <div class="form-group <?php echo $hidedate;?>">
                                            <label>Tasks due in next 10 days</label>
											<?php
									
					/*			$test1=getFilterTasks($token,$token_secret,$orignalstring);
		                        $decodestring1= json_decode($test1)->filteredList;	*/	
							    foreach($decodestring1 as $value11){
								foreach($value11 as $value22){
								if($value22->status==0){					
						                   
											?>
                                            <div class="checkbox">
                                                <label>
                           <input type="checkbox" value="<?php echo $value22->title;?>" name="task1[]"><?php echo $value22->title;?>
							<input type="hidden" name="taskstatus" value="active">
							<?php
				            $contacts=getfullnameContacts($token,$token_secret,$value22->responsibleUsers[0]);
							$jsonStringArray = json_decode($contacts)->contacts->list;
							foreach($jsonStringArray as $username){
							?>
				<i><?php echo "<strong>Responsible User:</strong> ".$username->firstName;?></i>
				<input type="hidden" name="responsibleuser_due[]" value="<?php echo $username->firstName;?>">
				<?php }?>
				
				&nbsp;&nbsp;
				<i><?php echo "<strong>Start Date:</strong> ".$value22->startDate;?></i><input type="hidden" name="startdate[]" value="<?php echo $value22->startDate;?>">&nbsp;<i><?php echo "<strong>Due Date:</strong> ".$value22->dueDate;?></i><input type="hidden" name="duedate[]" value="<?php echo $value22->dueDate;?>">
                                                </label>
                                            </div>
                            	<?php }}}?>
								
									  <?php
								  /*sub folder tasks*/
										$orignalstring=$_GET['idpath']; 
										$token=$_GET['token'];
										$token_secret=$_GET['token_secret'];
										$checkforsub=getsubFolders($token,$token_secret,$orignalstring);
										$decoded = json_decode($checkforsub)->foldersTree->folders;
										if(!empty($decoded)){
										$subfolderid=array();
								        foreach ($decoded as $jsonObj2) {
										$folderid2=$jsonObj2->id;
								        $subfolderid[]=$folderid2;
								        $test1=getFilterTasks($token,$token_secret,$folderid2);
								        }
							$allfilter=array();
							for($i=0;$i<count($subfolderid);$i++){
							$alltasks=getFilterTasks($token,$token_secret,$subfolderid[$i]);
						    $mycode=json_decode($alltasks)->filteredList;	
							foreach($mycode as $value){
							foreach($value as $value77){
							if($value77->status==0){
			                ?>
			
			   <div class="checkbox">
                 <label>
                 <input type="checkbox" value="<?php echo $value77->title;?>" name="subfoldertasks_due[]"><?php echo $value77->title;?>
						<input type="hidden" name="taskstatus" value="active">
							<?php
							$contacts=getfullnameContacts($token,$token_secret,$value77->responsibleUsers[0]);
							$jsonStringArray = json_decode($contacts)->contacts->list;
							foreach($jsonStringArray as $value1){
						?>
						<input type="hidden" name="subfoldresponsibleuser_due[]" value="<?php echo $value1->firstName;?>">
						<i><?php  echo "<strong>Responsible User:</strong> ".$value1->firstName;?></i>
						<?php }?>&nbsp;&nbsp;
						<i><input type="hidden" name="subfoldstartdate_due[]" value="<?php echo $value77->startDate;?>"><?php echo "<strong>Start Date:</strong> ".$value22->startDate;?></i>&nbsp;&nbsp;<input type="hidden" name="subfoldendate_due[]" value="<?php echo $value22->dueDate;?>"><i><?php echo "<strong>Due Date:</strong> ".$value22->dueDate;?></i>
                                               <input type="hidden" name="status" value="<?php echo $value22->status;?>">
											    </label>
                                            </div>
			
			<?php
			}/*end status*/
			}
			}	
			}
			}
			?>

								
								
								
							
			                 </div>
										
										 <div class="form-group">
                                            <label>Overdue Tasks</label>
											<?php
									
								$test1=getFilterTasks($token,$token_secret,$orignalstring);
		                        $decodestring1= json_decode($test1)->filteredList;		
							    foreach($decodestring1 as $value11){
								foreach($value11 as $value22){
								$taskdate=$value22->dueDate;
								$todaydate=date('Y-m-d H:i:s');
								if(strtotime($taskdate)<strtotime($todaydate) and $value22->status==0){					
						                   
											?>
                                            <div class="checkbox">
                                                <label>
                         <input type="checkbox" value="<?php echo $value22->title;?>" name="overdue[]"><?php echo $value22->title;?>
						<input type="hidden" name="taskstatus" value="active">
							<?php
							$contacts=getfullnameContacts($token,$token_secret,$value22->responsibleUsers[0]);
							$jsonStringArray = json_decode($contacts)->contacts->list;
							foreach($jsonStringArray as $value1){
						?>
						<input type="hidden" name="overdueresponsibleuser[]" value="<?php echo $value1->firstName;?>">
						<i><?php  echo "<strong>Responsible User:</strong> ".$value1->firstName;?></i>
						<?php }?>&nbsp;&nbsp;
						<i><input type="hidden" name="overduestartdate[]" value="<?php echo $value22->startDate;?>"><?php echo "<strong>Start Date:</strong> ".$value22->startDate;?></i>&nbsp;&nbsp;<input type="hidden" name="overdueendate[]" value="<?php echo $value22->dueDate;?>"><i><?php echo "<strong>Due Date:</strong> ".$value22->dueDate;?></i>
                                               <input type="hidden" name="status" value="<?php echo $value22->status;?>">
											    </label>
                                            </div>
                            	<?php }}}?>
								
								
								
								  <?php
								  /*overdue tasks*/
										$orignalstring=$_GET['idpath']; 
										$token=$_GET['token'];
										$token_secret=$_GET['token_secret'];
										$checkforsub=getsubFolders($token,$token_secret,$orignalstring);
										$decoded = json_decode($checkforsub)->foldersTree->folders;
										if(!empty($decoded)){
										$subfolderid=array();
								        foreach ($decoded as $jsonObj2) {
										$folderid2=$jsonObj2->id;
								        $subfolderid[]=$folderid2;
								        $test1=getFilterTasks($token,$token_secret,$folderid2);
								        }
							$allfilter=array();
							for($i=0;$i<count($subfolderid);$i++){
							$alltasks=getFilterTasks($token,$token_secret,$subfolderid[$i]);
						    $mycode=json_decode($alltasks)->filteredList;	
							
							
							
							foreach($mycode as $value){
							foreach($value as $value77){
							$taskdate=$value77->dueDate;
							$todaydate=date('Y-m-d H:i:s');
							
							if(strtotime($taskdate)<strtotime($todaydate) and $value77->status==0){
			                ?>
			
			   <div class="checkbox">
                 <label>
                <input type="checkbox" value="<?php echo $value77->title;?>" name="subfoldertasks_overdue[]"><?php echo $value77->title;?>
						<input type="hidden" name="taskstatus" value="active">
							<?php
							$contacts=getfullnameContacts($token,$token_secret,$value77->responsibleUsers[0]);
							$jsonStringArray = json_decode($contacts)->contacts->list;
							foreach($jsonStringArray as $value1){
						?>
						<input type="hidden" name="subfoldresponsibleuser_overdue[]" value="<?php echo $value1->firstName;?>">
						<i><?php  echo "<strong>Responsible User:</strong> ".$value1->firstName;?></i>
						<?php }?>&nbsp;&nbsp;
						<i><input type="hidden" name="subfoldstartdate_overdue[]" value="<?php echo $value77->startDate;?>"><?php echo "<strong>Start Date:</strong> ".$value22->startDate;?></i>&nbsp;&nbsp;<input type="hidden" name="subfoldendate_overdue[]" value="<?php echo $value22->dueDate;?>"><i><?php echo "<strong>Due Date:</strong> ".$value22->dueDate;?></i>
                                               <input type="hidden" name="status" value="<?php echo $value22->status;?>">
											    </label>
                                            </div>
			
			<?php
			}/*end status*/
			}
			}	
			}
			}
			?>
								
                                        </div>
										
										
										
										
										 <div class="form-group" style="display:none;">
                                            <label style="display:none;">Remaining Tasks</label>
											<?php
									
								$test1=getFilterTasks($token,$token_secret,$orignalstring);
		                        $decodestring1= json_decode($test1)->filteredList;		
							    foreach($decodestring1 as $value11){
								foreach($value11 as $value22){
							    if($value22->status!==1){
									
						                   
											?>
                                            <div class="checkbox">
                                                <label>
                <input type="hidden" value="<?php echo $value22->title;?>" name="remainingtasks[]">
				<input type="hidden" name="taskstatus[]" value="active">
				<input type="hidden" name="responsibleusersid[]" value="<?php echo $value22->responsibleUsers[0];?>">
				
				<?php
				
$contacts=getfullnameContacts($token,$token_secret,$value22->responsibleUsers[0]);
$jsonStringArray = json_decode($contacts)->contacts->list;
foreach($jsonStringArray as $value1){			
				?>
				<input type="hidden" name="remainingresponsibleuser[]" value="<?php echo $value1->firstName;?>"><i><?php  echo "<strong>Responsible User:</strong> ".$value1->firstName;?></i>
<?php }?>				
				<input type="hidden" name="remainingtaskstartdate[]" 
value="<?php echo $value22->startDate;?>"><i><?php echo "<strong>Start Date:</strong> ".$value22->startDate;?></i>
<input type="hidden" name="remainingtasksduedate[]" value="<?php echo $value22->dueDate;?>">
<i><?php echo "<strong>Due Date:</strong> ".$value22->dueDate;?></i>
                                                </label>
                                            </div>
                            	<?php }}}?>
								
							
                                        </div>
									
										
										
										
										<?php //}if($taskstatus==2){?>
										<div class="form-group" style="display:none;">
                                            
											<label>Tasks deferred</label>
                                            
											<div class="checkbox">
                                                <label>
                        <input type="checkbox" value="<?php echo $jsonObj['title'];?>" name="task3[]"><?php echo $jsonObj['title'];?>
													
                                                </label>
                                            </div>
                                        </div>
										<?php //}if($taskstatus==3){?>
													<div class="form-group" style="display:none;">
                                            
											<label>Tasks canceled</label>
                                            
											<div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="<?php echo $jsonObj['title'];?>" name="task4[]"><?php echo $jsonObj['title'];?>
                                                </label>
                                            </div>
                                        </div>
										<?php //}
										
										//}/*end foreach*/?>
										
                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea class="form-control" rows="3" name="emailmessage"><?php echo $row['message'];?></textarea>
											<input type="hidden" name="folderid" value="<?php echo $_GET['idpath'];?>"/>
											<input type="hidden" name="foldername" value="<?php echo $_GET['foldername'];?>"/>
											<input type="hidden" name="scret" value="<?php echo $token_secret;?>"/>
											<input type="hidden" name="token" value="<?php echo $token;?>"/>
											<input type="hidden" name="originalstring" value="<?php echo $orignalstring;?>"/>
											
											
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
