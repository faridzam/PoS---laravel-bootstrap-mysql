<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\deposit;
use App\Models\invoice;
use App\Http\Controllers;
use App\Models\penjualan;
use Illuminate\Support\Str;
use Mike42\Escpos\Printer; 
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;



class PrintController extends Controller
{
    public function printInvoice(Request $request){

        $invoice = invoice::all();
        $lateinv = DB::table('invoices')->latest('created_at')->first();
        $penjualan = penjualan::all();
        $latest = DB::table('penjualans')->latest('created_at')->first();

        if(!$penjualan->count() !== 0) {
            $dtn = $latest->t_id;
            $pesananBaru = DB::table('penjualans')->where('t_id', '=', $dtn)->get();
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
        $tax_percentage = 0;
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


    //DEPOSIT
    public function printDeposit(deposit $deposit){
        $deposit = deposit::orderBy('created_at', 'desc')->get();

        function addSpaces($string = '', $valid_string_length = 0) {
            if (strlen($string) < $valid_string_length) {
                $spaces = $valid_string_length - strlen($string);
                for ($index1 = 1; $index1 <= $spaces; $index1++) {
                    $string = $string . ' ';
                }
            }
        
            return $string;
        }

        try {
            $connector = new NetworkPrintConnector("10.59.151.245", 9100);
            
            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);

            $printer->feed();
            $printer->setPrintLeftMargin(0);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(true);
            $printer->text(addSpaces('TANGGAL', 25) . addSpaces('ID', 15) . addSpaces('DEPOSIT', 8) . "\n");
            $printer->setEmphasis(false);
            
            foreach ($deposit as $item) {
                
                //Current item ROW 1
                $name_lines = str_split($item['created_at'], 20);
                foreach ($name_lines as $k => $l) {
                    $l = trim($l);
                    $name_lines[$k] = addSpaces($l, 26);
                }
            
                $qtyx_price = str_split($item['id'], 15);
                foreach ($qtyx_price as $k => $l) {
                    $l = trim($l);
                    $qtyx_price[$k] = addSpaces($l, 15);
                }
            
                $total_price = str_split($item['nominal'], 8);
                foreach ($total_price as $k => $l) {
                    $l = trim($l);
                    $total_price[$k] = addSpaces($l, 8);
                }
            
                $counter = 0;
                $temp = [];
                $temp[] = count($name_lines);
                $temp[] = count($qtyx_price);
                $temp[] = count($total_price);
                $counter = max($temp);
            
                for ($i = 0; $i < $counter; $i++) {
                    $line = '';
                    if (isset($name_lines[$i])) {
                        $line .= ($name_lines[$i]);
                    }
                    if (isset($qtyx_price[$i])) {
                        $line .= ($qtyx_price[$i]);
                    }
                    if (isset($total_price[$i])) {
                        $line .= ($total_price[$i]);
                    }
                    $printer->text($line . "\n");
                }
            }

            $printer -> cut();
            $printer->pulse();
            $printer->close();

        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }

        return redirect('/dashboardDeposit');
        
    }



    //CLOSED ORDER
    public function printClosed(deposit $deposit, invoice $invoice){

        $deposit = deposit::whereDate('created_at', Carbon::today())->get();
        $invoice = invoice::whereDate('created_at', Carbon::today())->get();

        function addSpaces($string = '', $valid_string_length = 0) {
            if (strlen($string) < $valid_string_length) {
                $spaces = $valid_string_length - strlen($string);
                for ($index1 = 1; $index1 <= $spaces; $index1++) {
                    $string = $string . ' ';
                }
            }
        
            return $string;
        }

        try {
            $connector = new NetworkPrintConnector("10.59.151.245", 9100);
            
            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);

            $printer->feed();
            $printer->setPrintLeftMargin(0);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(true);
            $printer->text(addSpaces('TANGGAL', 23) . addSpaces('ID', 11) . addSpaces('Pemasukan', 8) . "\n");
            $printer->setEmphasis(false);
            
            foreach ($invoice as $item) {
                
                //Current item ROW 1
                $tang = str_split($item['created_at'], 20);
                foreach ($tang as $k => $l) {
                    $l = trim($l);
                    $tang[$k] = addSpaces($l, 25);
                }
            
                $ids = str_split($item['id'], 10);
                foreach ($ids as $k => $l) {
                    $l = trim($l);
                    $ids[$k] = addSpaces($l, 10);
                }
            
                $pric = str_split($item['tagihan'], 8);
                foreach ($pric as $k => $l) {
                    $l = trim($l);
                    $pric[$k] = addSpaces($l, 8);
                }
            
                $counter = 0;
                $temp = [];
                $temp[] = count($tang);
                $temp[] = count($ids);
                $temp[] = count($pric);
                $counter = max($temp);
            
                for ($i = 0; $i < $counter; $i++) {
                    $line = '';
                    if (isset($tang[$i])) {
                        $line .= ($tang[$i]);
                    }
                    if (isset($ids[$i])) {
                        $line .= ($ids[$i]);
                    }
                    if (isset($pric[$i])) {
                        $line .= ($pric[$i]);
                    }
                    $printer->text($line . "\n");
                }
            }
            
            $printer ->cut();
            $printer->pulse();
            $printer->close();

        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            
        }

        return redirect('dashboardDeposit');
        
    }

    
}