<?php

class MainController extends BaseController {

	public function showSearch() 
	{
		$data = array('results' => null);
		if (Input::get('search')) {
			$jobs = Job::query();
			$title = Input::get('job_title_search');
			$location = Input::get('job_title_search');
			$type = Input::get('job_title_search');
			if ($title) {
				$jobs->where('title', 'like', '%'.$title.'%');
			}
			if ($location) {
				$jobs->where('location', $location);
			}
			if ($type) {
				$jobs->where('type', $type);
			}
			$data['results'] = $jobs->get();
		}
		return View::make('search')->with($data);
	}

}
