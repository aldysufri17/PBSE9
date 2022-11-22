<?php

namespace App\Exports;

use App\Models\infrastructure_quantity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ISExportMonth implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $year, $month;

    function __construct($id, $year, $month, $data=null) {
        $this->id = $id;
        $this->year = $year;
        $this->month = $month;
        $this->data = $data;
        $this->index = 0;
    }

    public function map($mydata): array
    {
        return [
            ++$this->index,
            $mydata->name,
            $mydata->capacity,
            $mydata->type,
            $mydata->quantity,
            $mydata->created_at
        ];
    }

    public function headings(): array
    {
        return [
            ['No', 'Nama', 'Kapasitas', 'Tipe', 'Kuantitas', 'Tanggal']
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
        if(ISExportMonth::month($this->month)!=""){
            return ISExportMonth::month($this->month);
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->data;
        if($data == null){
            $data = infrastructure_quantity::select('I.name', 'infrastructure_quantities.capacity', 'I.type', 'infrastructure_quantities.quantity', 'infrastructure_quantities.created_at',)
            ->join('infrastructures AS I', 'I.is_id', '=', 'infrastructure_quantities.is_id')
            ->whereRaw('infrastructure_quantities.post_by = ?', $this->id)
            ->whereRaw('YEAR(infrastructure_quantities.created_at) = ?', $this->year)
            ->whereRaw('MONTH(infrastructure_quantities.created_at) = ?', $this->month)
            ->whereRaw('Q.created_at IS NOT NULL')->get();
        }
        return $data;
    }
}
