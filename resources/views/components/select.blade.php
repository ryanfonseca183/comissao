@props(['name' => '', 'collection' => [], 'optionValue', 'optionLabel', 'optionSelected' => ''])

@php $id = $attributes->get('id') ?: $name; @endphp

<select name="{{$name}}" {{$attributes->merge(['id' => $id, 'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'])}} autocomplete="off">
    {{-- OPÇÃO PADRÃO --}}
    @if($attributes->get('required')) 
        <option @if(! $optionSelected) selected @endif disabled value="">{{ $attributes->get("placeholder", "Selecione uma opção") }}</option>
    @else 
        <option value="">{{ $attributes->get("placeholder") }}</option>
    @endif
    {{-- OPÇÕES SELECIONÁVEIS --}}
    @if(is_array($collection))
        @foreach($collection as $value => $label)
            <option value="{{ $value }}" @if($value == old($name, $optionSelected)) selected @endif>{{ $label }}</option>
        @endforeach
    @else
        @foreach($collection as $model)
            <option value="{{ $model->$optionValue }}" @if($model->$optionValue == old($name, $optionSelected)) selected @endif>
                {{ $model->$optionLabel ?? $model->$optionValue }}
            </option>
        @endforeach
    @endif
    {{$slot ?? ""}}
</select>