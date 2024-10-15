<?php

namespace App\Services;

class DataProcessor
{
    public static function sanitize(array $payload): array
    {
        if (isset($payload['email'])) {
            $payload['email'] = '_SENSITIVE_DATA_REMOVED_';
        }

        return $payload;
    }

    public static function isValid(array $data): bool
    {
        return !empty($data['source']) && is_array($data['payload']) && !empty($data['payload']);
    }
}
