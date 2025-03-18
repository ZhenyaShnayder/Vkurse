<article class="post">
    <div class="post">
        <pre class="title">Автор: <?= htmlspecialchars($post_autor['name']) ?> <?= htmlspecialchars($post_autor['surname']) ?></pre>
        <h1 class="title"><?= htmlspecialchars($post['title']) ?></h1>
        <p><?= nl2br(htmlspecialchars($post['post_text'])) ?></p>
        <figure>
            <img src=<?= '"' . htmlspecialchars($post['path']) . '"' ?>>
        </figure>
        <?php
        if ($post['vote']) {
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

        if ($post['comments']) {
            // Форма для добавления комментария
            echo "<form method='post' action='add_comment.php'>
                <input type='hidden' name='id_post' value='" . $post['id_post'] . "'>
                <textarea name='comment_text' placeholder='Напишите комментарий...' required></textarea>
                <button type='submit'>Отправить</button>
            </form>";

            // Получаем комментарии для текущего поста
            $comments = $db->query("
                SELECT comments.*, users.name, users.surname 
                FROM comments 
                JOIN users ON comments.id_user = users.id 
                WHERE id_post = " . $post['id_post'] . " 
                ORDER BY date DESC
            ");

            if ($comments->num_rows > 0) {
                echo "<div class='comments'>";
                echo "<h3>Комментарии:</h3>";
                while ($comment = $comments->fetch_array()) {
                    echo "<div class='comment'>";
                    echo "<strong>" . htmlspecialchars($comment['name']) . " " . htmlspecialchars($comment['surname']) . ":</strong> ";
                    echo "<p>" . htmlspecialchars($comment['comment_text']) . "</p>";
                    echo "<small>" . $comment['date'] . "</small>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>Комментариев пока нет.</p>";
            }
        }

        if ($user_info['role'] == 'editor' || $user_info['role'] == 'admin') {
            echo "<form method='POST' action='delete_post.php'>
                <input type='hidden' name='post_id' value='" . $post['id_post'] . "'>
                <button class='button'>Удалить пост</button>
            </form>";
        }
        ?>
    </div>
</article>
