<?php

namespace App\Exports;

use App\Models\energy_usage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class EUExportMonth implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $year, $month;

    function __construct($id, $year, $month, $data=null) {
        $this->index = 0;
        $this->id = $id;
        $this->year = $year;
        $this->month = $month;
        $this->data = $data;
    }

    public function map($mydata): array
    {
        return [
            ++$this->index,
            $mydata->name,
            $mydata->usage,
            $mydata->unit,
            $mydata->cost,
            $mydata->start_date,
            $mydata->end_date,
        ];
    }

    public function headings(): array
    {
        return [
            ['No', 'Nama', 'Penggunaan', 'Satuan', 'Biaya', 'Tanggal Awal', 'Tanggal Akhir']
        ];
    }

    public function month($num){
        $Text = "";
        switch($num) {
            case 1:
                $Text = "January";
                break;
            case 2:
                $Text = "February";
                break;
            case 3:
                $Text = "March";
                break;
            case 4:
                $Text = "April";
                break;
            case 5:
                $Text = "May";
                break;
            case 6:
                $Text = "June";
                break;
            case 7:
                $Text = "July";
                break;
            case 8:
                $Text = "August";
                break;
            case 9:
                $Text = "September";
                break;
            case 10:
                $Text = "October";
                break;
            case 11:
                $Text = "November";
                break;
            case 12:
                $Text = "December";
                break;
            default:
                $Text = "";
                break;
        }
        return $Text;
    }

    public function title(): string
    {
        if(EUExportMonth::month($this->month)!=""){
            return EUExportMonth::month($this->month);
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->data;
        if($data == null){
            $data = energy_usage::select('energy_usages.eu_id', 'E.name', 'energy_usages.usage', 'E.unit', 'energy_usages.cost', 'energy_usages.start_date', 'energy_usages.end_date')
            ->join('Energies AS E', 'E.energy_id', '=', 'energy_usages.energy_id')
            ->whereRaw('energy_usages.post_by = ?', $this->id)
            ->whereRaw('YEAR(energy_usages.created_at) = ?', $this->year)
            ->whereRaw('MONTH(energy_usages.created_at) = ?', $this->month)
            ->whereRaw('energy_usages.created_at IS NOT NULL')->get();
        }
        return $data;
    }
}
