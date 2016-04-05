<?php
$cookie = $_GET["cookie"];

$ch = curl_init("https://abletive.com/api/auth/get_currentuserinfo/?cookie={$cookie}");  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
echo $output = curl_exec($ch);