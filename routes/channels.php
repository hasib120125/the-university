<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});*/

Broadcast::channel('counter', function ($user) {
    return [
        'id' => $user->id,
        'name' => $user->name_hangul ?: 'Admin',
        'student_no' => $user->student_no ?: '',
        'watched_from' => \Carbon\Carbon::now()->format('h:i:s A')
    ];
});
