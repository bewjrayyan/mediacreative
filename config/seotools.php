<?php
/**
 * @see https://github.com/artesaos/seotools
 *
 * Importers: Artesaos\SEOTools package + SeoManager (runtime overrides).
 * Loaded via config('seotools.*'). Empty defaults — site values from PageSetting.
 * User: "pasang seo tools ini dalam project sekarang https://github.com/artesaos/seotools"
 */

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),
    'meta' => [
        'defaults'       => [
            'title'        => false,
            'titleBefore'  => false,
            'description'  => false,
            'separator'    => ' · ',
            'keywords'     => [],
            'canonical'    => 'current',
            'robots'       => 'index, follow',
        ],
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],
        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        'defaults' => [
            'title'       => false,
            'description' => false,
            'url'         => null,
            'type'        => 'website',
            'site_name'   => false,
            'images'      => [],
        ],
    ],
    'twitter' => [
        'defaults' => [
            'card' => 'summary_large_image',
        ],
    ],
    'json-ld' => [
        'defaults' => [
            'title'       => false,
            'description' => false,
            'url'         => 'current',
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
