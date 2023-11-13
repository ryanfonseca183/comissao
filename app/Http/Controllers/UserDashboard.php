<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class UserDashboard extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $pending = $request->query('old', 'false') == 'false';

        $indications = auth()->guard('user')->user()->indications()
            ->whereHas('payments')
            ->with(['service:id,name', 'payments' => function ($query) use ($pending) {
                return $query->when($pending, function ($query) {
                    $query->whereDate('expiration_date', '>=', now());
                });
            }])->get();

        return view('user.dashboard', compact('indications'));
    }
}