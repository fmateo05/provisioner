<?php

$ua = $_SERVER['HTTP_USER_AGENT'];

$segments = explode(' ', trim($ua, ' '));

$model = $segments['1'];



header("User-Agent: " . $ua );
header("HTTP/1.1 Status: 302 Found");
header("Location: http://portal.bevoip.net/links/y000000000000.boot");

exit();
