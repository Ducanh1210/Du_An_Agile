<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use App\Models\User;
use Illuminate\Support\Facades\Hash;
$user = User::where('email', 'admin@gmail.com')->first();
if($user) {
    $user->password = Hash::make('123456');
    $user->save();
    echo "Password for admin@gmail.com has been reset to: 123456\n";
} else {
    echo "Admin user not found.\n";
}
