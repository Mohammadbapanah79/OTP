<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>

<body>
    <h1 style="text-align: center;">User Profile</h1>
    <a href="<?= siteUrl('?action=logout') ?>">Logout</a>
    <ul>
        <?php foreach ($userData as $key => $value): ?>
            <li><?= "$key : $value"; ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>