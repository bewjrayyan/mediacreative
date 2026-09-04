<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class CurrencyConverter
{
    private const CACHE_KEY = 'currency_rates_usd_v1';

    /** @var array<string, string> */
    private const LOCALE_CURRENCY = [
        'en' => 'USD',
        'ms' => 'MYR',
        'id' => 'IDR',
    ];

    public function currencyForLocale(?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();

        return self::LOCALE_CURRENCY[$locale] ?? 'USD';
    }

    /**
     * Convert an amount stored in USD to the target currency.
     */
    public function convert(float|int|string $amountUsd, ?string $toCurrency = null): float
    {
        $amount = (float) $amountUsd;
        $to = strtoupper($toCurrency ?: $this->currencyForLocale());

        if ($to === 'USD' || $amount === 0.0) {
            return $amount;
        }

        $rate = $this->rateTo($to);

        if ($rate === null) {
            return $amount;
        }

        return $amount * $rate;
    }

    /**
     * Format a USD amount for the current (or given) locale.
     */
    public function format(float|int|string|null $amountUsd, ?string $locale = null): string
    {
        if ($amountUsd === null || $amountUsd === '') {
            return '';
        }

        $locale = $locale ?: app()->getLocale();
        $currency = $this->currencyForLocale($locale);
        $converted = $this->convert($amountUsd, $currency);

        return match ($currency) {
            'MYR' => 'RM '.number_format(round($converted), 0, '.', ','),
            'IDR' => 'Rp '.number_format(round($converted), 0, ',', '.'),
            default => '$'.number_format(round($converted), 0, '.', ','),
        };
    }

    /**
     * @return array<string, float>|null
     */
    public function rates(): ?array
    {
        return Cache::remember(self::CACHE_KEY, now()->addHours(12), function () {
            try {
                $response = Http::timeout(8)
                    ->acceptJson()
                    ->get('https://open.er-api.com/v6/latest/USD');

                if (! $response->successful()) {
                    Log::warning('Currency API HTTP error', ['status' => $response->status()]);

                    return null;
                }

                $payload = $response->json();

                if (($payload['result'] ?? null) !== 'success' || ! is_array($payload['rates'] ?? null)) {
                    Log::warning('Currency API unexpected payload');

                    return null;
                }

                /** @var array<string, float|int|string> $rates */
                $rates = $payload['rates'];

                return array_map(static fn ($rate): float => (float) $rate, $rates);
            } catch (Throwable $e) {
                Log::warning('Currency API failed: '.$e->getMessage());

                return null;
            }
        });
    }

    public function rateTo(string $currency): ?float
    {
        $currency = strtoupper($currency);

        if ($currency === 'USD') {
            return 1.0;
        }

        $rates = $this->rates();

        if ($rates === null || ! isset($rates[$currency])) {
            return null;
        }

        return (float) $rates[$currency];
    }

    public function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
