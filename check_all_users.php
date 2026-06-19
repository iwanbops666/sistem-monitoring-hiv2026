<?php
$users = App\Models\User::pluck('email');
print_r($users->toArray());
