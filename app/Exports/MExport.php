<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MExport implements FromCollection, WithHeadings, WithTitle, WithMapping, WithEvents
{
    function __construct($id, $year=null, $data=null) {
        $this->id = $id;
        $this->year = $year;
        $this->iterator = 1;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function map($mydata): array
    {
        $ak = array_values(json_decode($mydata->daya_aktif, true));
        $re = array_values(json_decode($mydata->daya_reaktif, true));
        $se = array_values(json_decode($mydata->daya_semu, true));
        $tsf = array_values(json_decode($mydata->tegangan_satu_fasa, true));
        $ttf = array_values(json_decode($mydata->tegangan_tiga_fasa, true));
        $tts = array_values(json_decode($mydata->tegangan_tidak_seimbang, true));
        $ar = array_values(json_decode($mydata->arus, true));
        return [
            $ak[0],$ak[1],$ak[2],$ak[3],
            $re[0],$re[1],$re[2],$re[3],
            $se[0],$se[1],$se[2],$se[3],
            $tsf[0],$tsf[1],$tsf[2],
            $ttf[0],$ttf[1],$ttf[2],
            $tts[0],$tts[1],$tts[2],
            $ar[0],$ar[1],$ar[2],$ar[3],
            $mydata->frekuensi,
            $mydata->harmonisa_arus,
            $mydata->harmonisa_tegangan,
            $mydata->faktor_daya,
        ];
    }

    public function headings(): array
    {
        return [
            ['aktif','_','_','_',
            'reaktif','_','_','_',
            'semu','_','_','_',
            'satu','_','_',
            'tiga','_','_',
            'noeq','_','_',
            'arus','_','_','_',
            'fre','har','hat','fad'
            ],
            ['R', 'S', 'T', 'Total', 
            'R', 'S', 'T', 'Total',
            'R', 'S', 'T', 'Total',
            'VRN', 'VSN', 'VTN',
            'VRN', 'VSN', 'VTN',
            'VRN', 'VSN', 'VTN',
            'R', 'S', 'T', 'NETRAL',
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->setCellValue('A1','DAYA AKTIF');
                $event->sheet->getDelegate()->getStyle('A1:D1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->mergeCells('E1:H1');
                $event->sheet->setCellValue('E1','DAYA REAKTIF');
                $event->sheet->getDelegate()->getStyle('E1:H1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->mergeCells('I1:L1');
                $event->sheet->setCellValue('I1','DAYA SEMU');
                $event->sheet->getDelegate()->getStyle('I1:L1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('I1:L1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('M1:O1');
                $event->sheet->setCellValue('M1','TEGANGAN SATU FASA');
                $event->sheet->getDelegate()->getStyle('M1:O1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('M1:O1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->mergeCells('P1:R1');
                $event->sheet->setCellValue('P1','TEGANGAN TIGA FASA');
                $event->sheet->getDelegate()->getStyle('P1:R1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('P1:R1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->mergeCells('S1:U1');
                $event->sheet->setCellValue('S1','TEGANGAN TAK SEIMBANG');
                $event->sheet->getDelegate()->getStyle('S1:U1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('S1:U1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('V1:Y1');
                $event->sheet->setCellValue('V1','ARUS');
                $event->sheet->getDelegate()->getStyle('V1:Y1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('V1:Y1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);;

                $event->sheet->mergeCells('Z1:Z2');
                $event->sheet->setCellValue('Z1','FREKUENSI');
                $event->sheet->getDelegate()->getStyle('Z1:Z2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('Z1:Z2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('Z1:Z2')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getColumnDimension('Z')->setWidth(11);
                $event->sheet->mergeCells('AA1:AA2');
                $event->sheet->setCellValue('AA1','HARMONISA ARUS');
                $event->sheet->getDelegate()->getStyle('AA1:AA2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('AA1:AA2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('AA1:AA2')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getColumnDimension('AA')->setWidth(13);
                $event->sheet->mergeCells('AB1:AB2');
                $event->sheet->setCellValue('AB1','HARMONISA TEGANGAN');
                $event->sheet->getDelegate()->getStyle('AB1:AB2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('AB1:AB2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('AB1:AB2')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getColumnDimension('AB')->setWidth(13);
                $event->sheet->mergeCells('AC1:AC2');
                $event->sheet->setCellValue('AC1','FAKTOR DAYA');
                $event->sheet->getDelegate()->getStyle('AC1:AC2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('AC1:AC2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('AC1:AC2')->getAlignment()->setWrapText(true);
            },
        ];
    }

    public function title(): string
    {
        $title = 'undefined';
        return $title;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('measurements as m')->select('m.daya_aktif', 'm.daya_reaktif',
         'm.daya_semu', 'm.tegangan_satu_fasa', 'm.tegangan_tiga_fasa', 'm.tegangan_tidak_seimbang',
         'm.arus', 'm.frekuensi', 'm.harmonisa_arus', 'm.harmonisa_tegangan', 'm.faktor_daya')
            //->whereRaw('ac.post_by = ?', $this->id)
            //->whereRaw('YEAR(ac.created_at) = ?', $this->year)
            //->whereRaw('iq.section_id = ?', $this->section)
            //->whereRaw('YEAR(iq.created_at) = ?', $this->year)
            //->whereRaw('MONTH(iq.created_at) = ?', $this->month)
            ->whereRaw('m.deleted_at IS NULL')
            ->whereRaw('m.created_at IS NOT NULL')->get();
        return $data;
    }

}
