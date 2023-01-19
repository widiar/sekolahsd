<?php

namespace app\Http\Controllers\General;

use app\Models\mCity;
use app\Models\mSubdistrict;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;


class General extends Controller
{

    function city_list(Request $request)
    {
        $id_province = $request->id_province;

        $city = mCity::select(['id_city AS id', 'city_name AS text'])->where('id_province', $id_province)->orderBy('city_name', 'ASC')->get();

        $data_city = [];
        $data_city[] = [
            'id' => '',
            'text' => 'Pilih Kabupaten'
        ];

        foreach ($city as $row) {
            $data_city[] = $row;
        }


        return [
            'data' => $data_city
        ];

    }

    function subdistrict_list(Request $request)
    {
        $id_city = $request->id_city;

        $subdistrict = mSubdistrict::select(['id_subdistrict AS id', 'subdistrict_name AS text'])->where('id_city', $id_city)->orderBy('subdistrict_name', 'ASC')->get();
        $data_subdistrict = [];
        $data_subdistrict[] = [
            'id' => '',
            'text' => 'Pilih Kecamatan'
        ];


        return [
            'data' => $subdistrict
        ];

    }

    function cetak_pdf(Request $request)
    {
        $view = $request->input('view');

        $data = [
            'view' => $view
        ];

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('general/tempPdf', $data);

        return $pdf
            ->setPaper('A4', 'portrait')
            ->stream('Payment Print');
    }

}
