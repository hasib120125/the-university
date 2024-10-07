<!DOCTYPE html>
<html lang="en">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="IE=edge" http-equiv="X-UA-Compatible" />
        <title>Transcript</title>
        <meta charset="utf-8">

        <style type="text/css">
            @page {
                margin: 30px;
            }

            *,
            *:before,
            *:after {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                margin-top: 20px;
                font-family: 'vitro';
                font-weight: 400;
            }

            table {
                width: 100%;
                table-layout: fixed;
                border-collapse: collapse;
            }

            td {
                vertical-align: top;
                padding: 3px;
            }
            .certificate_template {
                margin: auto;
                padding: 40px;
                font-size: 12px;
                color: #000;
                background: #fff;
                line-height: 17px;
                background-size: 450px 450px;
                position: relative;
                height: 854px;
                background-position: center center;
                background-repeat: no-repeat;
                background-image: url({{ public_path('images/certificate/logo.png')}});
            }

            .shading {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 80%;
                background: rgba(255, 255, 255, .9);
                z-index: 1;
                background-size: 70px 70px;
                background-position:  right  bottom;
            }

            .wrapper {
                position: absolute;
                z-index: 3;
            }

            .has_border td {
                border: 1px solid #000
            }

            .heading {
                text-align: center;
                font-family: 'vitro';
                font-weight: 400;
            }
            .sub_heading {
                font-family: 'vitro';
                font-weight: 400;
            }
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>

    <body>
    @php
        $totalCredit = 0;
        $totalCreditGrade = 0;
        $totalCreditScore = 0;
    @endphp
    @foreach($pages as $dataKey=>$studentData)
        <div class="certificate_template">
            <div class="shading">
                <div class="wrapper">
                    <h1 class="heading">성 적 증 명 서</h1>
                    <h3 class="sub_heading">제 {{ $studentData['common']['issueNumber'] }}</h3>
                    <table>
                        <tr>
                            <td style="width:50%; padding: 0; border-left: 1px solid #000;">
                                <table class="has_border" style="margin-left : -1px">
                                    <tr>
                                        <td style="border-left: none;">성 명 </td>
                                        <td style="border-right: none;">{{ $studentData['common']['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border-left: none;">생 년 월 일</td>
                                        <td style="border-right: none;">{{ $studentData['common']['dob'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border-left: none;">학 과</td>
                                        <td style="border-right: none;">{{ $studentData['common']['department'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border-left: none;">학 번 </td>
                                        <td style="border-right: none;">{{ $studentData['common']['student_id'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding: 0; border-left: none; border-right: none;">
                                            <table style="border: none;">
                                                <tr>
                                                    <th style="width: 60%;"></th>
                                                    <th style="width: 20%;"></th>
                                                    <th style="width: 20%;"></th>
                                                </tr>
                                                <tr>
                                                    <td style="border: none;">교과목명</td>
                                                    <td style="border: none;">학점</td>
                                                    <td style="border: none;">성적</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:50%;  padding: 0; border-right: 1px solid #000;">
                                <table class="has_border" style="margin-right: -1px;">
                                    <tr>
                                        <td>성 별</td>
                                        <td style="border-right: none;">{{ $studentData['common']['gender'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>과 정</td>
                                        <td style="border-right: none;">{{ $studentData['common']['degree'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>입 학 일 자</td>
                                        <td style="border-right: none;">{{ $studentData['common']['admission_date'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>졸 업 일 자</td>
                                        <td style="border-right: none;">{{ $studentData['common']['graduation_date'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding: 0; border-right: none;">
                                            <table style="border: none;">
                                                <tr>
                                                    <th style="width: 60%;"></th>
                                                    <th style="width: 20%;"></th>
                                                    <th style="width: 20%;"></th>
                                                </tr>
                                                <tr>
                                                    <td style="border: none;">교과목명</td>
                                                    <td style="border: none;">학점</td>
                                                    <td style="border: none;">성적</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        @foreach($studentData['result'] as $result)
                        @php
                            $leftData = isset($result[0]) ? $result[0] : [];
                            $rightData = isset($result[1]) ? $result[1] : [];
                        @endphp
                        <tr>
                            <td style="width:50%; padding: 0; border-left: 1px solid #000; border-right: 1px solid #000">
                                <table style=" padding : 10px 0px">
                                    <tr>
                                        <th style="width: 60%;"></th>
                                        <th style="width: 20%;"></th>
                                        <th style="width: 20%;"></th>
                                    </tr>

                                    @php
                                        $totalCreditLeft = 0;
                                        $totalCreditGradeLeft = 0;
                                    @endphp
                                    @if(count($leftData) > 0)
                                        @foreach ($leftData as $leftDataValue)
                                            <tr>
                                                <td colspan="3" style="padding-top: 20px"> <b>{{ $leftDataValue['semester_year'] ?? '' }}학년도 {{ $leftDataValue['semester_season'] ?? '' }} </b> </td>
                                            </tr>
                                            @break
                                        @endforeach

                                        @foreach($leftData as $leftDataValue)
                                            <tr>
                                                <td>{{ $leftDataValue['subject_name'] }}</td>
                                                <td>{{ $leftDataValue['credit'] }}</td>
                                                <td>{{ $leftDataValue['grade'] }}</td>
                                            </tr>
                                            @php
                                                $totalCreditLeft += (float)$leftDataValue['credit'];
                                                $totalCreditGradeLeft += (float)$leftDataValue['credit'] * (float)$leftDataValue['grades'];
                                                $totalCredit += (float)$leftDataValue['credit'];
                                                $totalCreditGrade += (float)$leftDataValue['credit'] * (float)$leftDataValue['grades'];
                                                $totalCreditScore += (float)$leftDataValue['credit'] * (float)$leftDataValue['score'];
                                            @endphp
                                        @endforeach

                                        @php
                                            $gradePoint = number_format((float)($totalCreditGradeLeft / $totalCreditLeft), 2, '.', '');
                                        @endphp

                                        <tr>
                                            <td colspan="3" style="padding-top: 20px; text-align:center;">취득학점: {{ $totalCreditLeft }} 평균평점: {{ $gradePoint }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </td>
                            <td style="width:50%;  padding: 0; border-right: 1px solid #000">
                                <table style=" padding : 10px 0px;">
                                    <tr>
                                        <th style="width: 60%;"></th>
                                        <th style="width: 20%;"></th>
                                        <th style="width: 20%;"></th>
                                    </tr>

                                    <!-- Right Side Start-->
                                    @php
                                        $totalCreditRight = 0;
                                        $totalCreditGradeRight = 0;
                                    @endphp

                                    @if(count($rightData) > 0)
                                        @foreach ($rightData as $rightDataValue)
                                            <tr>
                                                <td colspan="3" style="padding-top: 20px"> <b>{{ $rightDataValue['semester_year'] ?? ''}}학년도 {{ $rightDataValue['semester_season'] ?? '' }} </b> </td>
                                            </tr>
                                            @break
                                        @endforeach
                                        @foreach($rightData as $rightDataValue)
                                            <tr>
                                                <td>{{ $rightDataValue['subject_name'] }}</td>
                                                <td>{{ $rightDataValue['credit'] }}</td>
                                                <td>{{ $rightDataValue['grade'] }}</td>
                                            </tr>
                                            @php
                                                $totalCreditRight += (float)$rightDataValue['credit'];
                                                $totalCreditGradeRight += (float)$rightDataValue['credit'] * (float)$rightDataValue['grades'];
                                                $totalCredit += (float)$rightDataValue['credit'];
                                                $totalCreditGrade += (float)$rightDataValue['credit'] * (float)$rightDataValue['grades'];
                                                $totalCreditScore += (float)$rightDataValue['credit'] * (float)$rightDataValue['score'];
                                            @endphp
                                        @endforeach

                                        @php
                                            $gradePointRight = number_format((float)($totalCreditGradeRight / $totalCreditRight), 2, '.', '');
                                        @endphp

                                        <tr>
                                            <td colspan="3" style="padding-top: 20px; text-align:center;">취득학점: {{ $totalCreditRight }} 평균평점: {{ $gradePointRight }}</td>
                                        </tr>
                                    @endif
                                    <!-- Right Side End-->

                                    <!-- result -->
                                    @php
                                        $totalFinalGrade = number_format((float)($totalCreditGrade / $totalCredit), 2, '.', '');
                                        $totalFinalScore = number_format((float)($totalCreditScore / $totalCredit), 2, '.', '');
                                    @endphp
                                    @if($studentData['lastPage'] == true)
                                    <tr>
                                        <td colspan="3" style="padding-top: 10px;text-align:center;"> 총취득학점 : {{ $totalCredit }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align:center;"> 평균평점 : {{ $totalFinalGrade }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align:center"> 백분율 : {{ $totalFinalScore }}/100 </td>
                                    </tr>
                                     @endif
                                </table>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <table class="has_border">
                        <tr>
                            <td style="width: 120px;">등급체계</td>

                            <td>
                                @if(count($studentData['gradeSystem']) > 0)
                                    @foreach ($studentData['gradeSystem'] as $grade)
                                            {{ $grade->grade }}({{ $grade->point }}:{{ $grade->from }}~{{ $grade->to }}) @if(!$loop->last), @endif
                                    @endforeach
                               @endif
                            </td>
                        </tr>
                    </table>
                    <table style="border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;">
                        <tr>
                            <td style="text-align: center;">
                                <h3 >위의 사실을 증명합니다.</h3>
                                <h2>{{ date('Y') }} 년 {{ date('m')  }} 월 {{ date('d') }} 일</h2>
                                <h1>
                                    <b>International Cyber Seminary 총장</b>
                                    <img src="{{ public_path('images/certificate/seal.png') }}" style="height: 100px;">
                                </h1>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    @endforeach
    </body>
</html>
