<x-app-layout>
    <x-slot name="header">
        You can see here your status
    </x-slot>
    @if(auth()->user()->is_suspended === 1)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="alert alert-danger">
                Your account has been permanently suspended.
                You cannot publish posts, reviews and comments.
            </div>
        </div>
    </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                Nothing to see here yet...
            </div>
        </div>
    @endif

</x-app-layout>
