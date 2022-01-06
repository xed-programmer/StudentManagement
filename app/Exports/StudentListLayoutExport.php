<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentListLayoutExport implements WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return collect($this->data);
    // }

    public function headings() :array
    {
        return [
            'Student Code',
            'Name',
            'Course',
            'Section',
            'Year',
            'Email',
            'Phone'
        ];
    }
}