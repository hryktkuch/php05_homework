<?php
require_once('funcs.php');

$pdo = db_conn();

$stmt = $pdo->prepare('SELECT * FROM chat');
$status = $stmt->execute(); //実行

$view='';
if ($status==false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
}else{
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $view .= '<div style="color:red">' . $result['question'] . '</div>';
        $view .= '<div style="color:blue">' . $result['response'] . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="chat.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-content" id="chat-content">
            <?= $view ?>
        </div>
        <form action="chat.php" method="POST" class="chat-footer">
            <textarea placeholder="Type your message here..." name="question"></textarea>
            <button id="submit">Send</button>
        </form>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    </script>
</body>
</html>