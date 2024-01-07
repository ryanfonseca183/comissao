<form
  method="POST"
  action="{{ route('admin.indications.budget.status.update', $company) }}"
  class="rounded-md border border-gray-300 p-4 mt-5">
    @csrf
    @method('PUT')
    <h2 class="text-lg font-medium text-gray-900">A empresa aceitou a proposta?</h2>
    <p class="mb-3">Clique em um dos botões abaixo para fechar ou recusar</p>
    <div class="flex items-center gap-4 mb-3">
        <x-primary-button type="button" id="close_button">
            {{ __('Fechar') }}
        </x-primary-button>
        <x-danger-button
            type="submit"
            name="status"
            value="{{ App\Enums\IndicationStatusEnum::RECUSADO }}">
                {{ __('Recusar') }}
        </x-danger-button>
    </div>
    <div class="border border-gray-300 p-4 rounded-md" id="contract_number_form" @if(! $errors->has('contract_number')) style="display:none;" @endif>
        <div>
            <x-input-label for="contract_number" :value="__('Contract Number')" class="mb-1" />
            <div class="relative flex flex-wrap items-stretch">
                <x-text-input
                    :value="old('contract_number', $budget->contract_number)"
                    class="border-e-0 rounded-e-none grow"
                    name="contract_number"
                    id="contract_number"
                    type="text" />
                <x-primary-button
                    style="font-size: 0.65rem; padding: 0.5rem 0.75rem"
                    class="rounded-s-none rounded-e-md"
                    type="submit">
                    <x-icons.check-circle width="24" height="24" class="w-3 h-3 me-2"/>
                    Salvar
                </x-primary-button>
            </div>
            <x-input-error :messages="$errors->get('contract_number')" class="mt-2" />
        </div>
    </div>
</form>