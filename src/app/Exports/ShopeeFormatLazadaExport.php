<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShopeeFormatLazadaExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $header;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function __construct($data, $header)
    {
        $this->data = $data;
        $this->header = $header;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data);
    }

    public function headings() :array
    {
        return $this->header;
    }
}
