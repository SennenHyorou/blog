<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-bold text-xl">
                        Here's a list of your article {{auth()->user()->name}}
                    </h2>
                    <div class="pt-4">
                        @forelse($articles as $article)
                            <div>
                                <a href="{{route('articles.show',$article->slug)}}">
                                    <h2 class="inline-flex text-lg pb-6 items-center py-2 leading-4 font-medium rounded-md
                                    text-gray-400 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        {{ $article->title }}
                                        <span class="italic text-gray-600 text-sm pl-2">
                                            {{ $article->created_at->format("M jS Y") }}
                                        </span>
                                    </h2>
                                </a>
                                <hr class="border border-b-1 border-gray-700">
                            </div>
                        @empty
                            <p>
                                You have not yet created any new articles.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
