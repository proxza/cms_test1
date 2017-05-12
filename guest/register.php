<?php

top('Регистрация');

?>

<h1>Форма регистрации</h1>

<p><input type="text" placeholder="Ваш E-mail" id="email"></p>
<p><input type="password" placeholder="Ваш пароль" id="password"></p>
<p><input type="text" placeholder="Капча" id="captcha"></p>
<p><button onclick="post_query('gform', 'register', 'email.password.captcha')">Регистрация</button></p>

<?php

bottom();

?>
