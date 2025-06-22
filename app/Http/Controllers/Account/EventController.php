<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\LogSession;
use App\Models\Site;
use App\Models\SiteUser;
use App\Models\Event;
use Auth;

class EventController extends Controller
{

    public function __construct(Request $request) {}

    /**
     * Show all resources
     */
    public function index(Request $request)
    {
        $search_event = $request->search_event;

        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        $events = Event::where('site_id', $site->id)->orderByDesc('id')->get();

        $actions = LogSession::with('page', 'visitor', 'event')->whereNotNull('event_id');

        if($search_event) {
            $event = Event::where('code', $search_event)->where('site_id', $site->id)->first();
            if($event) $actions = $actions->where('event_id', $event->id);
        }
        
        $actions = $actions->orderByDesc('id')->paginate(25);

        return view('user.index', [
            'view_file' => 'events.index',
            'active_menu' => 'events',
            'site' => $site,
            'search_event' => $search_event,
            'actions' => $actions,
            'events' => $events,
        ]);        
    }


     /**
     * Show all resources
     */
    public function manage(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        $search_terms = $request->search_terms;
        $openmodal = $request->openmodal; // for automatic open modal to create item                

        $events = Event::where('site_id', $site->id)->orderByDesc('id');

        if ($search_terms) $events = $events->where(function ($query) use ($search_terms) {
            $query->where('code', 'like', "%$search_terms%")
                ->orWhere('label', 'like', "%$search_terms%");
        });

        $events = $events->paginate(20);

        return view('user.index', [
            'view_file' => 'events.manage',
            'active_menu' => 'events',
            'site' => $site,
            'search_terms' => $search_terms,
            'events' => $events,
            'openmodal' => $openmodal,
        ]);
    }

    /**
     * Create resource
     */
    public function store(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        $validator = Validator::make($request->all(), [
            'label' => 'required|max:25',
            'type' => 'required',
        ]);

        if ($validator->fails()) return redirect(route('user.site.events.manage', ['code' => $site->code]))->withErrors($validator)->withInput();

        if (Event::where('site_id', $site->id)->where('label', $request->label)->exists()) return redirect(route('user.site.events', ['code' => $site->code]))->with('error', 'duplicate_label');

        $event = Event::create([
            'code' => generateRandomInteger(15),
            'site_id' => $site->id,
            'label' => $request->label,
            'type' => $request->type,
            'description' => $request->description ?? null,
            'active' => $request->has('active') ? 1 : 0,
            'created_by_user_id' => Auth::user()->id,
        ]);

        return redirect(route('user.site.events.manage', ['code' => $site->code]))->with('success', 'created');
    }


    /**
     * Update resource
     */
    public function update(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        $event = Event::where('code', $request->event_code)->where('site_id', $site->id)->first();
        if (!$event) return redirect(route('user.site.events.manage', ['code' => $site->code]));

        $validator = Validator::make($request->all(), [
            'label' => 'required|max:25',
        ]);

        if ($validator->fails()) return redirect(route('user.site.event.config', ['code' => $site->code, 'event_code' => $event->code]))->withErrors($validator)->withInput();

        if (Event::where('site_id', $site->id)->where('label', $request->label)->where('id', '!=', $event->id)->exists()) return redirect(route('user.site.event.config', ['code' => $site->code, 'event_code' => $event->code]))->with('error', 'duplicate_label');

        $event->update([
            'label' => $request->label,
            'description' => $request->description ?? null,
            'active' => $request->has('active') ? 1 : 0,
        ]);

        return redirect(route('user.site.event.config', ['code' => $site->code, 'event_code' => $event->code]))->with('success', 'updated');
    }


    /**
     * Remove the specified resource
     */
    public function destroy(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        $event = Event::where('code', $request->event_code)->where('site_id', $site->id)->first();
        if (!$event) return redirect(route('user.site.events.manage', ['code' => $site->code]));

        LogSession::where('site_id', $site->id)->where('event_id', $event->id)->update(['event_id' => null]);
        Event::where('site_id', $site->id)->where('id', $event->id)->delete();        

        return redirect(route('user.site.events.manage', ['code' => $site->code]))->with('success', 'deleted');
    }


    /**
     * Event config
     */
    public function config(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        $event = Event::where('code', $request->event_code)->where('site_id', $site->id)->first();
        if (!$event) return redirect(route('user.site.events.manage', ['code' => $site->code]));

        return view('user.index', [
            'view_file' => 'events.config',
            'active_menu' => 'events',
            'site' => $site,
            'event' => $event,
        ]);
    }


     /**
     * Event stats
     */
    public function show(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        $event = Event::where('code', $request->event_code)->where('site_id', $site->id)->first();
        if (!$event) return redirect(route('user.site.events', ['code' => $site->code]));

        $actions = LogSession::with('page', 'visitor')->where('event_id', $event->id)->orderByDesc('id')->paginate(25);

        return view('user.index', [
            'view_file' => 'events.show',
            'active_menu' => 'events',
            'site' => $site,
            'event' => $event,
            'actions' => $actions,
        ]);
    }
}
