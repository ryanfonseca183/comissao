<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <h1 class="text-lg font-medium text-gray-900 flex items-center">
                            <a href="{{ route('dashboard') }}">
                                <x-icons.arrow-left class="me-2" />
                            </a>
                            {{ $company->corporate_name }}, 
                            <span class="text-gray-600 text-sm ms-2">{{ $company->doc_num }}</span>
                        </h1>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs text-gray-600 ms-2">Criada em {{$company->created_at->format('d/m/Y H:i')}}</span>
                            <a href="{{route('indications.edit', $company)}}" class="text-sm">Ver indicação</a>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4 mb-4">
                            <div class="p-4 border border-green-400 shadow-sm sm:rounded-lg">
                                <h2 class="text-green-600 font-bold">Total</h2>
                                R$ {{number_format($company->payments->sum('value'), 2, ',', '.')}}
                            </div>
                            <div class="p-4 border border-red-400 shadow-sm sm:rounded-lg">
                                <h2 class="text-red-600 font-bold">Pendente</h2>
                                R$ {{number_format($company->payments->where('paid', 0)->sum('value'), 2, ',', '.')}}
                            </div>
                        </div>
                        <ul class="mb-4">
                            <li class="w-full border-b border-slate-200 border-opacity-100 py-2">
                                <strong class="font-medium text-gray-900">{{__('Last Installment Date')}}</strong> <br/>
                                {{$company->payments->max('expiration_date')->format('d/m/Y')}}
                            </li>
                            <li class="w-full border-b border-slate-200 border-opacity-100 py-2">
                                <strong class="font-medium text-gray-900">N.º {{__('Installments')}}</strong> <br/>
                                {{$company->payments->count()}}
                            </li>
                        </ul>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Installments') }}
                        </h2>
                        <ul>
                            @foreach($company->payments()->orderBy('installment')->get() as $payment)
                                <li class="flex items-center @if(! $loop->last) border-b @endif border-gray-300 py-2">
                                    <span class="w-10 text-center text-slate-300 text-4xl">{{$payment->installment}}</span>
                                    <div class="ml-2 flex-1">
                                        <div class="flex items-center">
                                            <span class="leading-none">R$ {{number_format($payment->value, 2, ',', '.')}}</span>
                                            @if($payment->expired || $payment->paid)
                                                <span class="ml-2 leading-none text-xs px-2 rounded py-1 text-white @if($payment->paid) bg-green-600 @else bg-red-600 @endif">
                                                    {{$payment->paid ? 'Pago' : 'Pendente'}}
                                                </span>
                                            @endif
                                        </div>
                                        @if(! $payment->paid)
                                            <small @if($payment->expired) class="text-red-600" @endif>
                                                Data de expiração: {{$payment->expiration_date->format('d/m/Y') }}
                                            </small>
                                        @else
                                            <small>
                                                Data de pagamento: {{$payment->payment_date->format('d/m/Y H:i') }}
                                            </small>
                                        @endif
                                    </div>
                                    @if($payment->receipt)
                                        <a href="{{asset('storage/'.$payment->receipt)}}" download>Baixar comprovante</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>