expense_account_list<?php

namespace App\Exports;

use App\Http\Controllers\DayEndController;
use App\Models\AccountOpeningClosingBalanceModel;
use DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Writer;

class TrialBalanceExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        return $accounts=AccountOpeningClosingBalanceModel::where('aoc_day_end_date',date("Y-m-d", strtotime("-1 day", strtotime($day_end->de_datetime))))->orderBy('aoc_type','DESC')->get();
//        dd($accounts);
//        return $accounts=AccountOpeningClosingBalanceModel::where('aoc_day_end_date',$day_end->de_datetime)->orderBy('aoc_type','DESC')->get();
    }

//    use Exportable;
//
//    public function query()
//    {
//        $get_day_end = new DayEndController();
//        $day_end = $get_day_end->day_end();
//
//        return $accounts=AccountOpeningClosingBalanceModel::query()->where('aoc_day_end_date',$day_end->de_datetime);
//    }

    public function map($accounts): array
    {
        return [
//            $accounts->aoc_account_uid,
            $accounts->aoc_account_name,
            $accounts->aoc_balance,
            $accounts->aoc_type,
        ];
    }

    public function headings(): array
    {
        return [
            ['Party','Type','Amount'],
        ];
    }

    public function registerEvents(): array
    {
        return [

            BeforeExport::class  => function(BeforeExport $event) {
                Writer::macro('setCreator', function (Writer $writer, string $creator) {
                    $writer->getDelegate()->getProperties()->setCreator($creator);
                });
                $event->writer->setCreator('Patrick');
            },
            AfterSheet::class    => function(AfterSheet $event) {
                Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
                    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
                });
                Sheet::macro('setOrientation', function (Sheet $sheet, $orientation) {
                    $sheet->getDelegate()->getPageSetup()->setOrientation($orientation);
                });
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getStyle('A1:P1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);

            },
        ];
    }
}
