     <div class="topic">
         <?php
            $stmt2 = $db->prepare('SELECT p.id, p.member_id, p.message, p.picture, p.created, p.iine, m.name, m.picture, m.status, m.course, m.School_year from posts p, members m where m.id=p.member_id order by iine desc limit 3');
            $stmt2->execute();
            ?>

         <?php while ($stmt2->fetch()) : ?>
             <?php if ($picture) : ?>

                 <a href="./myprofile.php?id=<?php echo htmlspecialchars($member_id); ?>">
                     <img src="../member_picture/<?php echo htmlspecialchars($picture); ?>" alt="" width="100" height="100">
                 </a>
             <?php endif; ?>

             <!-- ユーザーが写真を登録していない場合はデフォルトの画像を表示 -->
             <?php if (!$picture) : ?>
                 <a href="./myprofile.php?id=<?php echo htmlspecialchars($member_id); ?>">
                     <img src="../img/default.png" alt="" width="100" height="100">
                 </a>
             <?php endif; ?>
         <?php endwhile; ?>

     </div>