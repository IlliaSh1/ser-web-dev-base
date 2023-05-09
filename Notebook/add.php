<?php 
include("menu.php");
?>
<form name="form_add" method="post" action="index.php">
    <div class="column">
        <div class="add">
            <label>Фамилия</label> <input type="text" name="firstname" placeholder="Фамилия" >
        </div>
        <div class="add">
            <label>Имя</label> <input type="text" name="name" placeholder="Имя" >
        </div>
        <div class="add">
            <label>Отчество</label> <input type="text" name="lastname" placeholder="Отчество" >
        </div>
        <div class="add">
            <label>Пол</label> 
            <select name="gender">
                <option value=''></option>
                <option value="мужской">мужской</option>
                <option value="женский">женский</option>
            </select>
        </div>
        <div class="add">
            <label>Дата рождения</label> <input type="date" name="date" >
        </div>
        <div class="add">
            <label>Телефон</label> <input type="text" name="phone" placeholder="Телефон" >
        </div>
        <div class="add">
            <label>Адрес</label> <input type="text" name="address" placeholder="Адрес" > 
        </div>
        <div class="add">
            <label>Email</label> <input type="email" name="email" placeholder="Email" >
        </div>
        <div class="add">
            <label>Комментарий</label> <textarea name="comment" placeholder="Краткий комментарий"></textarea>
        </div>
    
            <button type="submit" class="form-btn">Отправить</button>
    </div>
    </form>
<?php
include('footer.php');
?>