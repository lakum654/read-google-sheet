<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Service;
use App\Services\GoogleSheet;

class GoogleSheetController extends Controller
{
    public function index(){
        $sheet = new GoogleSheet();
        $data = $sheet->readGoogleSheet();
        $result = collect($data);

        return view('googleSheet.index',compact('result'));

    }

    public function create()
    {
        return view('googleSheet.form');
    }

    public function store(Request $request)
    {
        $sheet = new GoogleSheet();
        $data = [
            [random_int(1,10000),$request->username,$request->project,$request->date,$request->time]
        ];
        $sheet->saveDataToSheet($data);
        return redirect('google-sheet');
    }
}
