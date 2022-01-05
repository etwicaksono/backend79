<?php

namespace App\Http\Controllers;

use App\Models\NasabahModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class NasabahController extends Controller
{
    public function showAllNasabah(Request $request)
    {
        // return \response()->json(NasabahModel::orderBy("account_id", "desc")->get());
        $data = NasabahModel::orderBy("account_id", "desc")->get();
        \dd($data);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function nasabahForSelect2(Request $request)
    {
        if ($request->search != "") {
            $nasabah = DB::table('nasabah')
                ->where("name", "like", "%" . $request->search . "%")
                ->orderBy("name", "asc")
                ->get();
        } else {
            $nasabah = NasabahModel::orderBy("name", "asc")->get()->take(10);
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
        NasabahModel::create($request->all());
        return \response()->json([
            "status" => "OK"
        ], 201);
    }
}