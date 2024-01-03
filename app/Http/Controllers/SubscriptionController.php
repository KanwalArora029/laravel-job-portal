<?php

namespace App\Http\Controllers;

use App\Http\Middleware\blockUserToMakePayment;
use App\Http\Middleware\isEmployer;
use App\Mail\PurchaceMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class SubscriptionController extends Controller
{
    const WEEKLY_AMOUNT = 20;
    const MONTHLY_AMOUNT = 80;
    const YEARLY_AMOUNT = 200;
    const CURRENCY = 'GBP';

    public function __construct()
    {
        $this->middleware(['auth', isEmployer::class]);
        $this->middleware(['auth', blockUserToMakePayment::class])->except('subscribe');
    }
    public function subscribe()
    {
        return view('subscription.index');
    }

    public function initiatePayment(Request $request)
    {
        $plans = [
            'weekly' => [
                'name' => 'weekly',
                'description' => 'Weekly Subscription',
                'amount' => self::WEEKLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quatity' => 1,
                'interval' => 'week',
            ],
            'monthly' => [
                'name' => 'monthly',
                'description' => 'Monthly Subscription',
                'amount' => self::MONTHLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quatity' => 1,
                'interval' => 'month',
            ],

            'yearly' => [
                'name' => 'yearly',
                'description' => 'Yearly Subscription',
                'amount' => self::YEARLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quatity' => 1,
                'interval' => 'year',
            ],
        ];

        // initiate stripe payment

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $selectPlan = '';
            if ($request->is('pay/weekly')) {
                $selectPlan = $plans['weekly'];
                $billingEnds = now()->addWeek()->startOfDay()->toDateTimeString();
            } elseif ($request->is('pay/monthly')) {
                $selectPlan = $plans['monthly'];
                $billingEnds = now()->addMonth()->startOfDay()->toDateTimeString();
            } elseif ($request->is('pay/yearly')) {
                $selectPlan = $plans['yearly'];
                $billingEnds = now()->addYear()->startOfDay()->toDateTimeString();
            }

            if ($selectPlan) {
                $successUrl = URL::signedRoute('payment.success', [
                    'plan' => $selectPlan['name'],
                    'billing_ends' => $billingEnds
                ]);


                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => $selectPlan['currency'],
                                'unit_amount' => $selectPlan['amount'] * 100,
                                'recurring' => [
                                    'interval' => $selectPlan['interval'],
                                ],
                                'product_data' => [
                                    'name' => $selectPlan['description'],
                                    'description' => $selectPlan['description'],
                                ],
                            ],
                            'quantity' => $selectPlan['quatity'],
                        ]
                    ],
                    'mode' => 'subscription',
                    'success_url' => $successUrl,
                    'cancel_url' => route('payment.failed'),
                ]);
                return redirect()->away($session->url);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function paymentSuccess(Request $request)
    {
        $plan = $request->plan;
        $billingEnds = $request->billing_ends;
        User::where('id', auth()->user()->id)->update([
            'plan' => $plan,
            'billing_ends' => $billingEnds,
            'status' => 'paid',
        ]);

        try {
            Mail::to(auth()->user())->queue(new PurchaceMail($plan, $billingEnds));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }


        return redirect()->route('dashboard')->with('success', 'Your payment was successful.');
    }

    public function paymentFailed(Request $request)
    {
        // redirect to subscription page
        return redirect()->route('subscribe')->with('error', 'Your payment failed.');
    }
}
