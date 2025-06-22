<?php

/**
 * NuraStats - Open source and privacy-friendly web analytics.
 * https://nurastats.com
 *
 * Copyright (c) Chimilevschi Iosif Gabriel
 * LICENSE:
 * Permissions of this strongest copyleft license are conditioned on making available complete source code 
 * of licensed works and modifications, which include larger works using a licensed work, under the same license. 
 * Copyright and license notices must be preserved. Contributors provide an express grant of patent rights. 
 * When a modified version is used to provide a service over a network, the complete source code of the modified version must be made available.
 *    
 * @copyright   Copyright (c) Chimilevschi Iosif Gabriel
 * @license     https://opensource.org/license/agpl-v3  AGPL-3.0 License.
 * @author      Chimilevschi Iosif Gabriel <office@nurasoftware.com>
 */

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserMeta;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{

    /**
     * Display profile page
     */
    public function profile(Request $request)
    {
        $exclude_my_visits = UserMeta::my('exclude_my_visits');
        $last_pw_change_at = UserMeta::my('last_pw_change_at');

        return view('account.index', [
            'view_file' => 'account.profile',
            'active_menu' => 'profile',

            'exclude_my_visits' => $exclude_my_visits ?? null,
            'last_pw_change_at' => $last_pw_change_at ?? null,
        ]);
    }

    /**
     * Update profile
     */
    public function update_profile(Request $request)
    {
        $section = $request->section;

        if (! ($section == 'profile' || $section == 'pw')) return redirect(route('user.profile'));

        $inputs = $request->all(); // retrieve all of the input data as an array 

        if ($section == "profile") {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'email'
            ]);

            if ($validator->fails()) {
                return redirect($request->Url())
                    ->withErrors($validator)
                    ->withInput();
            }

            // check if email exist
            if (User::where('email', $request->email)->where('id', '!=', Auth::user()->id)->exists()) return redirect(route('user.profile'))->with('error', 'duplicate');

            User::where('id', Auth::user()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

            UserMeta::add_meta(Auth::user()->id, 'exclude_my_visits', $request->has('exclude_my_visits') ? 1 : 0);

            if ($request->has('exclude_my_visits')) {
                $cookie = Cookie::queue('nurastats_exclude_me', 1, 100);
            } else {
                Cookie::forget('nurastats_exclude_me');
                Cookie::queue('nurastats_exclude_me', 1, -1);
            }
        }

        if ($section == 'pw') {
            if (!($request->password && $request->password_confirmation && $request->current_password)) return redirect(route('user.profile'))->with('error', 'all_pw_required');

            if (Hash::check($request->current_password, Auth::user()->password)) {

                $validator = Validator::make($request->all(), [
                    'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
                ]);

                if ($validator->fails()) return redirect(route('user.profile'))->withErrors($validator)->withInput();

                User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->password)]);
                UserMeta::add_meta(Auth::user()->id, 'last_pw_change_at', now());
            } else
                return redirect(route('user.profile'))->with('error', 'wrong_current_password');
        }


        return redirect(route('user.profile'))->with('success', 'updated');
    }
}
