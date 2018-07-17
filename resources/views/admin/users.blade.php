@extends('layouts.main')

@section('title', 'Dashboard')
@section('page_title', 'All Users')

@section('body')
<style type="text/css">
	footer{
		display: none;
	}
	table td,
	table tr{
		vertical-align: middle !important;
	}
</style>
<section id="content">
	<div class="container">
		
		<div class="col-md-12">
			<ol class="breadcrumb">
			  <li><a href="{{route('dashboard.index') }}">Dashboard</a></li>
			  <li class="active">Users</li>
			</ol>			
			<div class="well" style="background: #fff;">
				<h3 style="margin: 15px 0;">Users</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th style="width: 200px;">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
						@if(Auth()->user()->id != $user->id)
							<tr>
								<td>
									{{ $user->id }}
									
								</td>
								<td>
									{{ $user->name }}
								</td>
								<td>
									{{ $user->email }}
								</td>
								<td>
									@if( \App\User::isAdmin($user->id) )
										Admin
									@else
										User
									@endif
								</td>
								<td class="text-center">
									@if( \App\User::isAdmin($user->id) )
										<button style="width: 130px;" class="btn btn-danger" onclick="removeAdmin({{$user->id}})">Remove Admin</button>
									@else
										<button style="width: 130px;" class="btn btn-green" onclick="makeAdmin({{$user->id}})">Make Admin</button>
									@endif
								</td>
							</tr>
						@endif
						@endforeach
					</tbody>
				</table>
				{{ $users->links() }}
			</div>
		</div>
		
	</div>
</section>
<script type="text/javascript">
	function makeAdmin($id) {
        var confirmation = confirm("Are you sure you want to make this user admin?");
        if (confirmation) {
	        $.ajax({
	            url: '/dashboard/make-admin',
	            type: 'POST',
	            data: {
	                _token: $('meta[name="csrf-token"]').attr('content'),
	                id: $id
	            },
	            success: function (data) {
	                location.reload();
	            },
	            error: function(resp){
	                console.log(resp)
	            }
	        });
        }
	}
	function removeAdmin($id) {
        var confirmation = confirm("Are you sure you want to remove this user from administration?");
        if (confirmation) {
	        $.ajax({
	            url: '/dashboard/remove-admin',
	            type: 'POST',
	            data: {
	                _token: $('meta[name="csrf-token"]').attr('content'),
	                id: $id
	            },
	            success: function (data) {
	                location.reload();
	            },
	            error: function(resp){
	                console.log(resp)
	            }
	        });
        }
	}


</script>		
@endsection