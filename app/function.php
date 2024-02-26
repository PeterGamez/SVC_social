<?php

function views($file, $data = null): void
{
    if ($data) {
        extract($data);
    }

    include __ROOT__ . '/views/' . $file . '.php';
}

function loaddir($path): void
{
    $folders = scandir($path); // ไฟล์ทั้งหมดในโฟลเดอร์
    foreach ($folders as $key => $value) {
        if ($value == '.' || $value == '..') continue;
        if (is_dir($path . '/' . $value)) {
            $files = scandir($path . '/' . $value); // ไฟล์ทั้งหมดในโฟลเดอร์
            foreach ($files as $key => $file) {
                if ($file == '.' || $file == '..') continue;
                if (substr($file, -4) == '.php') { // เฉพาะไฟล์ .php
                    require_once $path . '/' . $value . '/' . $file;
                }
            }
        } else {
            if (substr($value, -4) == '.php') { // เฉพาะไฟล์ .php
                require_once $path . '/' . $value;
            }
        }
    }
}
