

<?php

/*
    if ( 0 < $_FILES['fileInput']['error'] ) {
        echo 'Error: ' . $_FILES['fileInput']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['fileInput']['tmp_name'], 'upload_files/' . $_FILES['fileInput']['fileInput']);
    }
*/


if(isset($_FILES["fileInput"]) && $_FILES["fileInput"]["error"]== UPLOAD_ERR_OK)
{
    ############ Edit settings ##############
    $UploadDirectory    = 'upload_files/'; //specify upload directory ends with / (slash)
    ##########################################
    
	//Delete all files in the directory
	array_map('unlink', glob($UploadDirectory."*"));
	
    /*
    Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini". 
    Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit 
    and set them adequately, also check "post_max_size".
    */
    
    //check if this is an ajax request
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        die();
    }
    
    
    //Is file size is less than allowed size.
    if ($_FILES["fileInput"]["size"] > 5242880) {
        die("File size is too big!");
    }
    
    //allowed file type Server side check
    switch(strtolower($_FILES['fileInput']['type']))
        {
            //allowed file types
            case 'text/plain':
            case 'application/pdf':
            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                break;
            default:
                die('Unsupported File!'); //output error
    }
    
    $File_Name          = strtolower($_FILES['fileInput']['name']);
    $File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
    //$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
    //$NewFileName        = $Random_Number.$File_Ext; //new file name
	$NewFileName          = "upload".$File_Ext;
    
    if(move_uploaded_file($_FILES['fileInput']['tmp_name'], $UploadDirectory.$File_Name ))
       {
        // do other stuff 
               echo('Success! File Uploaded.');
    }else{
        die('error uploading File!');
    }
    
}
else
{
    die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}


?>