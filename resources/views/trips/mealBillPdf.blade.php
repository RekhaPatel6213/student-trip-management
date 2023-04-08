<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Meal Bill</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <table width="100%">
            <tr><td colspan="5">From: {{ $data['from'] }}</td></tr>
            <tr><td colspan="5">Re: {{ $data['re'] }}</td></tr>
            <tr><td colspan="5"></td></tr>
            <tr><td colspan="5">{{ $data['district'] }}<br>{{ $data['address'] }}<br>{{ $data['city'] }}<br>{{ $data['zip'] }}</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr>
                <td width="35%"></td>
                <td width="33%" style="text-align: center;">Attendance</td>
                <td width="3%"></td>
                <td width="15%">Fee</td>
                <td width="15%">Amount</td>
            </tr>
            <tr>
                <td>5-Day Week</td>
                <td style="text-align: center;">{{ $data['days'] === '5' ? $data['attendance'] : 0 }}</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>4-Day Week</td>
                <td style="text-align: center;">{{ $data['days'] === '4' ? $data['attendance'] : 0 }}</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>3-Day Week</td>
                <td style="text-align: center;">{{ $data['days'] === '3' ? $data['attendance'] : 0 }}</td>
                <td colspan="3"></td>
            </tr>
            @php
                $studentsTotal = ($data['fees']['STUDENT'] * $data['students']);
                $counselTotal = ($data['fees']['COUNSELOR'] * $data['counselorCount']);
                $teacherTotal = ($data['fees']['TEACHER'] * $data['teacherCount']);
                $total = number_format(($studentsTotal + $counselTotal + $teacherTotal));
            @endphp
            <tr>
                <td colspan="2">Contracted Attendance (97% of Scheduled Attendance): {{ $data['students'] }}</td>
                <td>@</td>
                <td>${{ $data['fees']['STUDENT'] }}</td>
                <td>${{ number_format($studentsTotal) }}</td>
            </tr>
            <tr>
                <td>Counselors</td>
                <td style="text-align: center;">{{ $data['counselorCount'] }}</td>
                <td>@</td>
                <td>${{ $data['fees']['COUNSELOR'] }}</td>
                <td>${{ number_format($counselTotal) }}</td>
            </tr>
            <tr>
                <td>Teacher</td>
                <td style="text-align: center;">{{ $data['teacherCount'] }}</td>
                <td>@</td>
                <td>${{ $data['fees']['TEACHER'] }}</td>
                <td>${{ number_format($teacherTotal) }}</td>
            </tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2"><b>Total Due:</b></td>
                <td><b>${{ $total }}</b></td>
            </tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr>
                <td style="text-align: center;"><b>Date of Attendance</b></td>
                <td style="text-align: center;"><b>School</b></td>
                <td style="text-align: center;"><b>Attendance</b></td>
                <td style="text-align: center;"><b>Scheduled</b></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center;">{{ $data['tripDate'] }}</td>
                <td style="text-align: center;">{{ $data['schoolName'] }}</td>
                <td style="text-align: center;">{{ $data['attendance'] }}</td>
                <td style="text-align: center;">{{ $data['students'] }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;"> Totals:</td>
                <td style="text-align: center;">{{ $data['attendance'] }}</td>
                <td style="text-align: center;">{{ $data['students'] }}</td>
                <td></td>
            </tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr>
                <td>Please remit to budget number: </td>
                <td colspan="4">010-00015-0-000000-000000-86890-000-00-0000</td>
            </tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr>
                <td>Please remit invoice amount of: </td>
                <td colspan="4"><b>${{ $total }}</b></td>
            </tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr>
                <td colspan="5">To:<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tulare Country School Service Fund<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tim A Hire
                </td>
            </tr>
            <tr><td colspan="5">&nbsp;</td></tr>
        </table> 
    </body>
</html>