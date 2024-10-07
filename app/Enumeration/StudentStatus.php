<?php
namespace App\Enumeration;

class StudentStatus {
    public static $ATTENDING = 1;
    public static $LEAVE = 2;
    public static $ARMY = 3;
    public static $FINISH = 4;
    public static $GRADUATED = 5;
    public static $GRADUATION_PLAN = 6;
    public static $WEEDING = 7;
    public static $DROPOUT = 8;

    public static $STASTUS_TEXT = [
        '1'=> '재학',
        '2'=> '휴학',
        '3'=> '군대 휴학',
        '4'=> '수료',
        '5'=> '졸업',
        '6'=> '졸업 예정',
        '7'=> '제적',
        '8'=> '중퇴',
    ];

}
