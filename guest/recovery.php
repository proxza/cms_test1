<?php

top('Восстановить пароль');

?>

<h1>Форма</h1>

<p><input type="text" placeholder="Ваш E-mail" id="email"></p>
<p><input type="text" placeholder="Капча" id="captcha"></p>
<p><button onclick="post_query('gform', 'recovery', 'email.captcha')">Восстановить</button></p>

<?php

bottom();

?>
