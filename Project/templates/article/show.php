
<?php include __DIR__."/../base/header.php";?>
<tr>
    <td>
        <h2><?=$article->getTitle();?></h2>
        <p><?=$article->getText();?></p>
        <div class="article__author-date">
            <p>Автор: <?=$author->getNickname()?>#<?=$author->getId()?></p>
            <div><?=date("F j, Y, g:i a",strtotime($article->getCreatedAt()))?></div>
        </div>
        <hr>
        <h3>Оставить комментарий</h3>
        
        <form class="list list--auto" method="post" action="../<?=$article->getId()?>/comment/store">
            <input type="hidden" name="articleId" value="<?=$article->getId()?>" hidden>
            <select name="authorId">
                <?php foreach($users as $user):?>
                    <option value="<?=$user->getId()?>"> 
                        <?=$user->getNickname()?>
                    </option>
                <?php endforeach;?>
            </select>
            <textarea type="text" name="text" placeholder="Текст комментария" columns="30" rows="5">Текст вашего комментария</textarea>
            <button type="submit">Отправить</button>
        </form>

        <h3>Комментарии</h3>
            
            <?php foreach($comments as $comment):?>
                <div id="comment-<?=$comment->getId()?>">
                    <div class="comment__author-date">
                        <span> Автор: <?=$comment->getAuthor()->getNickname();?>#<?=$comment->getAuthor()->getId();?></span>
                        <div><?=date("F j, Y, g:i a",strtotime($comment->getCreatedAt()))?></div>
                    </div>
                    <p><?=$comment->getText();?></p>
                </div>
            <a href="../../comment/edit/<?=$comment->getId()?>">Редактировать комментарий</a>
            <a href="../../comment/delete/<?=$comment->getId()?>">Удалить комментарий</a>
            <hr>
            <?php endforeach;?>
    </td>
    
    <td>
        <ul>
            <li><a href="/labs_php/Project/www/">Главная страница</a></li>
            <li><a href="/labs_php/Project/www/article/create">Создать статью</a></li>
            <li><a href="/labs_php/Project/www/article/edit/<?=$article->getId()?>">Редактировать статью</a></li>
            <li><a href="/labs_php/Project/www/article/delete/<?=$article->getId();?>">Удалить статью</a></li>
        </ul>
    </td>
</tr>
<?php include __DIR__."/../base/footer.php"; ?>