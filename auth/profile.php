<?php

top('Панель управления');

?>

<h1>Панель управления</h1>

<p>Приветствую тебя <?=$_SESSION['email']?></p>
<br />

<p><input type="text" placeholder="Ваш новый пароль" id="password"></p>
<p><button onclick="post_query('aform', 'edit', 'password')">Сохранить</button> </p>
<?php

bottom();

?>
