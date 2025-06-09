<?php
// local/quizreport/access.php
defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'local/quizreport:generate' => [
        'captype'      => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => [
            'manager'  => CAP_ALLOW,
            'teacher'  => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        ],
    ],
];
