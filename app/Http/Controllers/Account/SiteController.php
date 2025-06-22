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
use Illuminate\Support\Str;
use App\Models\Locale;
use Auth;
use App\Models\Site;
use App\Models\SiteUser;
use App\Models\LogPage;
use App\Models\LogVisitor;
use App\Models\LogSession;
use App\Models\StatsMain;
use App\Models\StatsRecent;
use App\Models\StatusChecker;
use App\Models\UserMeta;
use App\Models\Event;
use App\Models\ErrorPage;
use Illuminate\Support\Facades\Hash;

class SiteController extends Controller
{

    public function __construct(Request $request) {}

    /**
     * Show all resources
     */
    public function index(Request $request)
    {
        $search_terms = $request->search_terms;
        $openmodal = $request->openmodal; // for automatic open modal to create item                

        $sites = Site::orderByDesc('active')->orderByDesc('favourite')->orderBy('label')->orderByDesc('id')->where('user_id', Auth::user()->id);

        if ($search_terms) $sites = $sites->where(function ($query) use ($search_terms) {
            $query->where('url', 'like', "%$search_terms%")
                ->orWhere('label', 'like', "%$search_terms%");
        });

        $sites = $sites->paginate(20);

        $count_actions_this_month = UserMeta::my('count_actions_this_month');
        $count_actions_this_month_updated_at = UserMeta::my('count_actions_this_month_updated_at');

        return view('account.index', [
            'view_file' => 'sites.index',
            'active_menu' => 'sites',
            'search_terms' => $search_terms,
            'sites' => $sites,
            'openmodal' => $openmodal,
            'timezones_array' => Locale::generate_timezone_list(),
            'count_actions_this_month' => $count_actions_this_month,
            'count_actions_this_month_updated_at' => $count_actions_this_month_updated_at
        ]);
    }


    /**
     * Create resource
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|max:25',
            'url' => 'required|min:4|max:200',
            'timezone' => 'required',
        ]);

        if ($validator->fails()) return redirect(route('sites.index'))->withErrors($validator)->withInput();

        $url = $request->url;
        $url = str_replace('https://', '', $url);
        $url = str_replace('http://', '', $url);

        $site = Site::create([
            'code' => strtoupper(Str::random(10)),
            'label' => $request->label,
            'url' => $request->url,
            'active' => $request->has('active') ? 1 : 0,
            'allow_subdomains' => $request->has('allow_subdomains') ? 1 : 0,
            'nura_status' => 'active',
            'timezone' => $request->timezone ?? 'Europe/London',
            'user_id' => Auth::user()->id,
        ]);

        SiteUser::create([
            'site_id' => $site->id,
            'user_id' => Auth::user()->id,
            'role' => 'admin',
        ]);

        return redirect(route('site.config', ['code' => $site->code]))->with('success', 'created');
    }


    /**
     * Update resource
     */
    public function update(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('sites.index'));

        $validator = Validator::make($request->all(), [
            'label' => 'required|max:25',
        ]);

        if ($validator->fails()) return redirect(route('site.config', ['code' => $site->code]))->withErrors($validator)->withInput();

        Site::where('id', $site->id)->update([
            'label' => $request->label,
            'active' => $request->has('active') ? 1 : 0,
            'allow_subdomains' => $request->has('allow_subdomains') ? 1 : 0,
            'favourite' => $request->has('favourite') ? 1 : 0,
            'timezone' => $request->timezone ?? 'Europe/London',
        ]);

        return redirect(route('site.config', ['code' => $site->code]))->with('success', 'updated');
    }


    /**
     * Remove the specified resource
     */
    public function destroy(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('sites.index'));

        if (!$request->verify_password) return redirect(route('site.config', ['code' => $site->code]));
        if (! Hash::check($request->verify_password, Auth::user()->password)) return redirect(route('site.config', ['code' => $site->code]))->with('error', 'wrong_password');

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('sites.index'));

        LogSession::where('site_id', $site->id)->delete();
        LogVisitor::where('site_id', $site->id)->delete();
        LogPage::where('site_id', $site->id)->delete();
        StatsMain::where('site_id', $site->id)->delete();
        StatsRecent::where('site_id', $site->id)->delete();
        StatusChecker::where('site_id', $site->id)->delete();
        Site::where('id', $site->id)->delete();
        SiteUser::where('site_id', $site->id)->delete();
        Event::where('site_id', $site->id)->delete();
        ErrorPage::where('site_id', $site->id)->delete();

        return redirect(route('sites.index'))->with('success', 'deleted');
    }


    /**
     * Website config
     */
    public function config(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('sites.index'));

        return view('account.index', [
            'view_file' => 'sites.config',
            'active_menu' => 'sites',
            'site' => $site,
            'timezones_array' => Locale::generate_timezone_list(),
        ]);
    }
}
