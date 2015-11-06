<?php

	require_once(dirname(dirname(dirname(__FILE__))) . '/config/consts.php');
	require_once(dirname(dirname(dirname(__FILE__))) . '/config/db.php' );
	if(isset($_POST['submit']))
	{
		$upload_ok=1;
		if($_FILES['favicon']['name']!='')
		{
			$target_dir = DOCUMENT_ROOT . "_static/img/favicon/"; 
			$target_file = $target_dir . basename($_FILES['favicon']['name']);
			if(strlen($_FILES['favicon']['name'])>20)	//checks the filename string size
			{
				$error = "File name is too large. It should be less than 20 characters.";
				$upload_ok = 0;
			}
			$check = getimagesize($_FILES['favicon']['tmp_name']);
			if($check['mime'] != "image/jpeg" && $check['mime'] !="image/png")	//checks if the file is an image.
			{
				$error = "The file type is not supported.";
				$upload_ok = 0;
			}			
			if($_FILES['favicon']['size'] > 500000)	//checks filesize < 500 KB
			{
				$error = "The file size is too large.";
				$upload_ok = 0;
			}
			if($upload_ok != 0)
			{
				if(!move_uploaded_file($_FILES['favicon']['tmp_name'], $target_file))	//checks error in file upload
				{
					$error = "error uploading image.";
					$upload_ok = 0;
				}
			}
		}
		if($upload_ok === 1)
		{
			$db->where('level', $_POST['level']);
			$db->getOne('questions');
			if($db->count > 0)
			{
				$error = "Question for this level already exists.";
				$upload_ok = 0;
			}
			$data['level'] = $_POST['level'];
			$data['html'] = $_POST['html'];
			$data['answer'] = sha1($_POST['answer']);			
			if(isset($_POST['url_mask']))
			{
				$data['url_mask'] = $_POST['url_mask'];
			}
			if($_FILES['favicon']['name']!= '' && $upload_ok == 1)
			{
				$data['favicon'] = $_FILES['favicon']['name'];
			}
			if($upload_ok != 0)
			{
				$query = $db->insert('questions', $data);
				if($query === 0)
				{
					$success = 1;
				}
			}
		}
	}
?>