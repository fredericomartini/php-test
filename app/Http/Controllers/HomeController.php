<?php

namespace App\Http\Controllers;

use App\Interfaces\CountryListInterface;

class HomeController extends Controller
{
    private $countryListObj;

    public function __construct(CountryListInterface $countryList)
    {
        $this->countryListObj = $countryList;
    }

    public function index()
    {
        return view('index');
    }

    public function countryList()
    {
        $countryList = $this->countryListObj->getListAsArray();

        return view('country-list', compact('countryList'));
    }

    public function downloadCsv()
    {
        $csv = $this->countryListObj->getListAsCsv();

        return response()->stream(function () use ($csv) {
            echo $csv;
        }, 200, [
            'Content-type'        => 'text/csv;charset=UTF-8',
            'Content-Disposition' => 'attachment;filename=countryList.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        ]);
    }
}
