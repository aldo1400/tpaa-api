<?php

namespace App\Imports;

use App\Colaborador;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TagsColaboradorImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $colaborador = Colaborador::where('rut', $row['rut'])->first();

            $colaborador->tags()->attach($row['tag_id']);
        }
    }
}
