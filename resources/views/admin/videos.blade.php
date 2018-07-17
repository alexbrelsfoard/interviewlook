@extends('layouts.main')

@section('title', 'Dashboard')
@section('page_title', 'All Videos')

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
			  <li class="active">Videos</li>
			</ol>			
			<div class="well" style="background: #fff;">
				<h3 style="margin: 15px 0 25px;font-weight: normal;">Looks videos</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th style="width: 50px; text-align: center;">Id</th>
							<th>User Name</th>
							<th>Question</th>
							<th>Video</th>
							<th>Video Size</th>
							<th>Data Created</th>
							<th style="width: 250px;">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($looks as $key=> $look)
						<tr>
							<td class="text-center">
								{{ $key+1 }}
							</td>
							<td>
								{{ \App\User::userName($look->user_id) }}
							</td>
							<td>
								{{ $look->title }}
							</td>
							<td>
								<a onclick="showVideo({{$look->video_id}})">
									<img width="100" src="{{asset('uploads/thumbnails/'.$look->img_url)}}">
								</a>
							</td>
							<td>
								{{ \App\Models\Look::getVideoSize('uploads/videos/'.$look->video_id.'.webm') }}
							</td>
							<td class="">
								{{$look->created_at->format('m/d/Y')}}
							</td>
							<td class="text-center">
								<button class="btn btn-green" onclick="showVideo({{$look->video_id}})">Show</button>
								<button class="btn btn-danger" onclick="deleteVideo({{$look->id}})">Delete Video</button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				{{ $looks->links() }}
			</div>
		</div>
	</div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Video Preview</h4>
          </div>
          <div class="modal-body">
                <video id="video" controls></video>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
</section>

<script type="text/javascript">
	function showVideo($id) {
		var url = '/uploads/videos/'+$id+'.webm';

        $('#exampleModal').modal('show');
        $('#video').attr('src', url)
	}

	function deleteVideo($id) {
        var confirmation = confirm("Are you sure you want to remove this video?");
        if (confirmation) {
	        $.ajax({
	            url: '/look/delete',
	            type: 'PUT',
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

