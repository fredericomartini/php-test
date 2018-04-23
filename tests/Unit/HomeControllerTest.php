<?php

namespace Tests\Unit;

use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * @test
     */
    public function visitIndexAndSeeHomeInfo()
    {
        $response = $this->get('/');

        $response->assertSeeText('PHP Test Application');
    }


    /**
     * Show button user's action
     *
     * @test
     */
    public function visitIndexAndSeeShowContentButton()
    {
        $response = $this->get('/');

        $response->assertSee('<button type="button" class="btn btn-success" style="width: 100%">
                        Show Content
                    </button>');
    }

    /**
     * @test
     */
    public function routeToCountryListAvailable()
    {
        $response = $this->get('/country-list');
        // Route available
        $response->assertStatus(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function routeToDownloadCountryListCsv()
    {
        $response = $this->get('/download-csv');
        // Route available
        $response->assertStatus(200, $response->getStatusCode());
    }

}
