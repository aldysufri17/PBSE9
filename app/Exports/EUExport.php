<?php

namespace App\Exports;

use App\Models\energy_usage;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EUExport implements WithMultipleSheets
{
    use Exportable;

    protected $year, $month;

    function __construct($id, $year, $month=null) {
        $this->id = $id;
        $this->year = $year;
        $this->month = $month;
    }

    /*public function headings(): array
    {
        return [
            ['No', 'Nama', 'Penggunaan', 'Satuan', 'Biaya', 'Tanggal Awal', 'Tanggal Akhir']
        ];
    }*/

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        for ($month = 1; $month <= 12; $month++) {
            $data = energy_usage::select('energy_usages.eu_id', 'E.name', 'energy_usages.usage', 'E.unit', 'energy_usages.cost', 'energy_usages.start_date', 'energy_usages.end_date')
            ->join('Energies AS E', 'E.energy_id', '=', 'energy_usages.energy_id')
            ->whereRaw('energy_usages.post_by = ?', $this->id)
            ->whereRaw('YEAR(energy_usages.created_at) = ?', $this->year)
            ->whereRaw('MONTH(energy_usages.created_at) = ?', $month)
            ->get();
            //dd(count($data));
            if (count($data)<=0){
                continue;
            }else{
                $sheets[] = new EUExportMonth($this->id, $this->year, $month, $data);
            }
        }

        return $sheets;
    }
}
