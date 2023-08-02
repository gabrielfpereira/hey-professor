<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('dashboard')}}" method="GET" class="flex items-center space-x-4">
                        @csrf
                        <input type="text" name="search" value="{{ request()->search }}" placeholder="Search" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Search</button>
                    </form>
                    
                    <hr class="my-4 border-gray-600">

                    <div class="space-y-4">
                        
                        @forelse ($questions as $question)
                            <h2>List of Questions</h2>
                            <x-question :question="$question" />
                        @empty
                            <x-draw.search />
                        @endforelse

                        {{ $questions->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
