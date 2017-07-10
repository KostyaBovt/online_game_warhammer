<?php
require_once 'core/init.php';
    $user = new User();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="css/account.css">
</head>
<body>
    <div class="header"><h2>HELLO, <?php echo $user->data()->login;?></h2>
        <h3><a href="index.php">MAIN</a></h3>
    </div>
    <div style="clear: both" ></div>
    <div class="main">
        <h4>Name : <?php echo $user->data()->name;?></h4>
        <h4>Login : <?php echo $user->data()->login;?></h4>
        <h4>Email : <?php echo $user->data()->email;?></h4>
        <h4>ID : <?php echo $user->data()->id?></h4>
        <h4>Wins : <?php echo $user->data()->wins;?></h4>
        <h4>Registration date : <?php echo $user->data()->registered;?></h4>
    </div>
</body>
</html>