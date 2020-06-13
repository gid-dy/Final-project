<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Concerns\WithTitle;

class usersExport implements WithHeadings,FromCollection,ShouldAutoSize,WithEvents,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $usersData = User::select('id','SurName','OtherNames','UserEmail','Country','Address','City','State','Mobile','OtherContact')->where('Status', 1)->orderby('id','ASC')->get();
        return $usersData;
    }

    public function headings():array{
        return['#','SurName','OtherNames','UserEmail','Country','Address','City','State','Mobile','OtherContact'];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {

            // at row 1, insert 2 rows
            $event->sheet->insertNewRowBefore(1);

            // merge cells for full-width
            $event->sheet->mergeCells('A1:S1');

            // assign cell values
            $event->sheet->setCellValue('A1','REGISTERED USERS');

            // assign cell styles
            $event->sheet->getStyle('A1:A2');
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
            BeforeExport::class => function(BeforeExport $event){
                $event->writer->getproperties()->setTitle('Users');
            }
        ];
    }
    public function title():string
    {
        return 'USERS';
    }

}
