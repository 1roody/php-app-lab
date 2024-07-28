<?php

    $controllers_files = scandir('./Controllers');

    foreach($controllers_files as $file) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        require_once './Controllers/' . $file;
    }

    $models_files = scandir('./Models');

    foreach($model_files as $file) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        require_once './Models/' . $file;
    }