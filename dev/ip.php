<?php

$ip = $_SERVER['REMOTE_ADDR'];
$ad = gethostbyaddr($_SERVER['REMOTE_ADDR']);

echo 'IP: ' . $ip;
echo '<br/>';
echo 'Endereço: ' . $ad;
