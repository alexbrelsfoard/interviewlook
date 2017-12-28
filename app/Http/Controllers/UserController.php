<?php

namespace App\Http\Controllers;

use App\Models\Privacy;
use App\Models\Profile;
use App\Models\Social;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class UserController extends Controller
{

    public function profile($username)
    {
        $user = User::where('username', $username)->with('profile', 'social', 'privacy')->first();
        if ($user) {
            return view('user.profile', compact('user'));
        } else {
            return view('errors.404');
        }
    }

    public function edit()
    {
        $user = User::where('id', auth()->user()->id)->with('profile', 'social', 'privacy')->first();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $v = Validator::make($request->all(), [
            'industry_summary' => 'required|max:191',
            'current_position' => 'required|max:191',
            'current_company' => 'required|max:191',
            'current_location' => 'required|max:191',
            'skills' => 'required|max:191',
            'facebook' => 'required|max:191',
            'twitter' => 'required|max:191',
            'instagram' => 'required|max:191',
            'current_position_privacy' => 'required',
            'current_company_privacy' => 'required',
            'current_location_privacy' => 'required',
            'preferred_location_privacy' => 'required',
            'years_experience_privacy' => 'required',
            'highest_degree_privacy' => 'required',
            'industry_summary_privacy' => 'required',
            'skills_privacy' => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        } else {
            $profile = Profile::where('user_id', auth()->user()->id)->first();
            $social = Social::where('user_id', auth()->user()->id)->first();
            $privacy = Privacy::where('user_id', auth()->user()->id)->first();
            $profile_array = [
                'user_id' => auth()->user()->id,
                'current_position' => $request->input('current_position'),
                'current_company' => $request->input('current_company'),
                'current_location' => $request->input('current_location'),
                'preferred_location' => $request->input('preferred_location'),
                'years_experience' => $request->input('years_experience'),
                'highest_degree' => $request->input('highest_degree_other') ? $request->input('highest_degree_other') : $request->input('highest_degree'),
                'industry_summary' => $request->input('industry_summary'),
                'skills' => $request->input('skills'),
            ];
            $social_array = [
                'user_id' => auth()->user()->id,
                'facebook' => $request->input('facebook'),
                'twitter' => $request->input('twitter'),
                'instagram' => $request->input('instagram'),
            ];

            $privacy_array = [
                'user_id' => auth()->user()->id,
                'current_position' => $request->input('current_position_privacy'),
                'current_company' => $request->input('current_company_privacy'),
                'current_location' => $request->input('current_location_privacy'),
                'preferred_location' => $request->input('preferred_location_privacy'),
                'years_experience' => $request->input('years_experience_privacy'),
                'highest_degree' => $request->input('highest_degree_privacy'),
                'industry_summary' => $request->input('industry_summary_privacy'),
                'skills' => $request->input('skills_privacy'),
            ];

            if ($profile) {
                $updated = Profile::where('user_id', auth()->user()->id)->update($profile_array);

            } else {
                $updated = Profile::create($profile_array);
            }

            if ($social) {
                Social::where('user_id', auth()->user()->id)->update($social_array);

            } else {
                Social::create($social_array);
            }

            if ($privacy) {
                Privacy::where('user_id', auth()->user()->id)->update($privacy_array);

            } else {
                Privacy::create($privacy_array);
            }
            if ($updated) {
                Session::flash('alert-success', 'Profile updated successfully.');
            } else {
                Session::flash('alert-danger', 'Something went wrong. Please try again.');
            }

            return redirect()->route('profile.edit');
        }
    }
}
