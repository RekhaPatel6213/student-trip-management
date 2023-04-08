<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>SCICON Bulletin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
    	<p style="text-align: right;">{{ date(config('constants.DATE_FORMATE'))}}</p>
        <h1><center>SCICON Bulletin</center></h1>
        <p><b>Week of:</b> {{$date}}</p>
        <table width="100%" border="0" cellspacing="0">
            <tr>
                <th style="text-align: left; border-top: 2px solid #000; border-bottom: 2px solid #000;">School</th>
                <th style="text-align: center; border-top: 2px solid #000; border-bottom: 2px solid #000;">Students</th>
                <th style="text-align: left; border-top: 2px solid #000; border-bottom: 2px solid #000;">Teachers</th>
                <th style="text-align: left; border-top: 2px solid #000; border-bottom: 2px solid #000;" width="20%"></th>
            </tr>
            @foreach($schedules as $schedule)
            <tr>
                <td>{{$schedule->school->name}}</td>
                <td style="text-align: center;">{{$schedule->students}}</td>
                <td>{{ str_replace(',',' / ', $schedule->teachers) }}</td>
                <td></td>
            </tr>
            @endforeach
            <tr><td colspan="4">&nbsp;</td></tr>
            <tr>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000;"><b>Total Students</b></td>
                <td style="text-align: center; border-top: 1px solid #000; border-bottom: 1px solid #000;">{{$schedules->sum('students')}}</td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000;" colspan="2"></td>
            </tr>
        </table>
    </body>
</html>