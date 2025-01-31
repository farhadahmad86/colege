<?php

namespace App\Exports;

use App\Models\RegionModel;
use function foo\func;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\FromQuery;
//use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
class OpeningExcelExport implements FromView, WithHeadings, WithEvents, ShouldAutoSize
{


    public $cusData;
    public $search;
    public $type;
    public $prnt_page_dir;
    public $pge_title;
    public $cusBalance;
    public $cusCshBkDate;
    public $cusCshBkopening_balance;
    public $cusincome_statement;
    public $cusbalance_sheet;
    public $cusassets_items;
    public $cusliabilities_items;
    public $cusequities_items;


    public function __construct($data = "", $srch_fltr = "", $type = "", $prnt_page_dir = "", $pge_title = "", $balance = "", $cshBkDate = "", $cshBkopening_balance = "", $income_statement = "", $balance_sheet = "", $assets_items = "", $liabilities_items = "", $equities_items = "", $total_stock = "" )
    {
        $this->cusData = $data;
        $this->search = implode(",",$srch_fltr);
        $this->type = $type;
        $this->prnt_page_dir = $prnt_page_dir;
        $this->pge_title = $pge_title;
        $this->cusBalance = $balance;
        $this->cusCshBkDate = $cshBkDate;
        $this->cusCshBkopening_balance = $cshBkopening_balance;
        $this->cusincome_statement = $income_statement;
        $this->cusbalance_sheet = $balance_sheet;
        $this->cusassets_items = $assets_items;
        $this->cusliabilities_items = $liabilities_items;
        $this->cusequities_items = $equities_items;
        $this->total_stock = $total_stock;
    }

    private function getNameFromNumber($num) {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);

        if ($num2 > 0) {
            return $this->getNameFromNumber($num2) . $letter;
        } else {
            return $letter;
        }
    }

    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        $styleArray = [
            'setTable' => [
                'font' => [
                    'bold' => true,
                    'size' => '12',
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb','000000']
                    ],
                ],
            ],
            'setHed1' => [
                'font' => [
                    'bold' => true,
                    'size' => '14',
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
            ],
            'setHed2' => [
                'font' => [
                    'bold' => true,
                    'size' => '14',
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                ],
            ],
            'setHed3' => [
                'font' => [
                    'bold' => true,
                    'size' => '10',
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
            ],
            'setHed4' => [
                'font' => [
                    'bold' => true,
                    'size' => '10',
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                ],
            ],
        ];
        $lastLetter = '';


        return [
            BeforeSheet::class=>function(BeforeSheet $event) use ($styleArray) {
            },

            AfterSheet::class=>function(AfterSheet $event) use ($styleArray) {
//                $event->writer->getProperties()->setCreator('Patrick');
                $rows = $event->sheet->getDelegate()->toArray();
                $breakdown = false;

                foreach ($rows as $k => $v) {
                    $lastLetter = $this->getNameFromNumber(count($v));

                    $event->sheet->getStyle('A'.$k.':'.$lastLetter.$k)->getAlignment()->setWrapText(true);
                    $event->sheet->getStyle('A'.($k+1))->getAlignment()->setHorizontal('center');
                    $event->sheet->getStyle('A'.($k+1).':'.$lastLetter.($k+1))->getAlignment()->setVertical('center');
                    if($k === 0){
                        $event->sheet->getStyle('A1:'.$lastLetter.'1')->getAlignment()->setHorizontal('center');
                        $event->sheet->getStyle('A1:'.$lastLetter.'1')->applyFromArray([
                            'font' => [
                                'name' => 'Arial',
                                'bold' => true,
                                'size' => '12',
                                'color' => [
                                    'argb' => '000000'
                                ],
                                'align' => 'center'
                            ],
//                            'fill' => [
//                                'fillType' => Fill::FILL_SOLID,
//                                'color' => [
//                                    'argb' => 'FF37474f'
//                                ]
//                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb','000000']
                                ],
                            ],
                        ]);
                    }
                    else if ($k === 1){
                        $event->sheet->getStyle('A2:'.$lastLetter.'2')->applyFromArray([
                            'font' => [
                                'name' => 'Arial',
                                'size' => 10,
                                'color' => [
                                    'argb' => '000000'
                                ]
                            ],
//                            'fill' => [
//                                'fillType' => Fill::FILL_SOLID,
//                                'color' => [
//                                    'argb' => 'FF3949ab'
//                                ]
//                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb','000000']
                                ],
                            ],
                        ]);
                    }
                    else{
                        if(!is_numeric($v[0])){
                            $event->sheet->getStyle('A'.($k + 1))->applyFromArray([
                                'font' => [
                                    'name' => 'Arial',
                                    'size' => 10,
                                ]
                            ]);
                        }

                        if($v[0] === 'Hover and Click Breakdown'){
                            $breakdown = true;
                            $event->sheet->getStyle('A'.($k+1).':'.$lastLetter.($k+1))->applyFromArray([
//                                'fill' => [
//                                    'fillType' => Fill::FILL_SOLID,
//                                    'color' => [
//                                        'argb' => 'FF3949ab'
//                                    ]
//                                ],
                                'font' => [
                                    'color' => [
                                        'argb' => 'FFFFFFFF'
                                    ]
                                ],
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['argb','000000']
                                    ],
                                ],
                            ]);
                        }

                        if(!$breakdown){
                            if(!empty($v[0])){
                                $event->sheet->getStyle('A'.($k+1).':'.$lastLetter.($k+1))->applyFromArray([
                                    'font' => [
                                        'name' => 'Arial',
                                        'size' => 10,
                                    ],
//                                    'fill' => [
//                                        'fillType' => Fill::FILL_SOLID,
//                                        'color' => [
//                                            'argb' => 'FFcfd8dc'
//                                        ]
//                                    ],
                                    'borders' => [
                                        'allBorders' => [
                                            'borderStyle' => Border::BORDER_THIN,
                                            'color' => ['argb','000000']
                                        ],
                                    ],
                                ]);
                            }
                        }
                        else{
                            if($v[1] === 'Component ID'){
                                $event->sheet->getStyle('A'.($k+1).':'.$lastLetter.($k+1))->applyFromArray([
//                                    'fill' => [
//                                        'fillType' => Fill::FILL_SOLID,
//                                        'color' => [
//                                            'argb' => 'FFcfd8dc'
//                                        ]
//                                    ],
                                    'borders' => [
                                        'allBorders' => [
                                            'borderStyle' => Border::BORDER_THIN,
                                            'color' => ['argb','000000']
                                        ],
                                    ],
                                    'font' => [
                                        'bold' => true
                                    ]
                                ]);
                            }

                            $event->sheet->getStyle('C'.($k+1))->applyFromArray([
                                'font' => [
                                    'bold' => true
                                ]
                            ]);
                        }
                    }
                }

                $maxWidth = 30;
                foreach ($event->sheet->getParent()->getAllSheets() as $sheet) {
                    $sheet->calculateColumnWidths();
                    foreach ($sheet->getColumnDimensions() as $colDim) {
                        if (!$colDim->getAutoSize()) {
                            continue;
                        }
                        $colWidth = $colDim->getWidth();
                        if ($colWidth > $maxWidth) {
                            $colDim->setAutoSize(false);
                            $colDim->setWidth($maxWidth);
                        }
                    }
                }

//                $event->sheet->getStyle('A1:E1')->applyFromArray($styleArray['setTable']);
                $event->sheet->insertNewRowAfter(1,5);
//                $event->sheet->insertNewColumnBefore('A',2);
//                $company_info = Session::get('company_info');
//
//                $event->sheet->setCellValue('A1', $company_info->ci_name);
//                $event->sheet->setCellValue('A2', 'Address: '.$company_info->ci_address.' ');
//                $event->sheet->setCellValue('A3', "Email: ".$company_info->ci_email." ");
//                $event->sheet->setCellValue('A4', 'Search Filter: '.$this->search.' ');
//
//                $event->sheet->setCellValue('C1', "".$this->pge_title." ");
//                $event->sheet->setCellValue('C2', "Mob #: ".$company_info->ci_mobile_numer." ");
//                $event->sheet->setCellValue('C3', "WhatsApp #: ".$company_info->ci_whatsapp_number." ");
//                $event->sheet->setCellValue('C4', "PTCL #: ".$company_info->ci_ptcl_number." ");

//                $event->sheet->getRowDimension('1')->setRowHeight(50);
                foreach ($rows as $k => $v) {
                    $lastLetter = $this->getNameFromNumber(count($v));
                    $event->sheet->getDelegate()->mergeCells('A'.($k+1).':B'.($k+1));
                    $event->sheet->getDelegate()->mergeCells('C'.($k+1).':'.$lastLetter.($k+1));
                    $event->sheet->getColumnDimension('A')->setAutoSize(false);
                    $event->sheet->getColumnDimension('C')->setAutoSize(false);
                    $event->sheet->getStyle('A'.$k.':'.$lastLetter.$k)->getAlignment()->setWrapText(true);
                    $event->sheet->getStyle('A'.$k.':'.$lastLetter.$k)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    if($k === 1) {
                        $event->sheet->getStyle('A'.$k.':B'.$k)->applyFromArray($styleArray['setHed1']);
                        $event->sheet->getStyle('C'.$k.':'.$lastLetter.$k)->applyFromArray($styleArray['setHed2']);
                    }
                    $event->sheet->getStyle('A'.($k+1).':B'.($k+1))->applyFromArray($styleArray['setHed3']);
                    $event->sheet->getStyle('C'.($k+1).':'.$lastLetter.($k+1))->applyFromArray($styleArray['setHed4']);
                    if($k === 4) break;
                }
                $event->sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

                $event->sheet->getHeaderFooter()
                    ->setOddHeader('&C&HPlease treat this document as confidential!');
                $event->sheet->getHeaderFooter()
                    ->setOddFooter('&L&B 2019 XIMI VOUGE | All rights reserved.'.'&CPage &P of &N'.'&RDesigned & Developed by softagics.com');
//                $event->sheet->getParent()->getProperties()->getTitle()

            },
        ];
    }

    public function view(): View
    {
        $datas = $this->cusData;
        $type = $this->type;
        $balance = (!empty($this->cusBalance)) ? $this->cusBalance : 0;
        $date = (!empty($this->cusCshBkDate)) ? $this->cusCshBkDate : 0;
        $opening_balance = (!empty($this->cusCshBkopening_balance)) ? $this->cusCshBkopening_balance : 0;
        $income_statement = (!empty($this->cusincome_statement)) ? $this->cusincome_statement : 0;

        $balance_sheet = (!empty($this->cusbalance_sheet)) ? $this->cusbalance_sheet : 0;
        $assets_items = (!empty($this->cusassets_items)) ? $this->cusassets_items : 0;
        $liabilities_items = (!empty($this->cusliabilities_items)) ? $this->cusliabilities_items : 0;
        $equities_items = (!empty($this->cusequities_items)) ? $this->cusequities_items : 0;
        $total_stock = (!empty($this->total_stock)) ? $this->total_stock : 0;


        return view($this->prnt_page_dir, compact('datas', 'type', 'balance', 'date', 'opening_balance', 'income_statement', 'balance_sheet', 'assets_items', 'liabilities_items', 'equities_items', 'total_stock'));
    }

    public function headings(): array
    {
        return $this->cushdngs;
    }
}
