<div>
    <section class="container mx-auto p-4 max-w-screen-xl">

        @include('components.layouts.election-navigation')

    </section>

    <section class="container mx-auto p-4 max-w-screen-xl">
        
        @forelse ($past_elections as $election)
            <p class="text-5xl text-gray-900 dark:text-white">
                {{ $loop->index }}. {{ $election->organization->name }}
            </p>
        @empty
            No past elections
        @endforelse

    </section>
</div>
