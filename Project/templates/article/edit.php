<?php include __DIR__."/../base/header.php";?>

    <tr>
        <td>
            <form method="post" action="/labs_php/Project/www/article/update/<?=$article->getId();?>">
                <input type="text" name="title" id="" value="<?=$article->getTitle();?>">
                <input type="text" name="text" id="" value="<?=$article->getText();?>">
                <select name="authorId">
                <?php foreach($users as $user):?>
                    <option value="<?=$user->getId()?>" <?php if($user->getId() == $article->getAuthorId()) echo "selected";?>> 
                        <?=$user->getNickname()?>
                    </option>
                <?php endforeach;?>
            </select>
                <button type="submit">Обновить</button>
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




 

