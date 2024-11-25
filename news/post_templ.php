<article class="post">
	<div class="post">
		<pre class="title">author: <?=$post_autor['name']?> <?=$post_autor['surname']?></pre>
		<h1 class="title"><?=$post['title']?></h1>
		<p><?=$post['post_text']?></p>
		<figure>
			<img src=<?='"' . $post['path'] . '"'?>>
		</figure>
		<?php
			if($post['vote']){
				echo "<form method=POST>
					<button class=\"button\" class=\"yes\">✅</button>
					<button class=\"button\" class=\"no\">❌</button>
				</form>";
			}
			if($post['comments']){
				echo "<button class=\"button\" >Comments</button>";
			}
			if($user_info['role'] == 'editor' || $user_info['role'] == 'admin'){
				echo "<form method=POST action=\"delete_post.php\">
					<input type=\"hidden\" name=\"post_id\" value=\"" . $post["id_post"] . "\">
					<button class=\"button\">Delete post</button>
				</form>";
			}
		?>
		
	</div>
</article>
