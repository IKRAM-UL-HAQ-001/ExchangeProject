<?php

namespace App\Exports;

use App\Models\BankBalance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;
use Auth;

class BankBalanceListExport implements FromQuery,  WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $exchangeId;

    public function __construct($exchangeId){
        $this->exchangeId = $exchangeId;
    }

    public function query()
    {
        $currentMonth = Carbon::now()->month;
        $query = BankBalance::selectRaw('
                bank_balances.id, 
                exchanges.name AS exchange_name,
                users.name AS user_name,
                bank_balances.name,
                bank_balances.account_number,
                bank_balances.cash_type,
                bank_balances.cash_amount,
                bank_balances.remarks,
                DATE_FORMAT(CONVERT_TZ(bank_balances.created_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as created_at,
                DATE_FORMAT(CONVERT_TZ(bank_balances.updated_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as updated_at
            ')
            ->join('exchanges', 'bank_balances.exchange_id', '=', 'exchanges.id') // Join with shops
            ->join('users', 'bank_balances.user_id', '=', 'users.id') // Join with users based on user_id
            ->whereMonth('bank_balances.created_at', $currentMonth) 
            ->distinct(); // Ensure unique results
    
        switch (Auth::user()->role) {
            case "exchange":
                return $query->where('bank_balances.exchange_id',$this->exchangeId);
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
            'Bank Name',
            'Account Number',
            'Cash Type',
            'Cash Amount',
            'Remarks',
            'Created At',
            'Updated At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->getFont()->setBold(true); // Bold the header row
        $sheet->getStyle('A1:J1')->getFont()->setSize(12); // Optional: set font size
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 15,
            'D' => 15, 
            'E' => 15, 
            'F' => 15,
            'G' => 15,
            'H' => 30,
            'I' => 30,
            'J' => 30,
        ];
    }
}
