<?php

return [

    'user_model' => App\Models\User::class,

    'message_model' => Cmgmyr\Messenger\Models\Message::class,

    'participant_model' => Cmgmyr\Messenger\Models\Participant::class,

    'thread_model' => Cmgmyr\Messenger\Models\Thread::class,

    /**
     * Define custom database table names.
     */

    'messages_table' => "chat_messages",

    'participants_table' => "chat_participants",

    'threads_table' => "chat_threads",
];
