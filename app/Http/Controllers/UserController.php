<?php

namespace App\Http\Controllers;

use App\Models\Metric;
use App\Models\Privacy;
use App\Models\Profile;
use App\Models\Social;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Storage;

class UserController extends Controller
{

    public function profile($username)
    {
        $user = User::where('username', $username)->with('profile', 'social', 'privacy', 'metrics')->first();
        if ($user) {
            if ($user->id != auth()->user()->id) {
                $viewed_by = auth()->check() ? auth()->user()->id : 0;
                $metrics_array = [
                    'user_id' => $user->id,
                    'viewed_by' => $viewed_by,
                    'ip' => request()->ip(),
                ];
                $metrics = Metric::where([
                    'user_id' => $user->id,
                    'viewed_by' => $viewed_by,
                    'ip' => request()->ip(),
                ])->pluck('id')->first();
                if (!$metrics) {
                    Metric::create($metrics_array);
                }
            }
            $metrics_count = Metric::where('user_id', $user->id)->count();
            $latest_metric = Metric::where('user_id', $user->id)->orderBy('id', 'desc')->first();
            return view('user.profile', compact('user', 'metrics_count', 'latest_metric'));
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
            'email' => 'required|string|email|unique:users,email,' . auth()->user()->id,
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|dimensions:min_width=200,min_height=200',
            'industry_summary' => 'required|max:191',
            'current_position' => 'required|max:191',
            'current_company' => 'required|max:191',
            'current_location' => 'required|max:191',
            'skills' => 'required|max:191',
            'facebook' => 'nullable|max:191|url',
            'twitter' => 'nullable|max:191|url',
            'instagram' => 'nullable|max:191|url',
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
            User::where('id', auth()->user()->id)->update(['email' => $request->input('email')]);

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
            if ($request->hasFile('photo')) {
                $file_path = 'user';
                if (!is_dir(public_path($file_path))) {
                    mkdir(public_path($file_path), 0777);
                }
                $photo = auth()->user()->username . '.' . $request->file('photo')->getClientOriginalExtension();
                Storage::disk('user')->put($photo, file_get_contents($request->file('photo')));
                $photo_path = url('user/' . $photo);
                $profile_array['photo'] = $photo_path;
            }

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

            return redirect()->route('user.profile', auth()->user()->username);
        }
    }
}
