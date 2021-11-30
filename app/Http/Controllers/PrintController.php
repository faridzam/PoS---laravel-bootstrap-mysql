<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Http\Controllers;
use App\Models\penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

class PrintController extends Controller
{
    public function print(Request $request){

        $invoice = invoice::all();
        $lateinv = DB::table('invoices')->latest('created_at')->first();
        $penjualan = penjualan::all();
        $latest = DB::table('penjualans')->latest('created_at')->first();

        if(!$penjualan->count() !== 0) {
            $dtn = $latest->created_at;
            $pesananBaru = DB::table('penjualans')->where('created_at', '=', $dtn)->get();
            $hartot = $pesananBaru->sum('jumlah');
        } else {
            $pesananBaru = $penjualan;
            $hartot = $pesananBaru->sum('jumlah');
        }

        // Set params
        $mid = $latest->id;
        $store_name = 'SALOKA';
        $store_address = 'Semarang';
        $store_phone = '08987654321';
        $store_email = 'admin@salokapark.com';
        $store_website = 'salokapark.com';
        $tax_percentage = 10;
        $transaction_id = $dtn;

        // Set items
        $jsons = $lateinv->penjualan;
        $items = json_decode($jsons, true);

        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['nama_produk'],
                $item['harga_produk'],
                $item['kuantitas'],
                $item['jumlah']
            );
        }
        // Set tax
        $printer->setTax($tax_percentage);

        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set qr code
        $printer->setQRcode([
            'tid' => $transaction_id,
        ]);

        // Print receipt
        $printer->printReceipt();

        return redirect('/dashboardPenjualan');
    }
}