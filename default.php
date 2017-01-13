<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Sharable File Presentation</title>
  <meta name="description" content="">
  <meta name="author" content="Sandipan">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="css/main.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="js/jquery.form.min.js"></script>
  <script type="text/javascript" src="js/jquery.blockUI.js"></script>
  
<script type="text/javascript">
	$(document).ready(function() { 
	
		$(document).ajaxStop($.unblockUI);  
		
		var options = { 
				//target:   '#output',   // target element(s) to be updated with server response 
				beforeSubmit:  beforeSubmit,  // pre-submit callback 
				success:       afterSuccess,  // post-submit callback 
				//uploadProgress: OnProgress, //upload progress callback 
				resetForm: true,        // reset the form after successful submit 
				cache: false
			}; 
			
		 $('#fileUploadForm').submit(function() { 
				$(this).ajaxSubmit(options);  			
				// always return false to prevent standard browser submit and page navigation 
				return false; 
			}); 
			

	//function after succesful file upload (when server response)
	function afterSuccess()
	{
		$('#output').html('Success! File Uploaded.'); //hide submit button
		//$('#fileListDiv').load('filelist.php'):
	}

	//function to check file size before uploading.
	function beforeSubmit(){
		//check whether browser fully supports all File API
	   if (window.File && window.FileReader && window.FileList && window.Blob)
		{
			
			if( !$('#fileInput').val()) //check empty input filed
			{
				$("#output").html("Are you kidding me?");
				return false
			}
			
			var fsize = $('#fileInput')[0].files[0].size; //get file size
			var ftype = $('#fileInput')[0].files[0].type; // get file type
			
			alert(ftype);
			//allow file types 
			switch(ftype)
			{
				case 'text/plain':
				case 'application/pdf':
				case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
				case 'application/vnd.ms-powerpoint':
					break;
				default:
					$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
					return false
			}
			
			//Allowed file size is less than 5 MB (1048576)
			if(fsize>5242880) 
			{
				$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
				return false
			}
					
			$.blockUI(); 
			$("#output").html("");  
		}
		else
		{
			//Output error to older unsupported browsers that doesn't support HTML5 File API
			$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
			return false;
		}
	}

	//progress bar function
	function OnProgress(event, position, total, percentComplete)
	{
		//Progress bar
		$('#progressbox').show();
		$('#progressbar').width(percentComplete + '%') //update progressbar percent complete
		$('#statustxt').html(percentComplete + '%'); //update status text
		if(percentComplete>50)
			{
				$('#statustxt').css('color','#000'); //change status text to white after 50%
			}
	}

	//function to format bites bit.ly/19yoIPO
	function bytesToSize(bytes) {
	   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	   if (bytes == 0) return '0 Bytes';
	   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
	   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
	}

}); 
</script>
</head>
<body>
<div class="row">
	<div class="container">
		<h2 class="title">Upload File</h2>
		<form  action="upload.php" method="post" enctype="multipart/form-data" class="form-signin" id="fileUploadForm">
			<!--<h4 class="section-heading"><span>Upload Presentation File</span></h4>
			<div class="row">
				<div class="column">
					<label>FILE NAME</label>
					<input id="username" class="full-width" type="text" placeholder="">
				</div>
			</div>-->
			<div class="row">
				<div class="column">
					<label>Select from .txt, .pdf, .ppt or .pptx Files</label>
					<input name="fileInput" class="full-width" id="fileInput" type="file" placeholder=""/>
				</div>
			</div>
			
			<div class="row">
				<div class="column">
					<label id="output" style="color:blue"></label>
				</div>
			</div>
			<br>
			<input class="button-submit" type="submit" value="UPLOAD">
		</form>
		
		<div>
			<div id="fileListDiv">
				<?php include 'filelist.php';?>
			</div>
		</div>
	</div>
	
	

</div>
</body></html>