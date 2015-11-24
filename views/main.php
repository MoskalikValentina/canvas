<!DOCTYPE html>
<html>
<head lang="ru">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="../css/style.css?v=@version@"/>
    <link href="favicon.ico" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>




<script src="../js/script.js?v=@version@"></script>
<!-- Counters -->
<?php
    if($config->counters() && file_exists(BASEDIR . 'views/counters.php')){
        include BASEDIR . 'views/counters.php';
    }
?>
<!-- / Counters -->

</body>
</html>