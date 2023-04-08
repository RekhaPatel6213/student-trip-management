<input type="hidden" id="billTilte" value="{{ $data['title'] }}">

<div class="viewBillFormate">
    <div class="row gx-2">
      <div class="col-3 col-sm-2 fs--1 fw-bold p-1">Pricinpal</div>
      <div class="col">{{ $data['principal_f_name'].' '.$data['principal_l_name'].' | '.$data['schoolName'] }}</div>
    </div>
    <div class="row gx-2">
      <div class="col-3 col-sm-2 fs--1 fw-bold p-1">Subject Line</div>
      <div class="col">{{ $data['subject']}}</div>
    </div>

    <div class="row gx-2">
      <div class="col-3 col-sm-2 fs--1 fw-bold p-1">Sent on</div>
      <div class="col">{{ $data['sent_on']}}</div>
    </div>

    <div class="row gx-2">
      <div class="col-3 col-sm-2 fs--1 fw-bold p-1">Status</div>
      <div class="col billStatus">{{ $data['status']}}</div>
    </div>
</div>
<div class="editBillFormate">
    <div class="row gx-2 mb-2">
      <div class="col-3 col-sm-2 fs--1 fw-medium p-1">Pricinpal</div>
      <div class="col">
        <select name="school_pricinpal" id="billSchoolPricinpal" class="form-select form-select-sm w-50" required>
            <option value="{{ $data['principal_id'] }}" selected>{{ $data['principal_f_name'].' '.$data['principal_l_name'].' | '.$data['schoolName'] }}</option>
        </select>
      </div>
    </div>
    <div class="row gx-2 mb-2">
      <div class="col-3 col-sm-2 fs--1 fw-medium p-1">Subject Line</div>
      <div class="col">
        <input name="subject" id="billSubject" type="text" class="form-control form-control-sm w-50" autocomplete="off" required value="{{ $data['subject'] }}"/>
      </div>
    </div>
</div>
<div class="row gx-2 mb-2">
  <div class="col-3 col-sm-2 fs--1 fw-medium p-1 billName">Bill</div>
  <div class="col">
    <div class="min-vh-50 border rounded-3 p-2 billNameMessage">
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
                <td width="15%">Amount </td>
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
    </div>
  </div>
</div>


 