{{-- Added to session in controller class --}}
@if(session()->has('message'))
    {{-- x-data is from alpine js --}}
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="fixed top-2 left-1/2 transform rounded-md -translate-x-1/2 bg-green-500 text-white px-48 py-3">
        <p>
            {{ session('message') }}
        </p>
    </div>
@endif