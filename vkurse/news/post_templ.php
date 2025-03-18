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
                // Получаем количество голосов "за" и "против"
                $query = "SELECT COUNT(*) as count FROM votes WHERE id_post = ? AND vote = 1";
                $stmt = $db->prepare($query);
                $stmt->bind_param("i", $post['id_post']);
                $stmt->execute();
                $result = $stmt->get_result();
                $yes_votes = $result->fetch_assoc()['count'];

                $query = "SELECT COUNT(*) as count FROM votes WHERE id_post = ? AND vote = 0";
                $stmt = $db->prepare($query);
                $stmt->bind_param("i", $post['id_post']);
                $stmt->execute();
                $result = $stmt->get_result();
                $no_votes = $result->fetch_assoc()['count'];

                // Проверяем, голосовал ли текущий пользователь
                $user_vote = null;
                if (isset($_SESSION['user_id'])) {
                    $query = "SELECT vote FROM votes WHERE id_post = ? AND id_user = ?";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param("ii", $post['id_post'], $_SESSION['user_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $user_vote = $result->fetch_assoc()['vote'];
                    }
                }

                echo "<form method='POST' action='vote.php'>
			<input type='hidden' name='post_id' value='" . $post['id_post'] . "'>
 			<button type='submit' name='vote' value='1' class='button " . ($user_vote == '1' ? 'active' : '') . "'>✅ ($yes_votes)</button>
    			<button type='submit' name='vote' value='0' class='button " . ($user_vote == '0' ? 'active' : '') . "'>❌ ($no_votes)</button>
                </form>";
            }
            if($post['comments']){
                echo "<button class='button'>Comments</button>";
            }
            if($user_info['role'] == 'editor' || $user_info['role'] == 'admin'){
                echo "<form method='POST' action='delete_post.php'>
                    <input type='hidden' name='post_id' value='" . $post['id_post'] . "'>
                    <button class='button'>Delete post</button>
                </form>";
            }
        ?>
    </div>
</article>
