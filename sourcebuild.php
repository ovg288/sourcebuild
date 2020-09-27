<?php

function humanFilesize($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

function appendContent($path)
{
    $data = file_get_contents($path);
    $header = "/*******************************************************************************
 * Filename: " . $path . "
 * Size: " . humanFilesize(filesize($path)) . "
 * Date: " . date('d.m.Y H:i') . "
 *******************************************************************************/\n\n";
    file_put_contents('code.txt', $header, FILE_APPEND);
    file_put_contents('code.txt', $data, FILE_APPEND);
    file_put_contents('code.txt', "\n", FILE_APPEND);
}

function scanDirectory(string $dir, $path = './')
{
    $cPath = $path . $dir;
    $cPath = $dir;
    $dir = scandir($cPath);
    foreach ($dir as $item) {
        if($item === '.' || $item === '..') continue;

        $node = $cPath . '/' . $item;

        print_r($node . "\n");

        if(is_file($node)) {
            appendContent($node);
        }
        if(is_dir($node)) {
            scanDirectory($node, $path);
        }
    }
}

scanDirectory('app');
