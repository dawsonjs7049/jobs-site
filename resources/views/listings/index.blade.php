
<x-layout>
    @include('partials._hero')
    @include('partials._search')
    @php
        $test = 1;
    @endphp

    {{-- @if(count($listings) == 0)
        <p>No Listings Found</p>
    @endif --}}

    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

        @unless(count($listings) == 0)
            @foreach($listings as $listing)
                {{-- this is how you made a component, passing listing as a prop to the component defined in views/components/listing-card --}}
                <x-listing-card :listing="$listing" />
            @endforeach
        @else 
            </p>No Listings Found</p>
        @endunless

    </div>

    <div class="mt-6 p-4">
        {{-- shows pagination links (if we enabled them on controller by using ->paginate()) --}}
        {{ $listings->links() }}
    </div>

</x-layout>

