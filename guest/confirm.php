<?php

top('Подтверждение');

?>

<h1>Подтверждение</h1>

<p><input type="text" placeholder="Ваш E-mail" id="code"></p>
<p><input type="text" placeholder="Капча" id="captcha"></p>
<p><button onclick="post_query('gform', 'confirm', 'ecode.password.captcha')">Подтвердить</button></p>

<?php

bottom();

?>
