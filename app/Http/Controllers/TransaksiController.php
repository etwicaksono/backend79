<?php

namespace App\Http\Controllers;

use App\Models\TransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \response()->json(TransaksiModel::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transaksi = TransaksiModel::create($request->all());
        return \response()->json([
            "recent" => $transaksi,
            "all" => TransaksiModel::all()
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function show_point()
    {
        $transaction = DB::table("transaksi AS t")
            ->leftJoin("nasabah AS n", "t.user_id", "=", "n.account_id")
            ->select("n.account_id", "n.name", "t.transaction_date", "t.description", "t.type", "t.amount")
            ->where("t.type", "=", "D")
            ->whereRaw("TRIM(LOWER(t.description)) LIKE?", ["beli pulsa%"])
            ->orWhere("t.type", "=", "D")
            ->whereRaw("TRIM(LOWER(t.description)) LIKE?", ["bayar listrik%"])
            ->get();

        foreach ($transaction as $tr) {
            $tr->point = get_point($tr->description, $tr->amount);
        }

        return \response()->json($transaction, 201);
    }
}