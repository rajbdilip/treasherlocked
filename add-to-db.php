<?php
	require('config/consts.php');
	require_once('config/db.php');
	
	$upload_ok=1;

	if($_FILES['favicon']['name']!='')
	{
		$target_dir = "_static/img/favicon/";   //Address needs to be changed in live version.

		$target_file = $target_dir . basename($_FILES['favicon']['name']);

		if(strlen($_FILES['favicon']['name'])>20)	//checks the filename string size
		{
			echo "File name is too large. It should be less than 20 characters.";
			exit;
		}

		$check = getimagesize($_FILES['favicon']['tmp_name']);
		
		if($check !== FALSE)	//checks if the file is an image.
		{
			$upload_ok = 1;
		}
		else
		{
			echo "File is not an image";
			$upload_ok = 0;
			exit;
		}

		if($_FILES['favicon']['size'] > 500000)	//checks filesize < 500 KB
		{
			echo "The file size is too large";
			$upload_ok = 0;
			exit;
		}

		if(!move_uploaded_file($_FILES['favicon']['tmp_name'], $target_file))	//checks error in file upload.
		{
			echo "error uploading file";
			exit;
		}

	}

	$data['level'] = $_POST['level'];
	$data['html'] = $_POST['html'];
	$data['answer'] = $_POST['answer'];
	
	if(isset($_POST['url_mask']))
	{
		$data['url_mask'] = $_POST['url_mask'];
	}

	if(isset($_FILES['favicon']['name']) && $upload_ok == 1)
	{
		$data['favicon'] = $_FILES['favicon']['name'];
	}

	$query = $db->insert('questions', $data);
	if(!$query)
	{
		echo "There is an error in adding the question.";
	}

	else
	{
		echo "Question Added Successfully!!";
	}
?>