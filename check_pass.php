<?php
$user = App\Models\User::where('email', 'pasien1@test.com')->first();
if ($user) {
    echo "User found. Role: " . $user->role . "\n";
    if (\Illuminate\Support\Facades\Hash::check('password', $user->password)) {
        echo "Password matches 'password'.\n";
    } else {
        echo "Password DOES NOT match 'password'. It is hashed as: " . $user->password . "\n";
        // Update it
        $user->password = \Illuminate\Support\Facades\Hash::make('password');
        $user->save();
        echo "Password updated to 'password'.\n";
    }
} else {
    echo "User not found.\n";
}
