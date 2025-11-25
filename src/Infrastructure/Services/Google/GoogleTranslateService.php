<?php

namespace DevFighters\Utils\Infrastructure\Services\Google;

use JsonException;

class GoogleTranslateService
{

    public function __construct()
    {
    }

    /**
     * @throws JsonException
     */
    public function translate(
        string $text,
        string $sourceLang,
        string $targetLang): ?string
    {

        $params = [
            'q' => $text,
            'sl' => $sourceLang,
            'tl' => $targetLang,
            'client' => 'gtx',
            'dt' => 't'
        ];

        $url = 'https://translate.googleapis.com/translate_a/single';
        $url .= '?' . http_build_query($params);

        $response = file_get_contents($url);
        if ($response === false) {
            return null;
        }

        $json = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        return $json[0][0][0] ?? null;
    }

}