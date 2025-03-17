<?php
namespace App\Imports;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ContactsImport implements ToModel,WithStartRow
{
    public function startRow(): int
    {
        return 2; // Start reading from row 2
    }

    public function model(array $row)
    {
        return new Contact([
            'name' => $row[1] ?? null, 
            'email' => $row[2] ?? null,
            'phoneno' => $row[3] ?? null,
            'city' => $row[4] ?? null,
            'country' => $row[5] ?? null,
        ]);
    }
}
