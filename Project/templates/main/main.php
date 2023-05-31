<?php include __DIR__."/../base/header.php"; ?>
    <tr>
        <td>
            <?php foreach($articles as $article):?>

                <h2><a href="article/show/<?=$article->getId();?>"><?=$article->getTitle();?></a></h2>
                <div class="article__author-date">
                    <p>Автор: <?=$article->getAuthor()->getNickname()?>#<?=$article->getAuthor()->getId()?></p>
                    <div><?=date("F j, Y, g:i a",strtotime($article->getCreatedAt()))?></div>
                </div>
                <p><?=$article->getText();?></p>
                <a href="article/delete/<?=$article->getId();?>">Удалить</a>
                <hr>
            <?php endforeach;?>
        </td>
    
        <td>
            <ul>
                <li><a href="/labs_php/Project/www/">Главная страница</a></li>
                <li><a href="/labs_php/Project/www/article/create">Создать статью</a></li>
                <li><a href="/labs_php/Project/www/hello/Illia">Обо мне</a></li>
            </ul>
        </td>
    </tr>
<?php include __DIR__."/../base/footer.php"; ?>