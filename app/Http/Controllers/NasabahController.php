<?php

namespace App\Http\Controllers;

use App\Models\NasabahModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NasabahController extends Controller
{
    public function showAllNasabah()
    {
        return \response()->json(NasabahModel::orderBy("account_id", "desc")->get());
    }

    public function nasabahForSelect2(Request $request)
    {
        if ($request->search != "") {
            $nasabah = DB::table('nasabah')
                ->where("name", "like", "%" . $request->search . "%")
                ->get();
        } else {
            $nasabah = NasabahModel::all()->take(10);
        }

        $result = [];
        foreach ($nasabah as $key => $val) {
            $result[$key]["id"] = $val->account_id;
            $result[$key]["text"] = $val->name;
        }

        return \response()->json($result);
    }

    public function insertNasabah(Request $request)
    {
        $nasabah = NasabahModel::create($request->all());
        return \response()->json([
            "status" => "OK"
        ], 201);
    }
}