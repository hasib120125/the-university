<!DOCTYPE html>
<html lang="en">

<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <meta charset="utf-8">
    <title>certificate</title>

    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Noto+Sans+KR:300,400,700&display=swap&subset=korean');

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
            font-family: 'ko';
        }

        p {
            margin: 0;
            font-size: 12px;
            line-height: 17px;
            font-weight: 500;
        }

        table {
            width: 100%;
            /* table-layout: fixed; */
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 15px 10px;
            font-size: 16px;
        }

        .certificate_template {
            max-width: 800px;
            margin: auto;
            padding: 40px;
            /* border: 1px solid #C6C6C6; */
            /* -webkit-box-shadow: 1px -2px 40px -1px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 1px -2px 40px -1px rgba(0, 0, 0, 0.75);
        box-shadow: 1px -2px 40px -1px rgba(0, 0, 0, 0.75); */
            font-size: 14px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #000;
            background: #fff;
            line-height: 17px;
            /* background-image: url({{ asset('images/certificate/logo.png')}}); */
            background-size: 400px 400px;
            position: relative;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, .9);
            z-index: 1;
        }

        .layer .shade {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, .9);
            z-index: 1;
        }

        .layer img {
            width: 500px;
            height: 500px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            position: absolute;
        }

        .wrapper {
            position: relative;
            z-index: 3;
        }

        .has_border td {
            border: 1px solid #000
        }

        .heading {
            text-align: center;
        }

        .sub_heading {
            margin-bottom: 0;
        }

        .bottom img {
            position: absolute;
            right: 25px;
            bottom: -49px;
            width: 106px;
            z-index: -1;
        }

        .bottom {
            position: relative;
        }
    </style>

<body>
    <?php
    // dd($student);
    ?>
    <div class="certificate_template">
        <div class="layer">
            <div class="shade"></div>
            <img src="{{ asset('images/certificate/logo.png') }}" alt="">
        </div>
        <div class="wrapper">
            <table style="border: 1px solid #000; text-align:center;">
                <tr>
                    <td style="text-align: left;">제 ICS2021-030호</td>
                </tr>
                <tr>
                    <td style="font-size: 40px; font-weight:bold; padding : 100px 0px">
                        졸 업 증 명 서
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>성 명 </span> : <span>신 태 복</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>생 년 월 일 </span> : <span>1952년 11월 20일</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>학 과 </span> : <span>목회학과</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>학 위 명</span> : <span>학 위 명</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>입 학 년 월 일</span> : <span>2018년 3월 1일</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>졸 업 년 월 일</span> : <span>2021년 2월 20일</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 40px;">
                        위의 사실을 증명합니다.
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 40px;">
                        2021 년 7 월 2 일
                    </td>
                </tr>
                <tr>
                    <td style="padding: 100px 0px 70px">
                        <div class="bottom" style="position: relative;">
                            <h1>International Cyber Seminary 총장</h1>
                            <img src="{{ asset('images/certificate/seal.png') }}" alt="">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>


</html>