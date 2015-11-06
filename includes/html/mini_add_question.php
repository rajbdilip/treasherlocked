<?php

	require_once(dirname(dirname(dirname(__FILE__))) . '/config/consts.php');
	require_once(dirname(dirname(dirname(__FILE__))) . '/config/db.php' );
	if(isset($_POST['submit']))
	{
		$upload_ok=1;
			$db->where('level', $_POST['level']);
			$db->getOne('mini_questions');
			if($db->count > 0)
			{
				$error = "Question for this level already exists.";
				$upload_ok = 0;
			}
			$data['level'] = $_POST['level'];
			$data['html'] = $_POST['html'];
			$data['answer'] = sha1($_POST['answer']);			

			if($upload_ok != 0)
			{
				$query = $db->insert('mini_questions', $data);
				if($query === 0)
				{
					$success = 1;
				}
			}
		
	}
?>