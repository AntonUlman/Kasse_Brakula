<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProfitsByDateExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    protected $profitsByDate;

    public function __construct($profitsByDate)
    {
        $this->profitsByDate = $profitsByDate;
    }

    public function collection()
    {
        return collect($this->profitsByDate)->map(function ($item) {
            $userNames = collect($item['users_involved'])->join(', ');
            return [
                'date' => $item['date'],
                'daily_profit' => $item['daily_profit'] . ' €',  // Append '€' to the sum
                'users_involved' => $userNames
            ];
        });
    }

    public function headings(): array
    {
        return ['Date', 'Daily Profit', 'Users Involved'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }
}
