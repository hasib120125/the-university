<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class StudentImport implements ToCollection, SkipsEmptyRows, WithChunkReading, ShouldQueue
{
    public $headers = ['department', 'name', 'student_id', 'grade', 'status', 'trasfer_status', 'motive',
        'state', 'job_compnay_name', 'job_address', 'job', 'church_name', 'phone_no', 'address', 'zip_code', 'email'];

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
            $importData['department'] = $row[0];
            $importData['name'] = $row[1];
            $importData['student_id'] = $row[2];
            $importData['grade'] = $row[3];
            $importData['status'] = $row[4];
            $importData['trasfer_status'] = $row[5];
            $importData['motive'] = $row[6];
            $importData['state'] = $row[7];
            $importData['job_compnay_name'] = $row[8];
            $importData['job_address'] = $row[9];
            $importData['job'] = $row[10];
            $importData['church_name'] = $row[11];
            $importData['phone_no'] = $row[12];
            $importData['address'] = $row[13];
            $importData['zip_code'] = $row[14];
            $importData['email'] = $row[15];

            $student = Student::where('email', $importData['email'] ?? '')->orWhere('student_no', $importData['student_id'])->first();
            if(!$student) $student = new Student();

            $student->student_no = $importData['student_id'];
            $student->name_hangul = $importData['name'];
            $student->name_chinese = $importData['name'];
            $student->name_english = $importData['name'];
            $student->email = $importData['email'] ?? '';
            $student->address = $importData['address'] ?? '';
            $student->mobile = $importData['phone_no'];
            $student->motive = $importData['motive'] ?? '';
            $student->job_company = $importData['job_compnay_name'] ?? '';
            $student->job_position = $importData['job'] ?? '';
            $student->job_address = $importData['job_address'] ?? '';
            $student->password = bcrypt(123456);

            $department = Department::where('name', $importData['department'])->first();
            if(!$department){
                $degree = ['Bachelor', 'Master'];
                $key = array_rand($degree);
                $department = Department::create([
                    'name'=>$importData['department'],
                    'code'=>rand(100,999), 
                    'degree'=> $degree[$key]
                ]);
            }

            $student->department_id = $department->id;
            $student->zip_code = $importData['zip_code'] ?? '';
            // $student->status = $importData['status'];
            $student->active = 1;
            $student->save();

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
