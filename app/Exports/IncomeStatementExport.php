<?php

namespace App\Exports;

use App\Http\Controllers\DayEndController;
use App\Models\AccountOpeningClosingBalanceModel;
use App\Models\IncomeStatementModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Writer;

class IncomeStatementExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        return $accounts=IncomeStatementModel::where('is_day_end_date',date("Y-m-d", strtotime("-1 day", strtotime($day_end->de_datetime))))->get();
    }

    public function map($accounts): array
    {
        return [
            $accounts->is_sales,
            $accounts->is_sales_return,
            $accounts->is_total_sales,
            $accounts->is_opening_inventory,
            $accounts->is_purchase,
            $accounts->is_purchase_return,
            $accounts->is_total_purchase,
            $accounts->is_ending_inventory,
            $accounts->is_total_cgs,
            $accounts->is_gross_revenue_one,
            $accounts->is_other_total_revenue,
            $accounts->is_gross_revenue_two,
            $accounts->is_total_expense,
            $accounts->is_profit_loss_amount,
            $accounts->is_profit_loss,
        ];
    }

    public function headings(): array
    {
        return [
            ['Sales','Sales Return','Total Sales','Opening Stock/Inventory','Purchases','Purchase Return','Total Purchase','Ending Inventory','Cost Of Goods Sold','Gross Revenue One','Other Revenues','Total Other Revenue','Total Expenses','Total Amount','Status'],
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
