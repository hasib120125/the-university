<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Professor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProfessorImport implements ToCollection, SkipsEmptyRows, WithChunkReading, ShouldQueue
{
    					

    public $headers = ['NAME', 'NID', 'DEPARTMENT', 'ID_NO', 'TELL', 'CELL', 'EMAIL', 'ADDRESS'];

    public $data = [];

    public function collection(Collection $rows)
    {
        if (count($rows) < 2) {
            $this->data = [
                'data' => [
                    'success' => false,
                    'message' => 'No data found.'
                ]
            ];

            return false;
        }

        unset($rows[0]);
        foreach ($rows as $row)
        {
            $importData['NAME'] = $row[0];
            $importData['NID'] = $row[1];
            $importData['DEPARTMENT'] = $row[2];
            $importData['ID_NO'] = $row[3];
            $importData['TELL'] = $row[4];
            $importData['CELL'] = $row[5];
            $importData['EMAIL'] = $row[6];
            $importData['ADDRESS'] = $row[7];

            $professor = Professor::where('email', $importData['EMAIL'] ?? '')->orWhere('professor_no', $importData['ID_NO'])->first();
            if(!$professor) $professor = new professor();

            $professor->professor_no = $importData['ID_NO'];
            $professor->name_hangul = $importData['NAME'] ?? '';
            $professor->name_chinese = $importData['NAME'] ?? '';
            $professor->name_english = $importData['NAME'] ?? '';
            $professor->nid_no = $importData['NID'] ?? '';
            $professor->phone = $importData['TELL'] ?? '';
            $professor->mobile = $importData['CELL'] ?? '';
            $professor->email = $importData['EMAIL'] ?? '';
            $professor->address = $importData['ADDRESS'] ?? '';
            $professor->password = bcrypt(123456);

            $department = Department::where('name', $importData['DEPARTMENT'])->first();
            if(!$department){
                $degree = ['Bachelor', 'Master'];
                $key = array_rand($degree);
                $department = Department::create([
                    'name'=>$importData['DEPARTMENT'],
                    'code'=>rand(100,999), 
                    'degree'=> $degree[$key]
                ]);
            }

            $professor->department_id = $department->id;
            $professor->status = 1;
            $professor->save();

        }

        $this->data = [
            'data' => [
                'success' => true,
                'message' => 'Success!'
            ]
        ];

        return true;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
