
<?php

spl_autoload_register(function ($class) {
    $directories = [
        __DIR__ . '/../config/',
        __DIR__ . '/',
        __DIR__ . '/../models/',
        __DIR__ . '/../controllers/',
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
