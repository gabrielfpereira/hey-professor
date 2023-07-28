@props([
    'question'
])

<div class="flex items-center justify-between p-3 rounded-md shadow-md dark:bg-gray-600 bg-slate-100 shadow-blue-950">
    <span>{{ $question->question }}</span>

    <div>
        <form action="{{ route('question.like', $question)}}" method="POST">
            @csrf
            @method('POST')
            <button class="flex items-start space-x-1">
                <x-icons.thumbs-up class="w-6 h-6 text-green-400 cursor-pointer hover:text-green-300"/>
                <span class="text-green-400">{{ $question->likes }}</span>
            </button>
        </form>

        <a href="{{ route('question.like', $question)}}" class="flex items-start space-x-1">
            <x-icons.thumbs-down class="w-6 h-6 text-red-400 cursor-pointer hover:text-red-300"/>
            <span class="text-red-400">5</span>
        </a>
    </div>
</div>