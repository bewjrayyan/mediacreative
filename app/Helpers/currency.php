<?php

use App\Services\CurrencyConverter;

if (! function_exists('format_price')) {
    /**
     * Format a USD-stored price in the visitor's locale currency (live FX rates).
     */
    function format_price(float|int|string|null $amountUsd, ?string $locale = null): string
    {
        return app(CurrencyConverter::class)->format($amountUsd, $locale);
    }
}
