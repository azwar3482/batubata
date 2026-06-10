<?php
require 'c:/laragon/www/batubata/vendor/autoload.php';
$app = require_once 'c:/laragon/www/batubata/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::whereIn('role', ['industry', 'job_seeker'])->get(['id', 'name', 'email', 'role']);
foreach ($users as $u) {
    echo "ID: {$u->id} | Name: {$u->name} | Email: {$u->email} | Role: {$u->role}\n";
}
