<?php

$adminEmails = explode(',', env('FILAMENT_ADMIN_EMAILS', 'roshangauchan.thakali01@gmail.com'));

return [
    'admin_emails' => array_values(array_filter(array_map(
        static fn (string $email): string => strtolower(trim($email)),
        $adminEmails
    ))),
];
