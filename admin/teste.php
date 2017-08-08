<?php

$data = '12/08/2017';
$pivot = new DateTime();
$hora = $pivot->format('H:i:s');

echo date('Y-m-d H:i:s', strtotime("$data $hora"));