<?php

namespace App\Exports;

use App\Models\infrastructure_quantity;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ISExport implements WithMultipleSheets
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
            $data = infrastructure_quantity::select('I.name', 'infrastructure_quantities.capacity', 'I.type', 'infrastructure_quantities.quantity', 'infrastructure_quantities.created_at',)
            ->join('infrastructures AS I', 'I.is_id', '=', 'infrastructure_quantities.is_id')
            ->whereRaw('infrastructure_quantities.post_by = ?', $this->id)
            ->whereRaw('YEAR(infrastructure_quantities.created_at) = ?', $this->year)
            ->whereRaw('MONTH(infrastructure_quantities.created_at) = ?', $month)
            ->get();
            //dd(count($data));
            if (count($data)<=0){
                continue;
            }else{
                $sheets[] = new ISExportMonth($this->id, $this->year, $month, $data);
            }
        }

        return $sheets;
    }
}
