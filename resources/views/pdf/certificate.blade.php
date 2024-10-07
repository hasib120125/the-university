<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <!--<![endif]-->
    <title></title>
    <meta charset="utf-8">
    <title>certificate</title>

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
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        td {
            vertical-align: top;
            padding: 15px 10px;
            font-size: 16px;
        }

        .shading {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 80%;
            background: rgba(255, 255, 255, .9);
            z-index: 1;
            background-size: 100px 100px;
            background-position:  right  bottom;
            /* background-position-y: 600px;
            background-position-x: 600px; */
            background-repeat: no-repeat;
            background-image: url({{ public_path('images/certificate/seal.png')}});
        }
        .certificate_template {
            margin: auto;
            padding: 40px;
            font-size: 14px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #000;
            background: #fff;
            line-height: 17px;
            position: fixed;
            background-image: url({{ public_path('images/certificate/logo.png')}});
            background-size: 450px 450px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .wrapper {
            z-index: 1;
        }
    </style>

<body>
    <div class="certificate_template">
        <div class="shading">
            <div class="wrapper" style="border: 1px solid #000;">
                <table style="border: 1px solid #000; text-align:center; table-layout: fixed;">
                    <tr>
                        <td style="text-align: left;">제 {{ $student['issue_no'] }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 40px; font-weight:bold; padding : 100px 0px">
                            <br>
                            졸 업 증 명 서
                            <br><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="table-layout: fixed; padding-top: 200px; border:none">
                                <tr>
                                    <td>
                                        <span>성 명 </span> : <span>{{ $student['name'] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>생 년 월 일 </span> : <span>{{ $student['dob'] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>학 과 </span> : <span>{{ $student['department'] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>학 위 명</span> : <span>{{ $student['degree'] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>입 학 년 월 일</span> : <span>{{ $student['admission_date'] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>졸 업 년 월 일</span> : <span>{{ $student['graduation_date'] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 40px;">
                                        위의 사실을 증명합니다.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 40px;">
                                        {{ $student['issue_date'] }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="table-layout: fixed; border:none;">
                                <tr>
                                    <td style="padding: 100px 0px 20px; vertical-align: middle;">
                                        <h1 class="bottom_img"> <span style="position: fixed; z-index : 10;">International Cyber Seminary 총장</span> </h1>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</body>

</html>