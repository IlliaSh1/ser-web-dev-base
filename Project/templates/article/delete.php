
<?php include __DIR__."/../base/header.php";?>
<tr>
    <td>
        <a href="/labs_php/Project/www/">На главную</a>
    </td>

    <td>
        <ul>
            <li><a href="/labs_php/Project/www/">Главная страница</a></li>
            <li><a href="/labs_php/Project/www/article/create">Создать статью</a></li>
            <li><a href="/labs_php/Project/www/article/edit/<?=$article->getId()?>">Редактировать статью</a></li>
        </ul>
    </td>
</tr>
<?php include __DIR__."/../base/footer.php"; ?>