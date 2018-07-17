@extends('layouts.main')

@section('title', 'My Looks')
@section('page_title', 'My Looks')

@section('body')
<section style="margin-top: 30px" >
	<div class="container">
		<div class="row col-md-12">
			<div class="col-md-12 ">
				<ol class="breadcrumb" style="margin: 0">
				  <li class="">
				  	<a href="{{ route('look.index') }}">All Looks</a>
				  </li>
				  <li class="active">Create Look</li>
				</ol>			
			</div>
		</div>
	</div>
</section>

<div class="" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Create New Look</h4>
      </div>
      <form action="{{route('add.interview')}}" method="post">
	      <div class="modal-body">
      		{{csrf_field()}}
		    <label style="font-weight: bold; margin-bottom: 10px; display: block;">Look Title</label>
	      	<input class="form-control" name="title" placeholder="Look Title" required="">
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Submit</button>
	      </div>
	  </form>
    </div>
  </div>
</div>
	
@endsection