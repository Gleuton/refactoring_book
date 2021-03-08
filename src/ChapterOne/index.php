<?php

use Refactoring\ChapterOne\Statement;

require_once __DIR__ . '/../../vendor/autoload.php';

$invoices_file = file_get_contents(__DIR__ . '/json/invoices.json');
$plays_file    = file_get_contents(__DIR__ . '/json/plays.json');

$invoices = json_decode($invoices_file, false);
$plays    = json_decode($plays_file, false);

echo (new Statement())->statement($invoices, $plays);