@push('css')
    <style>
        .payment-btn {
            width: 2.625rem;
            font-size: 0.65rem;
            padding: 0.5rem 0.75rem;
            transition: width 0.2s ease;
            overflow:hidden;
        }
        .payment-btn:hover,
        .payment-btn:focus  {
            width: 12rem;
        }
        .payment-btn span {
            display:inline-block;
            width: 0;
            height: 0;
            opacity: 0;
        }
        .payment-btn:hover span, 
        .payment-btn:focus span {
            white-space: nowrap;
            width: auto;
            height: auto;
            opacity: 1;
            margin-left: 0.5rem;
        }
    </style>
@endpush

<div x-data="{selected: null}">
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
                @elseif(! $payment->paid)
                    <x-primary-button class="payment-btn" @click="selected = {{$payment->id}}">
                        <x-icons.check />
                        <span>Registrar pagamento</span>
                    </x-primary-button>
                @endif
            </li>
        @endforeach
    </ul>
    <form method="POST" action="{{route('admin.commissions.update', $company)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="origin" value="budgets">
        <x-modals.base title="Realizar pagamento" x-show="selected" away="selected = null">
            <p class="mb-4">
                Possui o comprovante de pagamento? Utilize o campo abaixo para
                selecionar o arquivo ou clique em continuar para finalizar a operação.
            </p>
            <input type="hidden" name="installment" x-bind:value="selected">
            <x-file-input name="file" accept="image/png, image/gif, image/jpeg, application/pdf"/>
            <x-slot name="actions">
                <x-primary-button  class="ml-3">Continuar</x-secondary-button>
                <x-secondary-button @click="selected = null">Cancelar</x-secondary-button>
            </x-slot>
        </x-modals.base>
    </form>
</div>

