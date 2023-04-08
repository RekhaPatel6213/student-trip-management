@if($type === 'day')
	@include('trips.dayCalendarView')
@endif

<h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ __('message.day').' '.__('message.trips') }}</h5>

<ul class="nav nav-tabs" id="dayTab" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" id="day-invited-tab" data-bs-toggle="tab" href="#tab-day-invited" role="tab" aria-controls="tab-day-invited" aria-selected="true">Invited {{$tripInvites['dayInvites']->count()}}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="day-pending-tab" data-bs-toggle="tab" href="#tab-day-pending" role="tab" aria-controls="tab-day-pending" aria-selected="true">Pending  {{$schedules['dayTotalPendingCount']}}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="day-confirmed-tab" data-bs-toggle="tab" href="#tab-day-confirmed" role="tab" aria-controls="tab-day-confirmed" aria-selected="false">Confirmed {{$schedules['dayTotalConfirmedCount']}}</a>
	</li>
	<!-- <li class="nav-item">
		<a class="nav-link" id="day-registered-tab" data-bs-toggle="tab" href="#tab-day-registered" role="tab" aria-controls="tab-day-registered" aria-selected="false">Registered {{--$schedules['dayTotalRegisteredCount']--}}</a>
	</li> -->
</ul>

<div class="tab-content" id="dayTabContent">
	<div class="tab-pane fade show active" id="tab-day-invited" role="tabpanel" aria-labelledby="day-invited-tab">
		@if($tripInvites['dayInvites']->count() > 0)
			@include('trips.inviteListTable', ['type'=>$type, 'id'=>'dayInviteListTable', 'invites' => $tripInvites['dayInvites']])
		@else
		<div class="text-center p-5 my-2 bg-primary">
	        <div class="fs--1 mb-3">Ready to kick-off with the new season?<br>Send invites to the schools!</div>
	        <a href="javascript://" class="btn btn-info btn-sm fs--2 w-auto mb-3" type="button" onclick='openInviteSchool("{{$type}}")'>Invite schools</a>
	    </div>
        @endif
	</div>
    <div class="tab-pane fade show" id="tab-day-pending" role="tabpanel" aria-labelledby="day-pending-tab">
    	@include('trips.tripListTable', ['type'=>$type, 'id'=>'dayPendingTable', 'schedules' => $schedules['dayPending']])
    </div>
    <div class="tab-pane fade" id="tab-day-confirmed" role="tabpanel" aria-labelledby="day-confirmed-tab">
    	@include('trips.tripListTable', ['type'=>$type, 'id'=>'dayConfirmedTable', 'schedules' => $schedules['dayConfirmed']])
    </div>
    <!-- <div class="tab-pane fade" id="tab-day-registered" role="tabpanel" aria-labelledby="day-registered-tab">
    	{{-- @include('trips.tripListTable', ['type'=>$type, 'id'=>'dayRegisteredTable', 'schedules' => $schedules['dayRegistered']]) --}}
    </div> -->
</div>