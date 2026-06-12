<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$ids = Illuminate\Support\Facades\DB::table('teacher_classes')->pluck('id')->toArray();
echo 'Class IDs: ' . implode(', ', $ids) . "\n";
$lastId = Illuminate\Support\Facades\DB::table('teacher_classes')->max('id');
echo 'Last class ID: ' . $lastId . "\n";
