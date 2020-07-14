<?php
/**
 * Модифицированный автозагрузчик из документации PSR-4
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'Commentout\\';

    // base directory for the namespace prefix
    $base_dir_list = [
        ROOTPATH . '/app/',
        ROOTPATH . '/app/core/',
        ROOTPATH . '/app/controllers/'
    ];

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file_name = str_replace('\\', '/', $relative_class) . '.php';

    foreach ($base_dir_list as $base_dir) {
        $file = $base_dir . $file_name;
        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        }
    }
});