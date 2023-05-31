
<?php include __DIR__."/../base/header.php";?>
<tr>
    <td>
        <h2>Создание статьи</h2>
        <form class="list" action="../article/store" method="post">
            <label>
                <span>Заголовок</span>
                <input type="text" name="title" placeholder="your title">
            </label>
            <label>
                <span>Текст</span>
                <input type="text" name="text" placeholder="your text">
            </label>
            <label>
                Автор: 
            <select name="authorId">
                <?php foreach($users as $user):?>
                    <option value="<?=$user->getId()?>">
                        <?=$user->getNickname();?>
                    </option>
                <?php endforeach;?>
            </select>
            </label>
            <div>
                <button type="submit">Добавить</button>
            </div>
        </form>
    </td>

    <td>
        <ul>
            <li><a href="/labs_php/Project/www/">Главная страница</a></li>
        </ul>
    </td>
</tr>
<?php include __DIR__."/../base/footer.php"; ?>