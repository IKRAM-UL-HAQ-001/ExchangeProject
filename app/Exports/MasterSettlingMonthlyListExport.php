<?php

namespace App\Exports;

use App\Models\MasterSettling;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;
use Auth;

class MasterSettlingMonthlyListExport implements FromQuery,  WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $exchangeId;

    public function __construct($exchangeId){
        $this->exchangeId = $exchangeId;
    }
    public function query()
    {
        $currentMonth = Carbon::now()->month; 
    
        $query = MasterSettling::selectRaw('
                master_settlings.id, 
                exchanges.name AS name,
                users.name AS name,
                master_settlings.white_label,
                master_settlings.credit_reff,
                master_settlings.settling_point,
                master_settlings.price,
                master_settlings.total_amount,
                DATE_FORMAT(CONVERT_TZ(master_settlings.created_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as created_at,
                DATE_FORMAT(CONVERT_TZ(master_settlings.updated_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as updated_at
            ')
            ->join('exchanges', 'master_settlings.exchange_id', '=', 'exchanges.id')
            ->join('users', 'master_settlings.user_id', '=', 'users.id') // Join with users based on user_id
            ->whereMonth('master_settlings.created_at', $currentMonth) // Filter by today's date
            ->where('master_settlings.exchange_id', $this->exchangeId)
            ->distinct(); // Ensure unique results
        return $query;
     }
        
    public function headings(): array
    {
        return [
            'ID',
            'Exchange Name',
            'User Name',
            'White Label',
            'Credit Reff',
            'Settlling Point',
            'Price',
            'Total Amount',
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
            'A' => 10, // ID
            'B' => 20, 
            'C' => 15, // Cash Type
            'D' => 20,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 30, 
            'J' => 30, // Remarks
        ];
    }
}

