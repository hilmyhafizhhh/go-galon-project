<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


// Broadcast::channel('chat.{id1}.{id2}', function ($user, $id1, $id2) {
//     return in_array($user->id, [(int)$id1, (int)$id2]);
// });

// Broadcast::channel('chat.{id1}.{id2}', function ($user, $id1, $id2) {
//     logger('Broadcast Auth User:', [$user]);
//     return true;
// });

// Broadcast::channel('chat.{id1}.{id2}', function ($user, $id1, $id2) {
//     if (!$user) {
//         return false;
//     }

//     return (int) $user->id === (int) $id1
//         || (int) $user->id === (int) $id2;
// });

Broadcast::channel('chat.{userA}.{userB}', function ($user, $userA, $userB) {
    return (int)$user->id === (int)$userA
        || (int)$user->id === (int)$userB;
});
