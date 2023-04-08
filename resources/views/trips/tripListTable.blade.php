<div id="{{ $id }}" data-list='{"page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
  	<div class="table-responsive scrollbar">
    	<table class="table table-striped fs--1 mb-0 overflow-hidden">
      		<thead class="bg-200 text-900">
		        <tr>
					<th class="">School</th>
					<th class=" text-center {{ ($type === 'day' && $id === 'dayPendingTable') ? 'd-none' : '' }}">Days</th>
					<th class="">Preferred Date</th>
					<th class=" text-center">Students</th>
					<th class="">Teacher</th>
					@if(in_array($id, ['dayConfirmedTable', 'weekConfirmedTable']))
						<th class="">Confirmation Letters</th>
					@endif
					@if(in_array($id, ['weekConfirmedTable']))
						<th class="">Bill Status</th>
						<th class="">Class Reg</th>
						<th class="">Meal Reg</th>
					@endif
					<th class="text-end no-sort"></th>
		        </tr>
	      	</thead>
	      	<tbody class="list">
		      	@if(count($schedules) > 0)
                    @foreach($schedules as $schedule)
				        <tr>
							<td class="school">
								@if(in_array($schedule->status, ['REGISTERED','CONFIRMED']) && $type === 'week')
									<a href="{{ route('schedule.trip.class.info',[base64_encode($schedule->id)]) }}" target="_blank">{{ $schedule->school->name }}</a>
								@else
									<a href="javascript://" onclick="editTripList({{$schedule->id}})">{{ $schedule->school->name }}</a>
								@endif
							</td>
							<td class="days text-center {{ ($type === 'day' && $id === 'dayPendingTable') ? 'd-none' : '' }}">{{ $schedule->days }}</td>
							<td class="preferredTripDate">{{ $schedule->trip_date }}</td>
							<td class="students text-center">{{ $schedule->students }}</td>
							<td class="teacher">{{ ucwords($schedule->teacher) }}</td>
							@if(in_array($id, ['dayConfirmedTable', 'weekConfirmedTable']))
							<td class="confirmation">
								@if($schedule->confirmation_send === 'YES')
									<span class="text-scicon">Sent</span>
								@else
									<button class="btn btn-success btn-sm d-block fs--2" type="button" onclick="getConfirmationLatter('{{ $type }}', {{$schedule->id}})">Send Letters</button>
								@endif
							</td>
							@endif
							@if(in_array($id, ['weekConfirmedTable']))
								<td class="bill">
									@if($schedule->bill_send === 'NO')
										<button class="btn btn-success btn-sm d-block fs--2 tripListBill_{{$schedule->id}}" data-id="{{$schedule->id}}" type="button" onclick="billLatter('tripListBill_{{$schedule->id}}')">View</button>
									@else
										<a href="javascript://" class="text-scicon tripViewBill_{{$schedule->id}}" data-id="{{$schedule->id}}" onclick="billLatter('tripViewBill_{{$schedule->id}}', true)">{{ ucfirst(strtolower($schedule->bill_status)) }}</a>
									@endif
								</td>
								<td>{{ $schedule->student_info_count > 0 ? 'Completed' : 'Pending' }}</td>
								<td>{{ $schedule->meal_signature !== null ? 'Completed' : 'Pending' }}</td>
							@endif
							<td class="text-end d-flex justify-content-end pe-1">
								@if(in_array($id, ['dayPendingTable', 'weekPendingTable']))
									<button class="btn btn-info btn-sm d-block fs--2" type="button" onclick="confirmDate('{{ $type }}', {{$schedule->id}})">ConFirm Date</button>
								@endif

								@if(in_array($id, ['weekConfirmedTable']))
									<button class="btn btn-primary btn-sm d-block fs--2" type="button" onclick="confirmListTrip('{{ $type }}', {{$schedule->id}})">ConFirm</button>
								@endif

								@if(in_array($id, ['weekRegisteredTable']))
									<button type="button" class="btn btn-sm btn-outline-success"><span class="fas fa-print"></span></button>
								@endif

								<div class="dropdown font-sans-serif position-static">
						            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-v fs--1"></span></button>
						            <!-- <div class="dropdown-menu dropdown-menu-end border py-0">
						              <div class="bg-white py-2">
						              	<a class="dropdown-item" href="#!">Edit</a>
						              	<a class="dropdown-item text-danger" href="#!">Delete</a>
						              </div>
						            </div> -->
						        </div>
							</td>
				        </tr>
				    @endforeach
                @else
                  	<tr><td colspan="7">No records found.</td></tr>
                @endif
	      	</tbody>
    	</table>
  	</div>
  	<div class="d-flex justify-content-center mt-3">
	    <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
	    <ul class="pagination mb-0"></ul>
	    <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
  	</div>
</div>