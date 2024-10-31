<?php

namespace App\Exports;

use Auth;
use Carbon\Carbon;
use DB;
use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ExpenseListExport implements FromCollection,  WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $exchangeId;

    public function __construct($exchangeId){
        $this->exchangeId = $exchangeId;
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'Exchange Name',
            'User Name',
            'Cash Type',
            'Cash Amount',
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
            'A' => 10, // ID
            'B' => 20, 
            'C' => 15, // Cash Type
            'D' => 15, // Cash Amount
            'E' => 20,
            'F' => 25, // Remarks
            'G' => 30, // created_at
            'H' => 30,
            'I' => 30, // updated_At
        ];
    }
}
