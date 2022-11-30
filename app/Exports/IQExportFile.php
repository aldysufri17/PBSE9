<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\DB;

class IQExportFile implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $year, $month;

    function __construct($id, $year=null, $month=null, $data=null, $section=null) {
        $this->id = $id;
        $this->year = $year;
        $this->month = $month;
        $this->data = $data;
        $this->section = $section;
        $this->iterator = 1;
    }

    public function map($mydata): array
    {
        $this->iterator++;
        return [
            //DB::table('section')->select('*')->whereRaw('section_id = ?', $mydata->section_id)->value('name'),
            DB::table('buildings')->select('name')->whereRaw('building_id = ?', $mydata->building_id)->value('name'),
            DB::table('rooms')->select('name')->whereRaw('room_id = ?', $mydata->room_id)->value('name'),
            $mydata->name,
            $mydata->capacity,
            $mydata->quantity,
            $mydata->total,

        ];
    }

    public function headings(): array
    {
        return [
            ['Gedung', 'Nama Ruang', 'Beban', 'Daya Beban', 'Jumlah', 'Total']
        ];
    }

    public function title(): string
    {
        $section = 'A';
       return $section;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->data;
        if($data == null){
            $data = DB::table('infrastructure_quantities as iq')->select('iq.section_id', 'iq.building_id', 'iq.room_id', 'iq.name', 'iq.capacity', 'iq.quantity', 'iq.total')
            ->join('rooms AS r', 'iq.room_id', '=', 'r.room_id')
            ->join('buildings as b', 'b.building_id', '=', 'iq.building_id')
            ->join('sections as s', 's.section_id', '=', 'iq.section_id')
            ->whereRaw('iq.post_by = ?', $this->id)
            //->whereRaw('iq.section_id = ?', $this->section)
            //->whereRaw('YEAR(iq.created_at) = ?', $this->year)
            //->whereRaw('MONTH(iq.created_at) = ?', $this->month)
            ->whereRaw('iq.created_at IS NOT NULL')->get();
        }
        return $data;
    }
}
