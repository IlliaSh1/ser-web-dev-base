
<?php include __DIR__."/../base/header.php";?>
<tr>
    <td>
        <a href="article/show/<?=$article->getId();?>">Посмотреть статью</a>
    </td>

    <td>
        <ul>
            <li><a href="/labs_php/Project/www/">Главная страница</a></li>
            <li><a href="/labs_php/Project/www/article/create">Создать статью</a></li>
        </ul>
    </td>
</tr>
<?php include __DIR__."/../base/footer.php"; ?>