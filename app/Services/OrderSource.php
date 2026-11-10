<?php

namespace App\Services;

use Illuminate\Http\Request;

final class OrderSource
{
    public const TELEGRAM = 'telegram';
    public const MAX = 'max';
    public const ANDROID = 'android';
    public const IOS = 'ios';
    public const WEBSITE = 'website';

    private const LABELS = [
        self::TELEGRAM => 'Telegram-бот',
        self::MAX => 'MAX-бот',
        self::ANDROID => 'Android-приложение',
        self::IOS => 'iOS-приложение',
        self::WEBSITE => 'Сайт',
    ];

    public static function resolve(Request $request, ?string $legacyBotName = null): string
    {
        $detectedSource = self::normalize(
            $request->cookie('order_source')
                ?? $request->session()->get('order_source')
        );

        if ($detectedSource && $detectedSource !== self::WEBSITE) {
            return $detectedSource;
        }

        if (filled($legacyBotName)) {
            return self::TELEGRAM;
        }

        return $detectedSource ?? self::WEBSITE;
    }

    public static function normalize(?string $source): ?string
    {
        if (! is_string($source)) {
            return null;
        }

        $source = strtolower(trim($source));

        $aliases = [
            'telegram_bot' => self::TELEGRAM,
            'tg' => self::TELEGRAM,
            'max_bot' => self::MAX,
            'android_app' => self::ANDROID,
            'ios_app' => self::IOS,
            'iphone' => self::IOS,
            'app_store' => self::IOS,
            'rustore' => self::ANDROID,
            'web' => self::WEBSITE,
            'site' => self::WEBSITE,
        ];

        $source = $aliases[$source] ?? $source;

        return array_key_exists($source, self::LABELS) ? $source : null;
    }

    public static function label(?string $source): string
    {
        $normalized = self::normalize($source);

        if ($normalized) {
            return self::LABELS[$normalized];
        }

        if (is_string($source) && self::looksLikeLegacyTelegramSource($source)) {
            return self::LABELS[self::TELEGRAM];
        }

        return filled($source) ? (string) $source : 'Не определён';
    }

    private static function looksLikeLegacyTelegramSource(string $source): bool
    {
        $source = strtolower($source);

        return str_contains($source, 'telegram')
            || str_contains($source, 'opt03')
            || str_starts_with($source, 'tg_');
    }
}
