<?php

if (!$_SESSION['confirm']['code']) {
    not_found();
}

top('Подтверждение');

?>

<h1>Подтверждение</h1>

<p><input type="text" placeholder="Код активации" id="code"></p>
<p><button onclick="post_query('gform', 'confirm', 'code')">Подтвердить</button></p>

<?php

bottom();

?>
