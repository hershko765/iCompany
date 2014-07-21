<?php
if ( ! isset($_POST['url'])) { echo "Please provide a url"; die; }

$post = $_POST;
unset($post['url']);
$url = $_POST['url'];
print_r($post); die;
// Register user in bot - Insert in DB and sends email
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);// set url to post to
curl_setopt($ch, CURLOPT_FAILONERROR, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
curl_setopt($ch, CURLOPT_POST, 1); // set POST method
curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // add POST fields
curl_setopt($ch, CURLOPT_USERAGENT, "PHP-5.3.23-".(isset($post['api_username']) ? $post['api_username'] : ''));  // add user agent
$result = curl_exec($ch);// run the whole process
curl_close($ch); // Close CURL connection

echo $result; die;