<div>
    <section class="container mx-auto p-4 max-w-screen-xl">

        @include('components.layouts.election-navigation')

    </section>

    <section class="container mx-auto p-4 max-w-screen-xl">
        @foreach ($positions as $position)
            <p class="mb-3 text-gray-500 dark:text-gray-400">{{ $position['name'] }}</p>
        @endforeach
    </section>    
</div>
