<?php

namespace Tests\Mock;

use App\Interfaces\CountryListInterface;

/**
 * Class MockCountryListService
 *
 * @package App
 */
class MockCountryListService implements CountryListInterface
{
    private $contentAsCsv;
    private $content;

    /**
     * @return array
     */
    public function getListAsArray(): array
    {
        return $this->replaceStringIntoArrayWithValidCountryCodeAndName($this->content);
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param string $content
     *
     * @return array
     */
    public function replaceStringIntoArrayWithValidCountryCodeAndName(
        string $content
    ): array {
        $contentAsArray = explode("\n", $content);

        $countryList = [];
        foreach (array_values($contentAsArray) as $value) {
            // 1 group countryCode ({AA}{SPACE}) 2 group all after space ({.+$})
            $regex = '/(^[A-Z][A-Z])\s(.+$)/s';
            if (preg_match_all($regex, $value, $matches,
                PREG_SET_ORDER)
            ) {
                $countryList[trim($matches[0][1])] = trim($matches[0][2]);
            }
        }

        return $countryList;
    }

    /**
     * Create string csv data
     *
     * @param array $content
     *
     */
    public function createCsv(array $content): void
    {
        $csv = '';
        //headers
        foreach (['Country Code', 'Country Name'] as $header) {
            $csv .= "{$header};";
        }

        $csv = str_replace_last(';', '', $csv);
        $csv .= "\n";
        //contents
        foreach ($content as $key => $value) {
            $csv .= "{$key};{$value}\n";
        }
        $this->contentAsCsv = $csv;
    }

    public function getListAsCsv()
    {
        return $this->contentAsCsv;
    }

}
