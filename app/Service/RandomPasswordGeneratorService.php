<?php

namespace App\Service;

class RandomPasswordGeneratorService
{
    public static function generateRandomString(int $length = 16): string
    {
        if ($length < 8) {
            throw new \InvalidArgumentException("La longueur doit être >= 8 caractères.");
        }
        $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';
        $max = strlen($alphabet) - 1;
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            // random_int() est cryptographiquement sûr (CSPRNG)
            $string .= $alphabet[random_int(0, $max)];
        }
        return $string;
    }
}
