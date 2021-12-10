<?php

namespace App\Http\Controllers;

use Session;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PrescriptionController extends Controller
{
    public function index()
    {
        $medicines = DB::table('obatalkes_m')->paginate(10);

        return view('index', ['medicines'=> $medicines]);
    }

    public function indexTransactions()
    {
        $transactions = DB::table('receipt_t')->paginate(10);

        return view('transactions_index', ['transactions'=> $transactions]);
    }

    public function detailTransactions($id)
    {
        $receipt = DB::table('receipt_t')->find($id);

        $medicines = DB::table('obat_receipt_t as or')
        ->join('obatalkes_m as o', 'or.medicine_id', '=', 'o.obatalkes_id')
        ->join('signa_m as s', 'or.signa_id', '=', 's.signa_id')
        ->selectRaw('o.obatalkes_nama as medicine_name, o.obatalkes_kode as medicine_code, or.quantity as qty, s.signa_kode as signa_code, s.signa_nama as signa_name')
        ->where('receipt_id', $id)
        ->get();

        if($receipt->is_racikan == 1){
            foreach($medicines as $med){
                $signa = $med->signa_name;
            }
        }else{
            $signa = null;
        }

        return view('transactions_detail', ['receipt'=> $receipt, 'medicines' => $medicines, 'signa' => $signa]);
    }

    public function exportPdf($id)
    {
        $receipt = DB::table('receipt_t')->find($id);

        $medicines = DB::table('obat_receipt_t as or')
        ->join('obatalkes_m as o', 'or.medicine_id', '=', 'o.obatalkes_id')
        ->join('signa_m as s', 'or.signa_id', '=', 's.signa_id')
        ->selectRaw('o.obatalkes_nama as medicine_name, o.obatalkes_kode as medicine_code, or.quantity as qty, s.signa_kode as signa_code, s.signa_nama as signa_name')
        ->where('receipt_id', $id)
        ->get();

        if($receipt->is_racikan == 1){
            foreach($medicines as $med){
                $signa = $med->signa_name;
            }
        }else{
            $signa = null;
        }

        // $pdf = PDF::loadView('transactions_pdf', $data);

        // return $pdf->download('tutsmake.pdf');

        $pdf = PDF::loadview('transactions_pdf', ['receipt'=>$receipt, 'medicines'=>$medicines, 'signa'=>$signa])->setPaper('A4', 'potrait');
        return $pdf->download('tutsmake.pdf');
    }

    public function createReceiptNonCombine()
    {
        $medicines = DB::table('obatalkes_m')->get();
        $signas = DB::table('signa_m')->get();

        return view('create_receipt', ['medicines'=> $medicines, 'signas' => $signas]);
    }

    public function createReceiptCombine()
    {
        $medicines = DB::table('obatalkes_m')->get();
        $signas = DB::table('signa_m')->get();

        return view('create_receipt_combine', ['medicines'=> $medicines, 'signas' => $signas]);
    }

    public function storeReceipt(Request $request)
    {
        $trans_number = "TR" . random_int(100000, 999999);
        $customer_name = $request->customer_name;

        $medicines = $request->medicines;
        $quantity = $request->qty;
        $signas = $request->signas;

        for($i = 0; $i < count($medicines); $i++){
            $stock = DB::table('obatalkes_m')
            ->where('obatalkes_id', $medicines[$i])
            ->pluck('stok');

            if($stock[0] < $quantity[$i]){
                $name = DB::table('obatalkes_m')
                ->where('obatalkes_id', $medicines[$i])
                ->pluck('obatalkes_nama');


                Session::flash('fail', 'Obat/alkes '. $name[0] . ' kekurangan stok');
                return redirect()->route('create.resep.non.racikan');
            }

            $qty_reduced = $stock[0] - $quantity[$i];

            $quantity_data[] = array(
                'stok' => $qty_reduced,
                'last_modified_date' => now()
            );

            $data = array(
                "customer_name" => $customer_name,
                "is_racikan" => 0,
                "transaction_number" => $trans_number,
                "created_at" => now(),
            );

            $data_pivot[] = array(
                "medicine_id" => $medicines[$i],
                "signa_id" => $signas[$i],
                "quantity" => $quantity[$i],
            );
        }

        $id = DB::table('receipt_t')->insertGetId($data);

        for($i = 0; $i < count($data_pivot); $i++){
            $data_pivot[$i] = array(
                "medicine_id" => $data_pivot[$i]['medicine_id'],
                "signa_id" => $data_pivot[$i]['signa_id'],
                "quantity" => $data_pivot[$i]['quantity'],
                "receipt_id" => $id,
                "created_at" => now(),
            );
        }

        DB::table('obat_receipt_t')->insert($data_pivot);

        for($i = 0; $i < count($quantity_data); $i++){
            DB::table('obatalkes_m')
            ->where('obatalkes_id', $medicines[$i])
            ->update($quantity_data[$i]);
        }

        Session::flash('success', 'Transaksi resep berhasil disimpan!');
        return redirect()->route('detail.transaksi', ['id'=>$id]);
    }

    public function storeReceiptCombine(Request $request)
    {
        $trans_number = "TR" . random_int(100000, 999999);
        $customer_name = $request->customer_name;
        $combine_name = $request->combine_name;

        $medicines = $request->medicines;
        $quantity = $request->qty;
        $signa = $request->signa;

        for($i = 0; $i < count($medicines); $i++){
            $stock = DB::table('obatalkes_m')
            ->where('obatalkes_id', $medicines[$i])
            ->pluck('stok');

            if($stock[0] < $quantity[$i]){
                $name = DB::table('obatalkes_m')
                ->where('obatalkes_id', $medicines[$i])
                ->pluck('obatalkes_nama');

                Session::flash('fail', 'Obat/alkes '. $name[0] . ' kekurangan stok');
                return redirect()->route('create.resep.racikan');
            }

            $qty_reduced = $stock[0] - $quantity[$i];

            $quantity_data[] = array(
                'stok' => $qty_reduced,
                'last_modified_date' => now()
            );

            $data = array(
                "customer_name" => $customer_name,
                "combine_name" => $combine_name,
                "is_racikan" => 1,
                "transaction_number" => $trans_number,
                "created_at" => now(),
            );

            $data_pivot[] = array(
                "medicine_id" => $medicines[$i],
                "signa_id" => $signa,
                "quantity" => $quantity[$i],
            );
        }

        $id = DB::table('receipt_t')->insertGetId($data);

        for($i = 0; $i < count($data_pivot); $i++){
            $data_pivot[$i] = array(
                "medicine_id" => $data_pivot[$i]['medicine_id'],
                "signa_id" => $data_pivot[$i]['signa_id'],
                "quantity" => $data_pivot[$i]['quantity'],
                "receipt_id" => $id,
                "created_at" => now(),
            );
        }

        DB::table('obat_receipt_t')->insert($data_pivot);

        for($i = 0; $i < count($quantity_data); $i++){
            DB::table('obatalkes_m')
            ->where('obatalkes_id', $medicines[$i])
            ->update($quantity_data[$i]);
        }

        Session::flash('success', 'Transaksi resep berhasil disimpan!');
        return redirect()->route('detail.transaksi', ['id'=>$id]);
    }
}
