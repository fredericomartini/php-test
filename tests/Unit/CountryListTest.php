<?php

namespace Tests\Unit;

use App\CountryListService;
use GuzzleHttp\Client;
use Tests\TestCase;

class CountryListTest extends TestCase
{
    private $http;
    private $countryListUrl = 'https://gist.githubusercontent.com/fredericomartini/00a0a07406c549261b6faf268625a5d9/raw/99e205ea104190c5e09935f06b19c30c4c0cf17e/country';
    private $contentProvide
                            = "This list obtained from
http://www.umass.edu/microbio/rasmol/country-.txt

AD   Andorra
AE   United Arab Emirates
AF   Afghanistan
VI   Virgin Islands (U.S.)";

    public function setUp()
    {
        parent::setUp();
        $this->http = new Client(['base_uri' => 'http://httpbin.org']);
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->http = null;
    }

    /**
     * @test
     */
    public function resourceIsAvailable()
    {
        $response = $this->http->get($this->countryListUrl);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function resourceHasData()
    {
        $response = $this->http->get($this->countryListUrl);
        $this->assertContains('This list obtained from',
            (string)$response->getBody());
    }

    /**
     * @test
     */
    public function dataAsArrayWithValidCountryCodeAndName()
    {
        $countryListService = new CountryListService();

        $expeted = [
            'AD' => 'Andorra',
            'AE' => 'United Arab Emirates',
            'AF' => 'Afghanistan',
            'VI' => 'Virgin Islands (U.S.)',
        ];

        $countryListService->setContent($this->contentProvide);
        $validArray = $countryListService->getListAsArray();
        $this->assertSame($expeted, $validArray);
    }

    /**
     * @test
     */
    public function canCreateCsv()
    {
        $expected
            = "Country Code;Country Name\nAD;Andorra\nAE;United Arab Emirates\nAF;Afghanistan\nVI;Virgin Islands (U.S.)\n";

        $countryListService = new CountryListService();
        //create csv from $provide
        $countryListService->setContent($this->contentProvide);
        $generated = $countryListService->getListAsCsv();
        $this->assertSame($expected, $generated);
    }

    /**
     * @test
     */
    public function canDownloadCsv()
    {
        $response = $this->get('/download-csv');
        $response->assertHeader('Content-type', 'text/csv;charset=UTF-8');
        $response->assertHeader('Content-Disposition',
            'attachment;filename=countryList.csv');
        $response->assertHeader('Expires', '0');
        $response->assertHeader('Pragma', 'public');
    }

}
