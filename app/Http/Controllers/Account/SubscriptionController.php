<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Site;
use App\Models\Subscription;
use Auth;

class SubscriptionController extends Controller
{

    public function __construct() {}


    /**
     * Show all resources
     */
    public function index(Request $request)
    {
        $message = $request->message;

        $user = User::find(Auth::user()->id);

        $count_user_sites = Site::where('user_id', Auth::user()->id)->count();

        $user_subscribed = $user->subscribed();

        $subscription = $user->subscription() ?? null;

        //dd($subscription);

        //$userOnTrial = $user->subscription()->onTrial() ?? null;
        //$userHasExpiredTrial->subscription()->hasExpiredTrial();


        if ($subscription) {
            $user_on_trial = $user->subscription()->onTrial() ?? null;
        } else {
            if ($user->trial_ends_at >= now())
                $user_on_trial = true;
            else
                $user_on_trial = false;
        }


        if ($subscription) {
            $upcomingInvoice  = $user->upcomingInvoice() ?? null;
            $subscription_canceled_on_grace_period = $subscription->onGracePeriod() ?? false;
        }

        // get Price_id of the subscribed subscription
        $subscription_instance = Subscription::where('user_id', Auth::user()->id)->first();               
        if ($subscription_instance) {
            if ($subscription_instance->stripe_status == 'canceled') $user_subscribed_price_id = null;
            else $user_subscribed_price_id = $subscription->stripe_price;
        }

        //dd($user_subscribed_price_id); 

        if ($upcomingInvoice ?? null) $upcoming_invoice_date = date('d M, Y', $upcomingInvoice->next_payment_attempt);

        // next billing date (if available)
        $next_billing_date =  null;
        if ($user->subscription() ?? null) {
            $next_billing_timestamp = $user->subscription()->asStripeSubscription()->current_period_end;
            $next_billing_date = \Carbon\Carbon::createFromTimeStamp($next_billing_timestamp)->toFormattedDateString();
        }

        return view('user.index', [
            'view_file' => 'subscription.index',
            'active_menu' => 'subscription',
            'message' => $message ?? null,

            'subscription' => $subscription,
            //'subscription_canceled_on_grace_period' => $subscription_canceled_on_grace_period ?? false,
            'upcoming_invoice_date' => $upcoming_invoice_date ?? null,
            'next_billing_date' => $next_billing_date,

            //'trial_ends_at' => $user->trial_ends_at,
            'count_user_sites' => $count_user_sites,

            //'user_subscribed_subscription' => $user_subscribed_subscription ?? null,
            'user_subscribed_price_id' => $user_subscribed_price_id ?? null,

            //'user_subscribed' => $user_subscribed,
            'user_on_trial' => $user_on_trial,
            //'userHasExpiredTrial' => $userHasExpiredTrial,
            'user' => $user,

            'portalSessionUrl' => User::get_user_stripe_portal_session()->url ?? null, // link to Billing portal       
            'customerSession' => User::get_user_stripe_checkout_session() ?? null,
        ]);
    }


    /**
     * Create or change subscription
     */
    public function store(Request $request)
    {
        $price = $request->price;
        if (!$price) return redirect(route('user.subscription'));

        $user = User::find(Auth::user()->id);

        // create customer if not exists
        $customer = $user->createAsCustomer();


        if ($user->subscription()) {
            // check if subscription is canceled (in grace period)
            if ($user->subscription()->onGracePeriod()) return redirect(route('user.subscription'))->with('error', 'subscription_canceled_on_grace_period');

            // check if active paid subscripton exists (not in trial)
            $exists_subscription_not_on_trial = $user->subscriptions()->notOnTrial()->get();
            $exists_subscription_canceled = $user->subscription()->canceled();
        } else

        if (($exists_subscription_not_on_trial ?? null) && (!$exists_subscription_canceled ?? null)) {

            // Active subscription exists. 
            // Check if it is the same subscription and price (=> error)
            if ($user->subscribedToPrice($price)) return redirect(route('user.subscription'))->with('error', 'already_subscribed_to_this_plan');

            // Update subscription (upgrade or downgrade)
            $checkout = $user->subscription()->swapAndInvoice($price);
            return redirect(route('user.subscription'))->with('success', 'changed');
        } else {
            // Create new subscription
            User::where('id', Auth::user()->id)->update(['trial_ends_at' => null]);

            $checkout = $user->checkout($price)->customData([
                'email' => $user->email,
            ]);

            return view('user.index', [
                'view_file' => 'subscription.checkout',
                'active_menu' => 'subscription',
                'checkout' => $checkout,
                'user' => $user,
            ]);
        }
    }


    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $user_subscribed = $user->subscribed();
        $user_on_trial = $user->subscription()->onTrial() ?? null;

        if (!$user_subscribed) return redirect(route('user.subscription'))->with('error', 'invalid_subscription');
        if ($user_on_trial) return redirect(route('user.subscription'));

        $user->subscription()->cancel();
       
        return redirect(route('user.subscription'))->with('success', 'canceled');
    }


    /**
     * Resume canceled subscription
     */
    public function resume()
    {
        $user = User::find(Auth::user()->id);

        $user_subscribed = $user->subscribed();
        $user_on_trial = $user->subscription()->onTrial() ?? null;

        if (!$user_subscribed) return redirect(route('user.subscription'))->with('error', 'invalid_subscription');
        if ($user_on_trial) return redirect(route('user.subscription'));

        $user->subscription()->resume();     

        return redirect(route('user.subscription'))->with('success', 'resumed');
    }

}
