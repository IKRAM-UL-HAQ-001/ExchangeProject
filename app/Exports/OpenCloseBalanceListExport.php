<?php

namespace App\Exports;

use App\Models\OpenCloseBalance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use Auth;

class OpenCloseBalanceListExport implements FromQuery,  WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $exchangeId;

    public function __construct($exchangeId){
        $this->exchangeId = $exchangeId;
    }

    // public function query()
    // {

    //     $currentMonth = Carbon::now()->month; 
    //     $query = OpenCloseBalance::selectRaw('
    //         open_close_balances.id, 
    //         exchanges.name AS name,
    //         users.name AS user_name,
    //         open_close_balances.open_balance,
    //         open_close_balances.close_balance,
    //         open_close_balances.remarks,
    //         DATE_FORMAT(CONVERT_TZ(open_close_balances.created_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as created_at,
    //         DATE_FORMAT(CONVERT_TZ(open_close_balances.updated_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as updated_at
    //     ')
    //     ->join('exchanges', 'open_close_balances.exchange_id', '=', 'exchanges.id')
    //     ->join('users', 'open_close_balances.user_id', '=', 'users.id')
    //     ->whereMonth('open_close_balances.created_at', $currentMonth) 
    //     ->distinct(); // Ensure unique results
    
    //     switch (Auth::user()->role) {
    //         case "exchange":
    //             return $query->where('open_close_balances.exchange_id', $this->exchangeId );
    //         case "admin":
    //             return $query;
    //         case "assistant":
    //             return $query;
    //     }
    // }   
    public function query()
{
    $currentMonth = Carbon::now()->month;

    $query = OpenCloseBalance::selectRaw('
        open_close_balances.id, 
        exchanges.name AS name,
        users.name AS user_name,
        open_close_balances.open_balance,
        open_close_balances.close_balance,
        -- Calculate the total balance
        CASE 
            WHEN @rownum := @rownum + 1 THEN 
                IF(@rownum = 1, 
                    open_close_balances.open_balance + open_close_balances.close_balance, 
                    @prev_total_balance + open_close_balances.close_balance)
            END AS total_balance,
        open_close_balances.remarks,
        DATE_FORMAT(CONVERT_TZ(open_close_balances.created_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as created_at,
        DATE_FORMAT(CONVERT_TZ(open_close_balances.updated_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as updated_at,
        @prev_total_balance := CASE 
            WHEN @rownum = 1 THEN open_close_balances.open_balance + open_close_balances.close_balance 
            ELSE @prev_total_balance + open_close_balances.close_balance 
        END AS prev_total_balance
    ')
    ->join('exchanges', 'open_close_balances.exchange_id', '=', 'exchanges.id')
    ->join('users', 'open_close_balances.user_id', '=', 'users.id')
    ->whereMonth('open_close_balances.created_at', $currentMonth)
    ->distinct()
    ->join(DB::raw('(SELECT @rownum := 0, @prev_total_balance := 0) r'), DB::raw('1'), DB::raw('1')); // Initialize variables

    switch (Auth::user()->role) {
        case "exchange":
            return $query->where('open_close_balances.exchange_id', $this->exchangeId);
        case "admin":
            return $query;
        case "assistant":
            return $query;
    }
}

    
    
    public function headings(): array
    {
        return [
            'ID',
            'Exchange Name',
            'User Name',
            'Open Balance',
            'Close Balance',
            'Total Balance',
            'Remarks',
            'Created At',
            'Updated At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->getFont()->setBold(true); // Bold the header row
        $sheet->getStyle('A1:I1')->getFont()->setSize(12); // Optional: set font size
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 15,
            'D' => 20,
            'E' => 20,
            'F' => 30,
            'G' => 30,
            'H' => 30,
            'I' => 30,
        ];
    }
}