<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\DB;

class EUExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $year, $month;

    function __construct($id, $year=null, $month=null, $building=null) {
        $this->id = $id;
        $this->year = $year;
        $this->month = $month;
        //$this->data = $data;
        $this->building = $building;
        $this->iterator = 0;
    }

    public function map($mydata): array
    {
        $this->iterator++;
        return [
            $this->iterator,
            DB::table('energies')->select('name')->whereRaw('energy_id = ?', $mydata->energy_id)->value('name'),
            $mydata->usage,
            $mydata->cost,
            $mydata->start_date,
            $mydata->end_date,

        ];
    }

    public function headings(): array
    {
        return [
            ['No', 'Energi', 'Nilai', 'Biaya', 'Tanggal Awal', 'Tanggal Akhir']
        ];
    }

    public function title(): string
    {
        return $this->building;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //$data = $this->data;
        //if($data == null){
        $data = DB::table('energy_usages as eu')->select('eu.energy_id', 'eu.building_id', 'eu.usage', 'eu.cost', 
        'eu.start_date', 'eu.end_date', 'eu.post_by')
        ->join('energies AS e', 'e.energy_id', '=', 'eu.energy_id')
        ->join('buildings as b', 'b.building_id', '=', 'eu.building_id')
        ->whereRaw('eu.post_by = ?', $this->id)
        ->whereRaw('YEAR(eu.created_at) = ?', $this->year)
        ->whereRaw('MONTH(eu.created_at) = ?', $this->month)
        ->whereRaw('eu.created_at IS NOT NULL')
        ->orderBy('eu.energy_id')
        ->orderBy('eu.building_id')
        ->get();
        //dd($data);
        //}
        return $data;
    }
}
