<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/\.blade\.php$/');
$count = 0;
foreach($files as $file) {
    $path = $file->getPathname();
    $content = file_get_contents($path);
    $original = $content;
    
    // Replace whole word not-italic and italic
    $content = preg_replace('/\bnot-italic\b/', '', $content);
    $content = preg_replace('/\bitalic\b/', '', $content);
    
    if ($original !== $content) {
        file_put_contents($path, $content);
        $count++;
    }
}
echo "Updated $count files.\n";
