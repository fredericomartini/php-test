<?php

namespace App;

use App\Interfaces\CountryListInterface;
use GuzzleHttp\Client;

/**
 * Class CountryListService
 *
 * @package App
 */
class CountryListService implements CountryListInterface
{
    public $content;
    public $contentAsCsv;

    private $countryListUrl = 'https://gist.githubusercontent.com/fredericomartini/00a0a07406c549261b6faf268625a5d9/raw/99e205ea104190c5e09935f06b19c30c4c0cf17e/country';
    private $http;

    public function __construct()
    {
        $this->http = new Client(['base_uri' => $this->countryListUrl]);
    }

    private function makeRequestAndGetDataFromSource(): void
    {
        $response = $this->http->get($this->countryListUrl);
        $this->setContent((string)$response->getBody()->getContents());
    }

    private function getContent(): string
    {
        if (empty($this->content)) {
            $this->makeRequestAndGetDataFromSource();
        }

        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get the country list as array ['COUNTRY_CODE' => 'COUNTRY_NAME']
     *
     * @return array
     */
    public function getListAsArray(): array
    {
        return $this->replaceStringIntoArrayWithValidCountryCodeAndName($this->getContent());
    }

    /**
     * @param string $content
     *
     * @return array
     */
    private function replaceStringIntoArrayWithValidCountryCodeAndName(
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
     * Create csv data
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

        $csv = str_replace_last(';', "\n", $csv);

        //contents
        foreach ($content as $key => $value) {
            $csv .= "{$key};{$value}\n";
        }
        $this->contentAsCsv = $csv;
    }

    /**
     * Get the csv string
     *
     * @return string
     */
    public function getListAsCsv(): string
    {
        if (empty($this->contentAsCsv)) {
            $this->createCsv($this->getListAsArray());
        }

        return $this->contentAsCsv;
    }


}
