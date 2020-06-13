<?php

namespace App\Exports;

use App\NewsletterSubscriber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class subscribersExport implements WithHeadings,FromCollection,ShouldAutoSize,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $subscriberData =  NewsletterSubscriber::select('id','UserEmail','created_at')->where('Status', 1)->orderby('id','DESC')->get();
        return $subscriberData;
    }
    public function headings():array{
        return['id','UserEmail','created_at'];
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
            $event->sheet->setCellValue('A1','EMAIL SUBSCRIPTIONS');

            // assign cell styles
            $event->sheet->getStyle('A1:A2');
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
