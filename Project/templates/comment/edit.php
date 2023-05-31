<?php include __DIR__."/../base/header.php";?>

    <tr>
        <td>
            <form class="list list--auto" method="post" action="../update/<?=$comment->getId()?>">
                <select name="authorId">
                    <?php foreach($users as $user):?>
                        <option value="<?=$user->getId()?>" <?php if($user->getId() == $comment->getAuthorId()) echo "selected";?>> 
                            <?=$user->getNickname()?>
                        </option>
                    <?php endforeach;?>
                    
                </select>
                <textarea type="text" name="text" placeholder="Текст комментария" columns="30" rows="5"><?=$comment->getText()?></textarea>
                <button type="submit">Изменить</button>
            </form>
        </td>
    
        <td width="300px" class="sidebar">
            <div class="sidebarHeader">Меню</div>
            <ul>
                <li><a href="/labs_php/Project/www/">Главная страница</a></li>
                <li><a href="/labs_php/Project/www/article/create">Создать статью</a></li>
            </ul>
        </td>
    </tr>

<?php include __DIR__."/../base/footer.php"; ?>




 

