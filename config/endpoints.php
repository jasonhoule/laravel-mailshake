<?php

return [
    'base' => 'https://api.mailshake.com/2017-04-01/',

    'activity' => [
        'sent'                => 'activity/sent',
        'opens'               => 'activity/opens',
        'clicks'              => 'activity/clicks',
        'replies'             => 'activity/replies',
        'created-leads'       => 'activity/created-leads',
        'lead-status-changes' => 'activity/lead-status-changes',
    ],

    'campaign' => [
        'list'          => 'campaigns/list',
        'get'           => 'campaigns/get',
        'create'        => 'campaigns/create',
        'pause'         => 'campaigns/pause',
        'unpause'       => 'campaigns/unpause',
        'export'        => 'campaigns/export',
        'export-status' => 'campaigns/export-status',
    ],

    'leads' => [
        'list'   => 'leads/list',
        'get'    => 'leads/get',
        'create' => 'leads/create',
        'close'  => 'leads/close',
        'ignore' => 'leads/ignore',
        'reopen' => 'leads/reopen',
    ],

    'me' => 'me',

    'push' => [
        'create' => 'push/create',
        'delete' => 'push/delete',
    ],

    'recipients' => [
        'add'         => 'recipients/add',
        'add-status'  => 'recipients/add-status',
        'list'        => 'recipients/list',
        'get'         => 'recipients/get',
        'pause'       => 'recipients/pause',
        'unpause'     => 'recipients/unpause',
        'unsubscribe' => 'recipients/unsubscribe',
    ],

    'senders' => [
        'list' => 'senders/list',
    ],

    'team' => [
        'list-members' => 'team/list-members',
    ],
];
