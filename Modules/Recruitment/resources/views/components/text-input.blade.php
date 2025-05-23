@props([
'type' => 'text',
'name',
'id' => null,
'value' => '',
'placeholder' => '',
'required' => false,
'class' => '',
])

<input type="{{ $type }}" name="{{ $name }}" id="{{ $id ?? $name }}" value="{{ old($name, $value) }}"
    placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
    class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $class }}" />