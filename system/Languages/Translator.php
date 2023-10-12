<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Languages;

class Translator
{
    private string $language;
    private array $translations;

    /**
     * Translate constructor.
     *
     * @param string $language The language code (e.g., 'en') for translations.
     */
    public function __construct(string $language = 'en')
    {
        $this->language = $language;
        $this->translations = $this->loadTranslations();
    }

    /**
     * Load translations from language files.
     *
     * @return array An array of translations.
     */
    private function loadTranslations(): array
    {
       // $lanDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . "Local" . DIRECTORY_SEPARATOR . "{$this->language}.json";
        $lanDir = __DIR__  . DIRECTORY_SEPARATOR . "Local" . DIRECTORY_SEPARATOR . "{$this->language}.json";
        if (file_exists($lanDir)) {
            $fileContents = file_get_contents($lanDir);
            return json_decode($fileContents, true);
        } else {
            return [];
        }
    }

    /**
     * Get the translated string for a given key.
     *
     * @param mixed  $key      The key for the translation.
     * @param string $fallback A fallback string if the translation is not found.
     *
     * @return string The translated string or the fallback string if no translation is found.
     */
    public function get(mixed $key, string $fallback = ''): string
    {
        if (isset($this->translations[$key])) {
            return $this->translations[$key];
        } elseif (!empty($fallback)) {
            return $fallback;
        } else {
            return "No matching translation found for: {$key}";
        }
    }
}
