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

        $transaction_arr = json_decode($transaction, true);
        $result = [];

        foreach ($transaction_arr as $tr) {
            $idx = array_search($tr["account_id"], \array_column($result, "account_id"));
            if ($idx === false) {
                $result[] = $tr;
            } else {
                $result[$idx]["point"] += $tr["point"];
            }
        }


        return \response()->json($result, 201);
    }

    public function print_tabungan(Request $request)
    {
        $start = date_parser($request->start) . " 00:00:00";
        $end = date_parser($request->end) . " 23:59:59";
        $transaction = DB::table("transaksi AS t")
            ->leftJoin("nasabah AS n", "t.user_id", "=", "n.account_id")
            ->select("n.account_id", "n.name", "t.transaction_date", "t.description", "t.type", "t.amount")
            ->where("t.transaction_date", ">=", $start)
            ->where("t.transaction_date", "<=", $end)
            ->where("account_id", $request->user)
            ->get();

        return \response()->json($transaction, 201);
    }
}