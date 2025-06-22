<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class LogoutController extends Controller
{



    /**
     * Show all resources
     */
    public function logout(Request $request)
    {

        $user_id = Auth::user()->id ?? null;

        if ($user_id) {
            DB::connection('central')->table('sessions')->where('user_id', $user_id)->delete();

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }

        return redirect(route('home'));
    }
}
