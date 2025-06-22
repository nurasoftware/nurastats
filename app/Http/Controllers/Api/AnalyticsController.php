<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ErrorPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Site;
use App\Models\LogSession;
use App\Models\LogVisitor;
use App\Models\LogPage;
use App\Models\Event;
use App\Models\Helpers;
use Browser;
use \PulkitJalan\IPGeolocation\IPGeolocation as GeoIP;

class AnalyticsController extends Controller
{

    public function analytic(Request $request)
    {
    
        $ip = $request->ip();
        $json_data = $request->getContent();
        $data = json_decode(($json_data));

        if (! ($data->site ?? null)) return;
        if (! ($data->tracking_id ?? null)) return;

        //Log::info($json_data);

        $geo = new GeoIP();
        $geo->setIp($ip);
        $geo_all = $geo->getRaw();
        $geo_cc = $geo_all['countryCode'] ?? null;
        $geo_country = $geo_all['country'] ?? null;
        $geo_region = $geo_all['region'] ?? null;
        $geo_city = $geo_all['city'] ?? null;
        $geo_region_name = $geo_all['regionName'] ?? null;
        $geo_lat = $geo_all['lat'] ?? null;
        $geo_long = $geo_all['lon'] ?? null;
        $geo_isp = $geo_all['isp'] ?? null;

        $anonymized_ip = $this->anonymize($ip);

        $browser = Browser::parse($data->userAgent);

        $deviceType = $browser->deviceType(); // [Mobile, Tablet, Desktop, or Bot]
        $deviceTypeDb = strtolower(substr($deviceType, 0, 1)); // m, t, d or b

        $isBot = $browser->isBot();

        // do not track bots
        if ($isBot) return;
        if ($deviceTypeDb == 'b') return;

        $platformName = $browser->platformName(); // Windows XP, Mac 10...
        $platformName = substr($platformName, 0, 60);

        $platformFamily = $browser->platformFamily(); // Linux, Windows, Mac...
        $platformFamily = substr($platformFamily, 0, 25);

        $platformVersion = $browser->platformVersion();
        $platformVersion = substr($platformVersion, 0, 25);

        $browserName = $browser->browserName(); // Browser's human friendly name like Firefox 3.6, Chrome 42.
        $browserName = substr($browserName, 0, 60);

        $browserFamily = $browser->browserFamily(); // Browser's vendor like Chrome, Firefox, Opera.
        $browserFamily = substr($browserFamily, 0, 25);

        $browserVersion = $browser->browserVersion(); // Browser's human friendly version string.	
        $browserVersion = substr($browserVersion, 0, 25);

        $deviceFamily = $browser->deviceFamily(); // Device's vendor like Samsung, Apple, Huawei.	
        $deviceFamily = substr($deviceFamily, 0, 25);

        $deviceModel = $browser->deviceModel(); // Device's brand name like iPad, iPhone, Nexus.
        $deviceModel = substr($deviceModel, 0, 60);

        if ($data->screenWidth && $data->screenHeight) {
            $screen_size = $data->screenWidth . 'x' . $data->screenHeight;
            $screen_size = substr($screen_size, 0, 15);
        }



        $site = Site::where('code', $data->site ?? null)->where('active', 1)->where('clevada_status', 'active')->first();
        if ($site) {

            // check if request come from this valid site
            // check if site exists and is verified
            $js_referrer = $request->headers->get('referer');
            $js_referrer_host = Helpers::get_host($js_referrer);

            
            if(! Helpers::check_source_destination_host($js_referrer_host, $site->url, $allow_subdomains = $site->allow_subdomains)) {
                Log::info('Source & destination FAILED for '.$data->site.'. Site url: '.$site->url.'. JavaScript referrer host: '.$js_referrer_host);
                return;
            }


            // 404/Error page tracker
            if (($data->isErrorPage ?? null) == 1) {

                $errorPageData = array([
                    'ip' => $anonymized_ip,
                    'device_type' => $deviceTypeDb,
                    'platform_family' => $platformFamily,
                    'platform_name' => $platformName,
                    'platform_version' => $platformVersion,
                    'browser_family' => $browserFamily,
                    'browser_name' => $browserName,
                    'device_family' => $deviceFamily,
                    'device_model' => $deviceModel,
                    'geo_cc' => $geo_cc ?? null,
                    'geo_country' => $geo_country ?? null,
                    'geo_region' => $geo_region ?? null,
                    'geo_region_name' => $geo_region_name ?? null,
                    'geo_city' => $geo_city ?? null,
                ]);
                ErrorPage::create(['site_id' => $site->id, 'path' => $data->page, 'referrer' => $data->referrer, 'data' => json_encode($errorPageData)]);

                $counter = ErrorPage::where(['site_id' => $site->id, 'path' => $data->page])->count();
                ErrorPage::where(['site_id' => $site->id, 'path' => $data->page])->update(['counter' => $counter]);

                return;
            }

            $hashed_string = $ip . $data->userAgent;
            $visitor_hash = md5($hashed_string);
            $page_hash = md5($data->domain . $data->page);

            // 1. Add visited page if not exists           
            $page = LogPage::where(['site_id' => $site->id, 'hash' => $page_hash])->first();
            if ($page)
                $page->increment('views');
            else
                $page = LogPage::create(['site_id' => $site->id, 'hash' => $page_hash, 'domain' => $data->domain, 'page' => $data->page, 'title' => $data->title]);


            // 2. Check if VISITOR exists. Visitor is identified by IP+UserAgent hash
            LogVisitor::updateOrCreate(
                ['site_id' => $site->id, 'hash' => $visitor_hash],
                [
                    'ip' => $anonymized_ip,
                    'device_type' => $deviceTypeDb,
                    'platform_family' => $platformFamily,
                    'platform_name' => $platformName,
                    'platform_version' => $platformVersion,
                    'browser_family' => $browserFamily,
                    'browser_name' => $browserName,
                    'browser_version' => $browserVersion,
                    'device_family' => $deviceFamily,
                    'device_model' => $deviceModel,
                    'screen_size' => $screen_size ?? null,
                    'geo_cc' => $geo_cc ?? null,
                    'geo_country' => $geo_country ?? null,
                    'geo_region' => $geo_region ?? null,
                    'geo_region_name' => $geo_region_name ?? null,
                    'geo_city' => $geo_city ?? null,
                    'geo_isp' => $geo_isp ?? null,
                    'geo_lat' => $geo_lat ?? null,
                    'geo_long' => $geo_long ?? null,
                ]
            )->increment('count_visits');

            // 3. Check if session exists for this visitor            
            if (LogSession::where('hash', $data->tracking_id)->exists()) {
                LogSession::where('hash', $data->tracking_id)->update(['last' => time()]);
                //Log::info('EXISTING SESSION');
                if ($data->scroll_percent ?? null) {
                    LogSession::where('hash', $data->tracking_id)->where('scroll_percent', '<', $data->scroll_percent)->update(['scroll_percent' => $data->scroll_percent ?? null]);
                }
            } else {
                //Log::info('NEW SESSION');
                // Store new session
                $visitor = LogVisitor::where(['site_id' => $site->id, 'hash' => $visitor_hash])->first();

                $isNoFoundPage = $data->isNoFoundPage ?? null;
                if ($isNoFoundPage == 1) $is_404 = 1;

                if ($data->referrer ?? null) $referrer_host = Helpers::get_host($data->referrer);

                $session = LogSession::create([
                    'hash' => $data->tracking_id,
                    'visitor_id' => $visitor->id,
                    'site_id' => $site->id,
                    'page_id' => $page->id,
                    'referrer' => $data->referrer,
                    'referrer_host' => $referrer_host ?? null,
                    'first' => time(),
                    'last' => null,
                    'scroll_percent' => $data->scroll_percent ?? 0,
                    'created_at' => now()
                ]);
            }
        }

        return;
    }




    public function time_event(Request $request)
    {
        $json_data = $request->getContent();
        $data = json_decode(($json_data));

        if (! ($data->site ?? null)) return;
        if (! ($data->tracking_id ?? null)) return;

        // check if request come from this valid site
        // check if site exists and is verified
        // TODO ...................
        // check if site exists and is verified

        $site = Site::where('code', $data->site ?? null)->where('active', 1)->where('clevada_status', 'active')->first();
        if ($site) {
            LogSession::where('hash', $data->tracking_id)->update(['seconds_min' => $data->seconds_min]);
        }

        return;
    }


    public function track_event(Request $request)
    {
        $json_data = $request->getContent();
        $data = json_decode(($json_data));

        if (! ($data->site ?? null)) return;
        if (! ($data->event_id ?? null)) return;
        if (! ($data->tracking_id ?? null)) return;

        $site = Site::where('code', $data->site ?? null)->first();
        if (! $site) return;

        // check if request come from this valid site
        // check if site exists and is verified
        // TODO ...................
        // check if site exists and is verified

        /*
        if ($data->event_id == 'notFound') {
            // track 404/Error pages
            $urlPath = $data->urlPathErrorPage;
            ErrorPage::create(['site_id' => $site->id, 'path' => $urlPath]);            

            $session = LogSession::where('hash', $data->tracking_id)->first();
            $session->update(['is_404' => 1]);            

            $counter = ErrorPage::where(['site_id' => $site->id, 'path' => $urlPath])->count();
            ErrorPage::where(['site_id' => $site->id, 'path' => $urlPath])->update(['counter' => $counter]);

        } else {            
         */
        $event = Event::where('code', $data->event_id)->where('active', 1)->first();
        if ($event) LogSession::where('hash', $data->tracking_id)->update(['event_id' => $event->id]);


        return;
    }

    /**
     * Anonymizes an IP/IPv6.
     *
     * Removes the last byte for v4 and the last 8 bytes for v6 IPs
     */
    public static function anonymize(string $ip): string
    {
        $wrappedIPv6 = false;
        if ('[' === substr($ip, 0, 1) && ']' === substr($ip, -1, 1)) {
            $wrappedIPv6 = true;
            $ip = substr($ip, 1, -1);
        }

        $packedAddress = inet_pton($ip);
        if (4 === \strlen($packedAddress)) {
            $mask = '255.255.255.0';
        } elseif ($ip === inet_ntop($packedAddress & inet_pton('::ffff:ffff:ffff'))) {
            $mask = '::ffff:ffff:ff00';
        } elseif ($ip === inet_ntop($packedAddress & inet_pton('::ffff:ffff'))) {
            $mask = '::ffff:ff00';
        } else {
            $mask = 'ffff:ffff:ffff:ffff:0000:0000:0000:0000';
        }
        $ip = inet_ntop($packedAddress & inet_pton($mask));

        if ($wrappedIPv6) {
            $ip = '[' . $ip . ']';
        }

        return $ip;
    }
}
