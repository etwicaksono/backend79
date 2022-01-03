<?php

namespace App\Http\Controllers;

use App\Models\NasabahModel;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    public function showAllNasabah()
    {
        return \response()->json(NasabahModel::all());
    }

    public function insertNasabah(Request $request)
    {
        $nasabah = NasabahModel::create($request->all());
        return \response()->json([
            "self" => $nasabah,
            "all" => NasabahModel::all()
        ], 201);
    }
}