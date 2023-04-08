<div id="{{ $id }}" data-list='{"valueNames":["school","date","remindDate","status"], "page":{{ config("constants.PAGE_LENGTH") }}, "pagination":true}'>
  	<div class="table-responsive scrollbar">
    	<table class="table table-striped fs--1 mb-0 overflow-hidden">
      		<thead class="bg-200 text-900">
		        <tr>
					<th class="" data-sort="school">School</th>
					<th class="text-center" data-sort="date">Invited On</th>
					<th class="text-center" data-sort="remindDate">Reminded On</th>
					<th class="" data-sort="status">Status</th>
					<th class="text-end no-sort"></th>
		        </tr>
	      	</thead>
	      	<tbody class="list">
		      	@if(count($invites) > 0)
                    @foreach($invites as $invite)
				        <tr>
							<td class="school"> <a href="{{ route('schools.edit', $invite->school->id)}}" target="_blank">{{ $invite->school->name }}</a></td>
							<td class="date text-center">{{$invite->created_at}}</td>
							<td class="remindDate text-center">{{$invite->remind_date}}</td>
							<td class="status">{{ $invite->status === 'SEND' ? 'Invite Sent' : ucfirst(strtolower($invite->status)) }}</td>
							<td class="text-end d-flex justify-content-end pe-1">
								
								<button class="btn btn-secondary btn-sm d-block fs--2" type="button" onclick="remind('{{ $type }}', {{$invite->school->id}})">Remind</button>
								
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