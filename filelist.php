<?php
	$files = scandir('upload_files/');
	foreach($files as $file){
		echo'<a href="/upload_files/'.$file.'">'.$file.'</a>';
	}
?>