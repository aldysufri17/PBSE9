<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ACExport implements FromCollection, WithHeadings, WithTitle, WithMapping, WithEvents
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
        $in = array_values(json_decode($mydata->incoming_students, true));
        $out = array_values(json_decode($mydata->graduate_students, true));
        $e = array_values(json_decode($mydata->employee, true));
        return [
            $in[0],
            $in[1],
            $in[2],
            $out[0],
            $out[1],
            $out[2],
            $e[0],
            $e[1],
            $e[2],
        ];
    }

    public function headings(): array
    {
        return [
            ['Mahasiswa Masuk','_','_','Mahasiswa Lulus','_','_','Pegawai','_','_'],
            ['S1', 'S2', 'S3', 'S1', 'S2', 'S3', 'S1', 'S2', 'S3']
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:C1');
                $event->sheet->setCellValue('A1','MAHASISWA MASUK');
                $event->sheet->getDelegate()->getStyle('A1:C1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->mergeCells('D1:F1');
                $event->sheet->setCellValue('D1','MAHASISWA LULUS');
                $event->sheet->getDelegate()->getStyle('D1:F1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('D1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->mergeCells('G1:I1');
                $event->sheet->setCellValue('G1','PEGAWAI');
                $event->sheet->getDelegate()->getStyle('G1:I1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('G1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }

    public function title(): string
    {
        $title = $this->year;
        return $title;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('academic_communities as ac')->select('ac.incoming_students', 'ac.graduate_students', 'ac.employee')
            ->whereRaw('ac.post_by = ?', $this->id)
            ->whereRaw('YEAR(ac.created_at) = ?', $this->year)
            //->whereRaw('iq.section_id = ?', $this->section)
            //->whereRaw('YEAR(iq.created_at) = ?', $this->year)
            //->whereRaw('MONTH(iq.created_at) = ?', $this->month)
            ->whereRaw('ac.created_at IS NOT NULL')->get();
        return $data;
    }

}
