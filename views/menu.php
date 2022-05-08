<?php
if ($isAuth): ?>
    Welcome <?= $username ?> <a href="?c=auth&a=logout">[Exit]</a>
<?php else: ?>
    <form action="?c=auth&a=login" method="post">
        <input type="text" name="login" placeholder="LOGIN">
        <input type="text" name="pass" placeholder="PASSWORD">
        <input type="submit" name="submit" placeholder="LOG IN">
    </form>
<?php endif; ?><br>

<a href="/">Главная</a>
<a href="/?c=product&a=catalog">Каталог</a><br>
