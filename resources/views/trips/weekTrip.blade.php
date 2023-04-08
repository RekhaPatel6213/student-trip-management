@if($type === 'week')
	@include('trips.weekCalendarView')
@endif

<h5 class="mb-0 text-nowrap py-2 py-xl-0">{{ __('message.week').' '.__('message.trips') }}</h5>

<ul class="nav nav-tabs" id="weekTab" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" id="week-invited-tab" data-bs-toggle="tab" href="#tab-week-invited" role="tab" aria-controls="tab-week-invited" aria-selected="true">Invited {{$tripInvites['weekInvites']->count()}}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="week-pending-tab" data-bs-toggle="tab" href="#tab-week-pending" role="tab" aria-controls="tab-week-pending" aria-selected="true">Pending {{$schedules['weekTotalPendingCount']}}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="week-confirmed-tab" data-bs-toggle="tab" href="#tab-week-confirmed" role="tab" aria-controls="tab-week-confirmed" aria-selected="false">Confirmed {{$schedules['weekTotalConfirmedCount']}}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="week-registered-tab" data-bs-toggle="tab" href="#tab-week-registered" role="tab" aria-controls="tab-week-registered" aria-selected="false">Registered {{$schedules['weekTotalRegisteredCount']}}</a>
	</li>
</ul>

<div class="tab-content" id="weekTabContent">
	<div class="tab-pane fade show active" id="tab-week-invited" role="tabpanel" aria-labelledby="week-invited-tab">
		@if($tripInvites['weekInvites']->count() > 0)
			@include('trips.inviteListTable', ['type'=>$type, 'id'=>'weekInviteListTable', 'invites' => $tripInvites['weekInvites']])
		@else
		<div class="text-center p-5 my-2 bg-primary">
	        <div class="fs--1 mb-3">Ready to kick-off with the new season?<br>Send invites to the schools!</div>
	        <a href="javascript://" class="btn btn-info btn-sm fs--2 w-auto mb-3" type="button" onclick='openInviteSchool("{{$type}}")'>Invite schools</a>
	    </div>
        @endif
	</div>
    <div class="tab-pane fade" id="tab-week-pending" role="tabpanel" aria-labelledby="week-pending-tab">
    	@include('trips.tripListTable', ['type'=>$type, 'id'=>'weekPendingTable', 'schedules' => $schedules['weekPending']])
    </div>
    <div class="tab-pane fade" id="tab-week-confirmed" role="tabpanel" aria-labelledby="week-confirmed-tab">
    	@include('trips.tripListTable', ['type'=>$type, 'id'=>'weekConfirmedTable', 'schedules' => $schedules['weekConfirmed']])
    </div>
    <div class="tab-pane fade" id="tab-week-registered" role="tabpanel" aria-labelledby="week-registered-tab">
    	@include('trips.tripListTable', ['type'=>$type, 'id'=>'weekRegisteredTable', 'schedules' => $schedules['weekRegistered']])
    </div>
</div>