<?php
require 'vendor/autoload.php';

use lib\Crawler;

$link = next($argv);

$crawler = new Crawler($link);
$crawler->run();