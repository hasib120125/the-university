<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GradeExport implements FromArray, WithHeadings
{
    protected $formattedDatas;

    public function __construct($formattedDatas)
    {
        $this->formattedDatas = $formattedDatas;
    }

    public function array(): array
    {
        return $this->formattedDatas;
    }
//        학과	,이름,	학번,	학년,	상태,	총점평균,	평점평균,	등급,	신청학점,	취득학점,
    public function headings(): array
    {
        return [
            '학과',
            '이름',
            '학번',
            '학년',
            '상태',
            '총점평균',
            '평점평균',
            '등급',
            '신청학점',
            '취득학점',
        ];
    }
}
