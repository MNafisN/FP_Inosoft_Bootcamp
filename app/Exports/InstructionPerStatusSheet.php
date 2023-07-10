<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Instruction;

class InstructionPerStatusSheet implements FromQuery, WithTitle, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithStyles
{
    private $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        if ($this->status == 'open') {
            return Instruction
                ::query()
                ->select('instruction_id', 'transaction_code', 'instruction_type', 'assigned_vendor', 'created_at', 'attention_of', 'quotation_number', 'cust_po_number', 'instruction_status')
                ->where('instruction_status', 'Draft')
                ->orWhere('instruction_status', 'In Progress');
            // return $this->instructionService->getOpen();
        } else if ($this->status == 'completed') {
            return Instruction
                ::query()
                ->select('instruction_id', 'transaction_code', 'instruction_type', 'assigned_vendor', 'created_at', 'attention_of', 'quotation_number', 'cust_po_number', 'instruction_status')
                ->where('instruction_status', 'Cancelled')
                ->orWhere('instruction_status', 'Completed');
            // return $this->instructionService->getCompleted();
        }
    }

    /**
     * @return string
     */
    public function title(): string
    {
        if ($this->status == 'open') {
            return 'Open Instructions';
        } else if ($this->status == 'completed') {
            return 'Completed Instructions';
        }    
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(1)->getFont()->setBold(true);
    }

    /**
    * @var Instruction $instruction
    */
    public function map($instruction): array
    {
        return [
            $instruction->instruction_id,
            $instruction->transaction_code,
            $instruction->instruction_type,
            $instruction->assigned_vendor,
            Date::dateTimeToExcel($instruction->created_at),
            $instruction->attention_of,
            $instruction->quotation_number,
            $instruction->cust_po_number,
            $instruction->instruction_status,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            // 'id',
            'Instruction No.',
            'Link To',
            'Instruction Type',
            'Assigned Vendor',
            'Issued Date',
            'Attention Of',
            'Quotation No',
            'Customer PO',
            'Instruction Status',
        ];
    }
}