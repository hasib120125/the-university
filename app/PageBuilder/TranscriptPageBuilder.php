<?php

namespace App\PageBuilder;

class TranscriptPageBuilder
{
    protected $pageHeight = 842;
    protected $headerHeight = 127;
    protected $perResultRow = 29;
    protected $page = [
        'pageLength' => 190,
        'common'=> [],
        'result'=> [],
        'gradeSystem'=> null,
        'pageBreak'=> false,
        'lastPage'=> false,
    ];

    public function __construct() {

    }

    public function getPages($arrayData)
    {
        $pages = [];
        $page = $this->page;
        $common = [
            'issueNumber'=> $arrayData['issueNumber'],
            'name'=> $arrayData['name'],
            'dob'=> $arrayData['dob'],
            'department'=> $arrayData['department'],
            'student_id'=> $arrayData['student_id'],
            'gender'=> $arrayData['gender'],
            'degree'=> $arrayData['degree'],
            'admission_date'=> $arrayData['admission_date'],
            'graduation_date'=> $arrayData['graduation_date'],
        ];

        $semesterData = [];
        $semesterData = array_chunk($arrayData['allSemester'], 2);

        for ($itemIndex=0; $itemIndex < count($semesterData); $itemIndex++) {
            if(count($page['result']) == 0){
                $page['pageLength'] += $this->headerHeight;
                $page['common'] = $common;
            }

            $page['gradeSystem'] = $arrayData['gradeSystem'];

            $items = $semesterData[$itemIndex];
            $leftHeight = 0;
            $rightHeight = 0;
            foreach ($items as $key=>$item){
                $is_odd = $key & 1;

                if($is_odd){
                    $leftHeight += count($item) * $this->perResultRow + $this->perResultRow;
                }else{
                    $rightHeight += count($item) * $this->perResultRow + $this->perResultRow;
                }
            }

            if($leftHeight > $rightHeight){
                $page['pageLength'] += (count($semesterData) == $itemIndex ) ? $leftHeight + 75 : $leftHeight;
            }else{
                $page['pageLength'] += (count($semesterData) == $itemIndex ) ? $rightHeight + 75 : $rightHeight;
            }

            if($page['pageLength'] >= $this->pageHeight) {
                if(count($semesterData) > $itemIndex){
                    $page['pageBreak'] = true;
                }

                $pages[] = $page;
                $page = $this->page;
                $page['result'] = [];
                $itemIndex--;
            } else {
                $page['result'][] = $items;
            }
        }

        if($page['pageLength'] > 0) {
            $page['lastPage'] = true;
            $pages[] = $page;
        }

        return $pages;
    }
}
