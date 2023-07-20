<?php

namespace App\Exports;

// use App\Models\Instruction;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InstructionExport implements WithMultipleSheets
{
    use Exportable;

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new InstructionPerStatusSheet('open');
        $sheets[] = new InstructionPerStatusSheet('completed');

        return $sheets;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Instruction::all();
    // }
}
