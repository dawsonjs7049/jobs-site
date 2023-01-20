
{{-- we can use this as a wrapper in other components, like in listing-card -> use with <x-card></x-card> syntax --}}

{{-- the attributes thing is a way to pass in different element attributes wherever we are using this wrapper, uses this
stuff by default but if we pass an attribute where we use the <x-card class="p-24">, it will use that instead --}}

<div {{ $attributes->merge(['class' => 'bg-gray-50 border border-gray-200 rounded p-6']) }}>
    {{ $slot }}
</div>