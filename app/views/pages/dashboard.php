<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div id="app"></div>
    <?php
        var_dump($db::table('users'));
    ?>
    <script src="/assets/main.js"></script>
</body>
</html>