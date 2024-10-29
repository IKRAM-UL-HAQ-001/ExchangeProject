<?php

namespace App\Exports;

use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;

class DepositListExport implements FromCollection,  WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $exchangeId;

    public function __construct($exchangeId)
    {
        $this->exchangeId = $exchangeId;
    }
    // public function query()
    // {
    //     $currentMonth = Carbon::now()->month;
    //     $query = Cash::selectRaw('
    //         cashes.id, 
    //         exchanges.name as name,
    //         users.name as user_name,
    //         cashes.reference_number,
    //         cashes.customer_name,
    //         cashes.cash_type,
    //         cashes.cash_amount,
    //         cashes.bonus_amount,
    //         cashes.payment_type,
    //         cashes.remarks,
    //         DATE_FORMAT(CONVERT_TZ(cashes.created_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as created_at,
    //         DATE_FORMAT(CONVERT_TZ(cashes.updated_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as updated_at
    //     ')
    //     ->join('exchanges', 'cashes.exchange_id', '=', 'exchanges.id') 
    //     ->join('users', 'cashes.user_id', '=', 'users.id') 
    //     ->whereMonth('cashes.created_at', $currentMonth) 
    //     ->where('cashes.cash_type', 'deposit');
       
    //     if (Auth::user()->role == "exchange") {
    //         return $query->where('cashes.exchange_id', $this->exchnageId); // No ->get() here, return the query builder
    //     } elseif (Auth::user()->role == "admin") {
    //         return $query;
    //     }elseif(Auth::user()->role == "assistant"){
    //         return $query;
    //     }
    // }
    public function collection()
{
    $currentMonth = Carbon::now()->month;

    // Fetching the records
    $records = Cash::select('cashes.*', 'exchanges.name AS exchange_name', 'users.name AS user_name')
        ->join('exchanges', 'cashes.exchange_id', '=', 'exchanges.id')
        ->join('users', 'cashes.user_id', '=', 'users.id')
        ->whereMonth('cashes.created_at', $currentMonth)
        ->whereIn('cashes.cash_type', ['deposit', 'withdrawal', 'expense']);

    if (Auth::user()->role === "exchange") {
        $records->where('cashes.exchange_id', $this->exchangeId);
    }

    // Getting the results
    $records = $records->get();

    // Debugging: Check if records are fetched
    if ($records->isEmpty()) {
        throw new \Exception("No records found for the specified conditions.");
    }

    // Calculating total balance in PHP
    $totalBalance = 0;
    foreach ($records as $record) {
        $totalBalance += ($record->cash_type === 'deposit' ? $record->cash_amount : -$record->cash_amount);
        $record->total_balance = $totalBalance; // Assign total balance to each record
    }

    // Filtering for withdrawals
    $withdrawals = $records->filter(function ($record) {
        return $record->cash_type === 'deposit';
    });

    // Debugging: Check filtered withdrawals
    if ($withdrawals->isEmpty()) {
        throw new \Exception("No withdrawal records found.");
    }

    // Return only non-empty records and arrange columns in the desired order
    return $withdrawals->map(function ($record) {
        return [
            'id' => $record->id,
            'exchange_name' => $record->exchange_name,
            'user_name' => $record->user_name,
            'reference_number' => $record->reference_number,
            'customer_name' => $record->customer_name,
            'cash_type' => $record->cash_type,
            'cash_amount' => $record->cash_amount,
            'total_balance' => $record->total_balance,
            'bonus_amount' => $record->bonus_amount,
            'payment_type' => $record->payment_type,
            'remarks' => $record->remarks,
            'created_at' => $record->created_at,
            'updated_at' => $record->updated_at,
        ];
    });
}
    public function headings(): array{
        return [
            'ID',
            'Exchange Name',
            'User Name',
            'Reference Number',
            'Customer Name',
            'Cash Type',
            'Cash Amount',
            'Total Balance',
            'Bonus Amount',
            'Payment Type',
            'Remarks',
            'Created At',
            'Updated At',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->getFont()->setBold(true); // Bold the header row
        $sheet->getStyle('A1:L1')->getFont()->setSize(12); // Optional: set font size
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, 
            'B' => 20, 
            'C' => 15, 
            'D' => 20, 
            'E' => 20, 
            'F' => 20, 
            'G' => 20, 
            'H' => 20,
            'I' => 15,
            'J' => 20,
            'K' => 30,
            'L' => 30,
        ];
    }
}
