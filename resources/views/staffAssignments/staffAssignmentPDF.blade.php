<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Staff Assignments Sheet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <p style="text-align: right;"><b>Week of:</b> {{$date}}</p>
        <h1><center>SCICON Staff Assignments</center></h1>
        <table width="100%" border="0">
            <tr>
                @foreach(config('constants.villageTypes') as $typeKey => $typeValue)
                    <td width="{{$typeKey === 'Bear_Creek' ? '66.66' : '33.34'}}%" valign="top">
                        <table width="100%">
                            <tr>
                                <td colspan="{{ $typeKey === 'Bear_Creek' ? 2 : 1}}" ><b>{{ str_replace('_', ' ', $typeKey) }} Village</b> </td>
                            </tr>
                            <tr>
                                @foreach($works->where('is_eagle_point', $typeKey === 'Eagle_Point' ? 'YES' : 'NO') as $key => $work)
                                    @if($key%2 == 1 || $typeKey == 'Eagle_Point')
                                        <th style="text-align:left; font-size:14px;">{{$work->name}}</th>
                                        <td style="font-size:14px;">{{ $users[$userWorkIds[$work->id]??''] ?? '' }}</td>
                                        </tr><tr>
                                    @else
                                        <th style="text-align:left;font-size:14px;">{{$work->name}}</th>
                                        <td style="font-size:14px;">{{ $users[$userWorkIds[$work->id]??''] ?? '' }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        </table>
                    </td>
                    @php if($type === base64_encode('bear')) { break; } @endphp
                @endforeach
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0">
            <tr><td colspan="4">&nbsp;</td></tr>
            <tr><td colspan="4"><b>6th Grade Week Trip</b></td></tr>
            <tr><td colspan="4"></td></tr>
            <tr>
                <th style="text-align: left; border-top: 2px solid #000; border-bottom: 2px solid #000;">School</th>
                <th style="text-align: center; border-top: 2px solid #000; border-bottom: 2px solid #000;">Students</th>
                <th style="text-align: left; border-top: 2px solid #000; border-bottom: 2px solid #000;">Teachers</th>
                <th style="text-align: left; border-top: 2px solid #000; border-bottom: 2px solid #000;" width="20%"></th>
            </tr>
            
            @foreach($schedules->where('type', 'WEEK') as $schedule)
            <tr>
                <td>{{$schedule->school->name}}</td>
                <td style="text-align: center;">{{$schedule->students}}</td>
                <td>{{ str_replace(',',' / ', $schedule->teachers) }}</td>
                <td></td>
            </tr>
            @endforeach
        </table>
        <table width="100%" border="0" cellspacing="0">
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5"><b>5th Grade Day Trip</b></td></tr>
            <tr><td colspan="5"></td></tr>
            <tr>
                <th style="text-align: left; border-top: 2px solid #000; border-bottom: 2px solid #000;">Date</th>
                <th style="text-align: left; border-top: 2px solid #000; border-bottom: 2px solid #000;">School</th>
                <th style="text-align: center; border-top: 2px solid #000; border-bottom: 2px solid #000;">Total Classes</th>
                <th style="text-align: center; border-top: 2px solid #000; border-bottom: 2px solid #000;">Students</th>
                <th style="text-align: left; border-top: 2px solid #000; border-bottom: 2px solid #000;">Teachers</th>
            </tr>
            @foreach($schedules->where('type', 'DAY') as $schedule)
            <tr>
                <td>{{date('m/d/Y l', strtotime($schedule->trip_date))}}</td>
                <td>{{$schedule->school->name}}</td>
                <td style="text-align: center;">{{$schedule->countId}}</td>
                <td style="text-align: center;">{{$schedule->students}}</td>
                <td>{{ str_replace(',',' / ', $schedule->teachers) }}</td>
                
            </tr>
            @endforeach

            <tr><td colspan="4">&nbsp;</td></tr>
            <tr><td colspan="4">&nbsp;</td></tr>
            <tr><td colspan="4"><b>Special Notes</b></td></tr>
            <tr>
                <td colspan="4">  
                    @if($notes)
                        <ol>
                            @foreach($notes as $note)
                                <li>{{ $note }}</li>
                            @endforeach
                        </ol>
                    @endif
                </td>
            </tr>
        </table>
    </body>
</html>