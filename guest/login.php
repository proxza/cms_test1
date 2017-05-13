<?php

top('Вход');

?>

<h1>Форма входа</h1>

<p><input type="text" placeholder="Ваш E-mail" id="email"></p>
<p><input type="password" placeholder="Ваш пароль" id="password"></p>
<p><input type="text" placeholder="<?captcha_show()?>" id="captcha"></p>
<p><button onclick="post_query('gform', 'login', 'email.password.captcha')">Войти</button> <button>Забыли пароль?</button></p>

<?php

bottom();

?>
