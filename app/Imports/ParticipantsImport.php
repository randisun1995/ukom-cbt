<?php

namespace App\Imports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ParticipantsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Participant([
            'nip'          => (int) $row['nip'],
            'name'          => $row['name'],
            'password'      => $row['password'],
            'position_id'  => (int) $row['position_id'],
            'instansi_id'  => (int) $row['instansi_id'],
        ]);
    }

    /**
     * rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nip' => 'unique:participants,nip',
        ];
    }
}
