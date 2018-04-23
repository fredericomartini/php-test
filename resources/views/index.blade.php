@extends('master')
@section('title')
    PHP Test - Using Laravel
@endsection
@section('content')
    <div class="container w-100 p-5" style="background-color: #eee;">
        <div class="bd-example">
            <h3 class="text-center">PHP Test Application</h3>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">Wait for a user action, like clicking buttons. According to these actions
                    some data (see further below) should be:
                </li>
                <li class="list-group-item">- either shown nicely formatted on the screen</li>
                <li class="list-group-item">- or downloaded as CSV file</li>
                <li class="list-group-item">- You can either download the data on each request during the runtime of
                    your
                    PHP program or load the data from a database (in this case do NOT provide a DB dump, but a script
                    which automatically transfers the data from the remote location to the DB)
                </li>
                <li class="list-group-item">- preferably the implementation should be written in "clean code", separate
                    concerns using pattern like
                </li>
                <li class="list-group-item">- MVC</li>
                <li class="list-group-item">- be object oriented, very good testable, best even already contain Unit
                    tests
                    and maybe even follow the KISS and SOLID principles
                </li>
                <li class="list-group-item">- Country List</li>
                <li class="list-group-item">- the data should be a list of countries with their country code</li>
                <li class="list-group-item">- Please download the base data from
                    <a target="_blank" href="https://gist.github.com/ivanrosolen/f8e9e588adf0286e341407aca63b5230">https://gist.github.com/ivanrosolen/f8e9e588adf0286e341407aca63b5230</a>
                </li>
                <li class="list-group-item">- afterwards you will have to change the whole list from "Country code -
                    Country name" to "CountryName -
                    CountryCode" and sorts the list by CountryName
                </li>
            </ul>
            <div class="bd-example text-center">
                <a href="{{ route('country-list')  }}" id="show-content" class="badge open-modal-window"
                   style="width: 100%">
                    <button type="button" class="btn btn-success" style="width: 100%">
                        Show Content
                    </button>
                </a>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    @include('includes.modal-country-list')
@endsection
