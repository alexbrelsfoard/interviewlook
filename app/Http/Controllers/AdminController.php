<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Look;
use App\Admin;
use Auth;

class AdminController extends Controller
{
    public function index() {

    	return view('admin.index');

    }

    public function users() {
    	$users = User::paginate(5);
    	return view('admin.users')->withUsers($users);
    }

    public function videos() {
    	$looks = Look::paginate(5);
    	return view('admin.videos')->withLooks($looks);
    }

    public function makeAdmin(Request $request) {
    	$admin = new Admin;
    	$admin->user_id = $request->id;
    	$admin->save();

    }

    public function removeAdmin(Request $request) {
    	if($request->id != Auth::user()->id ){
	        $admin = Admin::where('user_id', $request->id)->first();
	        $admin->delete();
    	}
    }


}
