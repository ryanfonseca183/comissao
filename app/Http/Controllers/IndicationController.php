<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Operator;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIndicationRequest;
use App\Notifications\IndicationCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class IndicationController extends Controller
{
    public function index()
    {
        $indications = auth()->guard('user')->user()->indications()
                        ->select('id', 'corporate_name', 'doc_num', 'service_id', 'status')
                        ->with('service:id,name')
                        ->get();

        return view('user.companies.index', compact('indications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIndicationRequest $request)
    {
        $indication = auth()->guard('user')->user()->indications()->create($request->validated());

        session()->flash('f-success', __('messages.store:success', ['Entity' => __('Indication')]));
        try {
            Notification::send(Operator::where('status', 1)->get(), new IndicationCreated($indication));
        } catch (\Exception $e) {
            Log::error('Não foi possível enviar notificação de cadastro de indicação. '. $e->getMessage());
        }
        return redirect()->route('indications.index');
    }

    /**
     * Show the resource.
     */
    public function show($id)
    {
        $company = auth()->guard('user')->user()->indications()->findOrFail($id);

        return view('user.companies.show', compact('company'));
    }

    /**
     * Show the form for editing a new resource.
     */
    public function edit($id)
    {
        $company = auth()->guard('user')->user()->indications()->findOrFail($id);

        if($company->statusDiffFrom('PENDENTE')) {
            return redirect()->route('indications.show', $id);
        }
        return view('user.companies.edit', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(StoreIndicationRequest $request, $id)
    {
        $company = auth()->guard('user')->user()->indications()->findOrFail($id);

        abort_if($company->statusDiffFrom('PENDENTE'), 403);

        $company->update($request->validated());

        session()->flash('f-success', __('messages.update:success', ['Entity' => __('Indication')]));

        return redirect()->route('indications.index');
    }

    public function destroy($id)
    {
        try {
            auth()->guard('user')->user()->indications()->where('id', $id)->delete();

            session()->flash('f-success', __('messages.destroy:success', ['Entity' => __('Indication')]));

        } catch (\Exception $e) {
            session()->flash('f-success', __('messages.destroy:error', ['Entity' => __('Indication')]));
        }
        return redirect()->route('indications.index');
    }
}
