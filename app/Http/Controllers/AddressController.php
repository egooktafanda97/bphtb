<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class AddressController extends Controller
{
    public function getProvinces()
    {
        return Province::orderBy('name')->get();
    }

    public function getCities(Request $request)
    {
        $provinceCode = $request->province_code;

        return City::where('province_code', $provinceCode)->orderBy('name')->get();
    }

    public function getDistricts(Request $request)
    {
        $cityCode = $request->city_code;

        return District::where('city_code', $cityCode)->orderBy('name')->get();
    }

    public function getVillages(Request $request)
    {
        $districtCode = $request->district_code;

        return Village::where('district_code', $districtCode)->orderBy('name')->get();
    }
}
