<?php
	if(!isset($_COOKIE["session"])){
		header("Location: /");
		exit;
	}
	
	$db = new mysqli('127.0.0.1', 'root', '', 'vkurse_db'); // connect to database
	
	if (!$db) {
		echo "<!DOCTYPE html>
		<html>
		<body>
		<h1>Connection to DB failed. Errno:" . $db->connect_errno . "</h1>
		</body>
		</html>"; 
		exit();
	}

	$db->set_charset("utf8"); // set charset
	
	$user_id = $db->query("SELECT * FROM session WHERE cookie='" . $_COOKIE["session"] . "';")->fetch_array(); 
	
	if ($user_id == null){
		header("Location: /");
	}
	
	$user_id = $user_id['id'];
	
	$user_info = $db->query("SELECT * FROM users WHERE id=" . $user_id . ";")->fetch_array(); 
	
	$posts;
	
	if ($user_info['departament']=='admin'){
		$posts = $db->query("SELECT * FROM posts");
	} 
	else 
	{
		$posts = $db->query("SELECT * FROM posts WHERE JSON_CONTAINS(departament, '[\"" . $user_info['departament'] . "\"]');"); 
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="news.css">
		<script src="news.js"></script>
		<title>News</title>
	</head>
	<body>
		<header class='panel'>
			<h1>Vkurse</h1>
			<div class="Name_out">
				<pre><?=$user_info['name']?> <?=$user_info['middle_name']?> <?=$user_info['surname']?></pre>
				<?php
					if($user_info['role'] == 'editor' || $user_info['role'] == 'admin'){
						echo "<a class=\"post_for_editor\" href=\"\\Post\\\">New post</a>";
					}
				?>
				<button class="outside" onclick="proverka();">Выйти</button>
			</div>
		</header>
		<?php
		while ($post = $posts->fetch_array()){
			$post_autor = $db->query("SELECT * FROM users WHERE id=" . $post['id_user'] . ";")->fetch_array();
			include 'post_templ.php';
		}
		?>

	</body>
</html>
<?php $db->close(); ?>
