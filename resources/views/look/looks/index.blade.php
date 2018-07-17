@extends('layouts.main')

@section('title', 'My Looks')
@section('page_title', 'My Looks')

@section('body')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Look</h4>
      </div>
      <form action="{{route('add.interview')}}" method="post">
	      <div class="modal-body">
      		{{csrf_field()}}
		    <label style="font-weight: bold; margin-bottom: 10px; display: block;">Look Title</label>
	      	<input class="form-control" name="title" placeholder="Look Title" required="">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Submit</button>
	      </div>
	  </form>
    </div>
  </div>
</div>

<section id="content">
	<div class="container">
		<div class="col-md-12">
			<div style="overflow: hidden; margin-bottom: 20px">
				<button class="btn btn-green pull-right" data-toggle="modal" data-target="#myModal">Add New Look</button>
			</div>
			<div class="well" style="background: #fff;">
				<table class="table" style="margin: 0;">
					<thead>
						<tr>
							<th style="width: 50px;">Id</th>
							<th>Title</th>
							<th style="width: 200px;">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($interviews as $interview)
							<tr>
								<td>
									{{ $interview->id }}
									
								</td>
								<td>
									<a class="interview-title" href="{{ route('look.show', $interview->id) }}">{{ $interview->title }}</a>
								</td>
								<td class="text-left">
									<a class="btn btn-green" href="{{ route('look.show', $interview->id) }}">Show</a>
									<a class="btn btn-warning" href="{{ route('look.edit', $interview->id) }}">Edit</a>
									<a class="btn btn-danger" onclick="deleteInterview({{$interview->id}})">Delete</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{ $interviews->links() }}
			</div>
		</div>
	</div>
</section>
<style type="text/css">
	table th,
	table td{
		vertical-align: middle !important;
	}
	.interview-title {
		color: #333;
		text-decoration: none !important;
	}
	.interview-title:hover {
		color: #898989 !important;
		transition: none;
	}

</style>
<script type="text/javascript">
	function deleteInterview(id) {
        var confirmation = confirm("Are you sure you want to remove this Look and its videos?");
        if (confirmation) {
	        $.ajax({
	            url: '/look/delete',
	            type: 'PUT',
	            data: {
	                _token: $('meta[name="csrf-token"]').attr('content'),
	                id: id
	            },
	            dataType: 'JSON',
	        });
			location.reload();
        }
	}
</script>
@endsection