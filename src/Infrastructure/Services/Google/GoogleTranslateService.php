<?php

namespace DevFighters\Utils\Infrastructure\Services\Google;

class GoogleTranslateService
{
    public function __construct()
    {
    }

    /**
     * @throws \JsonException
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
            'dt' => 't',
        ];

        $url = 'https://translate.googleapis.com/translate_a/single';
        $url .= '?'.http_build_query($params);

        $response = file_get_contents($url);
        if (false === $response) {
            return null;
        }

        $json = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($json)) {
            return null;
        }

        $firstLevel = $json[0] ?? null;
        if (!is_array($firstLevel)) {
            return null;
        }

        $secondLevel = $firstLevel[0] ?? null;
        if (!is_array($secondLevel)) {
            return null;
        }

        $translatedText = $secondLevel[0] ?? null;

        return is_string($translatedText) ? $translatedText : null;
    }
}
