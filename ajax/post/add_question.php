<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/ts2/config/consts.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/ts2/config/db.php');
	
	$upload_ok=1;

	if($_FILES['favicon']['name']!='')
	{
		$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/ts2/_static/img/favicon/"; 

		$target_file = $target_dir . basename($_FILES['favicon']['name']);

		if(strlen($_FILES['favicon']['name'])>20)	//checks the filename string size
		{
			echo "<center>File name is too large. It should be less than 20 characters.</center><br />";
			$upload_ok = 0;
		}

		$check = getimagesize($_FILES['favicon']['tmp_name']);
		

		if($check['mime'] != "image/jpeg" && $check['mime'] !="image/png")	//checks if the file is an image.
		{
			echo "<center>The file type is not supported.</center><br />";
			$upload_ok = 0;
		}
		
		if($_FILES['favicon']['size'] > 500000)	//checks filesize < 500 KB
		{
			echo "<center>The file size is too large</center><br />";
			$upload_ok = 0;
		}

		if(!move_uploaded_file($_FILES['favicon']['tmp_name'], $target_file))	//checks error in file upload.
		{
			echo "<center>error uploading file</center><br />";
			$upload_ok = 0;
		}

	}

	if($upload_ok === 1)
	{
		$db->where('level', $_POST['level']);
		$db->getOne('questions');

		if($db->count > 0)
		{
			echo "<center>Question for this level already exists.</center><br />";
			$upload_ok = 0;
		}

		$data['level'] = $_POST['level'];
		$data['html'] = $_POST['html'];
		$data['answer'] = $_POST['answer'];
		
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
				echo "<center>Question Added Successfully.</center/><br />";
				echo "";
			}
		}

		else
		{
			echo "<center>Error in adding question</center><br />";
		}
	}
?>

<html>
<head>
	<title>Add Question</title>
	<link href="<?php echo SSTATIC; ?>css/bootstrap.css" rel="stylesheet" />
</head>
<body>
	<center>
		<a href="<?php echo SITE_URL?>add-question.php" class="btn btn-primary">Go back</a>
	</center>
</body>