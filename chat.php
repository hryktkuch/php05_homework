<?php
require_once('funcs.php');

$question=$_POST['question'];

$apikey = '';
$url = 'https://api.openai.com/v1/chat/completions';

// リクエストヘッダー
$headers = array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $apikey
);

// リクエストボディ
$data = array(
  'model' => 'gpt-4o-mini',
  'messages' => [
      ["role" => 'system', 'content' => '関西弁で話して'],
      ['role' => 'user', 'content' => $question],
  ],
  'max_tokens' => 500,
);

// cURLを使用してAPIにリクエストを送信 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 

$response = curl_exec($ch); 
curl_close($ch); 

// 結果をデコード
$result = json_decode($response, true);
//var_dump($result);
$result_message = $result['choices'][0]['message']['content'];

$pdo = db_conn();

$stmt = $pdo->prepare('INSERT INTO chat(question,response) VALUES(:question,:response);');
$stmt->bindValue(':question', $question, PDO::PARAM_STR);
$stmt->bindValue(':response', $result_message, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

if ($status == false) {
    sql_error($stmt);
} else {
    redirect('index.php');
}


// 結果を出力 
//echo $result_message; 
?>

