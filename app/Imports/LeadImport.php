<?php

namespace App\Imports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\ToModel;

class LeadImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Lead([
            'arabic_name' => $row[0],
            'english_name' => $row[1],
            'last_name' => $row[2],
            'email' => $row[3],
            'phone' => $row[4],
            'is_client' => $row[5],
        ]);
    }
}
