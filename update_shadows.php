<?php
$files = [
    "C:/laragon/www/batubata/resources/views/admin/tpa/dashboard.blade.php",
    "C:/laragon/www/batubata/resources/views/education/dashboard.blade.php",
    "C:/laragon/www/batubata/resources/views/industry/dashboard.blade.php",
    "C:/laragon/www/batubata/resources/views/teacher/dashboard.blade.php",
    "C:/laragon/www/batubata/resources/views/dashboard.blade.php"
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // 1. Colored shadow cards
        $content = preg_replace_callback(
            '/class="([^"]*?shadow-md[^"]*?border-l-([a-z]+)-500[^"]*?hover:shadow-lg[^"]*?)"/s',
            function ($matches) {
                $cls = $matches[1];
                $color = $matches[2];
                $cls = str_replace('shadow-md', "shadow-$color-500/20 dark:shadow-$color-500/20", $cls);
                $cls = str_replace('hover:shadow-lg', "hover:shadow-xl hover:shadow-$color-500/40", $cls);
                return 'class="' . $cls . '"';
            },
            $content
        );

        // 2. Other shadow-md cards
        $content = preg_replace_callback(
            '/class="([^"]*?shadow-md[^"]*?)"/s',
            function ($matches) {
                $cls = $matches[1];
                $cls = str_replace('shadow-md', 'shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50', $cls);
                return 'class="' . $cls . '"';
            },
            $content
        );

        // 3. Admin-like standard cards
        $content = preg_replace('/shadow-lg\s+shadow-gray-500\/5/s', 'shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50', $content);
        
        // 4. System Health card
        $content = str_replace('shadow-xl p-8 text-white relative', 'shadow-xl shadow-indigo-500/30 dark:shadow-indigo-900/50 p-8 text-white relative', $content);

        file_put_contents($file, $content);
        echo "Updated $file\n";
    }
}
