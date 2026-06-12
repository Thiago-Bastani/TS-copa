<?php

namespace App\Services;

class PixPayload
{
    public static function static(string $pixKey, float $amount, string $description = ''): string
    {
        $pixKey = trim($pixKey);
        $pixKey = str_replace([' ', '-', '.'], '', $pixKey);
        $merchantName = mb_substr($description ?: 'TS Copa', 0, 25);
        $merchantCity = 'BRASIL';

        $gui     = self::tlv('00', 'BR.GOV.BCB.PIX') . self::tlv('01', $pixKey);
        $payload = self::tlv('00', '01')
            . self::tlv('26', $gui)
            . self::tlv('52', '0000')
            . self::tlv('53', '986')
            . self::tlv('54', number_format($amount, 2, '.', ''))
            . self::tlv('58', 'BR')
            . self::tlv('59', $merchantName)
            . self::tlv('60', $merchantCity)
            . self::tlv('62', self::tlv('05', '***'));

        return $payload . self::tlv('63', self::crc16($payload . '6304'));
    }

    private static function tlv(string $id, string $value): string
    {
        return $id . str_pad(strlen($value), 2, '0', STR_PAD_LEFT) . $value;
    }

    private static function crc16(string $payload): string
    {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($payload); $i++) {
            $crc ^= ord($payload[$i]) << 8;
            for ($j = 0; $j < 8; $j++) {
                $crc = ($crc & 0x8000) ? (($crc << 1) ^ 0x1021) : ($crc << 1);
            }
        }
        return strtoupper(str_pad(dechex($crc & 0xFFFF), 4, '0', STR_PAD_LEFT));
    }
}
