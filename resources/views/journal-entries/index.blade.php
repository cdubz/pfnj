<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ Auth::user()->name }}'s Journal</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-row">
                        <div class="w-1/12 mr-4">
                            <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                               href="{{ route(Route::current()->getName(), ['date' => $date->copy()->subDay(1)->toDateString()]) }}">
                                previous</a>
                        </div>
                        <div class="w-3/12 mr-4">
                            <h3 class="font-semibold text-xl text-gray-800">{{ $date->format('D, j M Y') }}</h3>
                            <div class="text-gray-700">{{ $entries->count() }} {{ \Illuminate\Support\Pluralizer::plural('entry', $entries->count()) }}</div>
                            <div class="grid grid-cols-2 text-sm border-t-8 border-black pt-2">
                                <div class="font-extrabold text-lg border-b-4 border-black">Calories</div>
                                <div class="font-extrabold text-right text-lg border-b-4 border-black">{{ round($entries->sum('calories'), 2) }}g</div>
                                <div class="font-bold border-b border-gray-300">Fat</div>
                                <div class="text-right border-b border-gray-300">{{ round($entries->sum('fat'), 2) }}g</div>
                                <div class="font-bold border-b border-gray-300">Cholesterol</div>
                                <div class="text-right border-b border-gray-300">{{ round($entries->sum('cholesterol'), 2) }}g</div>
                                <div class="font-bold border-b border-gray-300">Sodium</div>
                                <div class="text-right border-b border-gray-300">{{ round($entries->sum('sodium'), 2) }}g</div>
                                <div class="font-bold border-b border-gray-300">Carbohydrates</div>
                                <div class="text-right border-b border-gray-300">{{ round($entries->sum('carbohydrates'), 2) }}g</div>
                                <div class="font-bold">Protein</div>
                                <div class="text-right">{{ round($entries->sum('protein'), 2) }}g</div>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-4 w-full mr-4">
                            @foreach(['breakfast', 'lunch', 'dinner', 'snacks'] as $meal)
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-800">
                                        {{ Str::ucfirst($meal) }}
                                        <span class="text-sm text-gray-500">
                                        @foreach($nutrients as $nutrient)
                                                {{ round($entries->where('meal', $meal)->sum($nutrient), 2) }}g
                                                {{ $nutrient }}@if(!$loop->last), @endif
                                            @endforeach
                                    </span>
                                    </h3>
                                    @forelse($entries->where('meal', $meal) as $entry)
                                        <details>
                                            <summary>{{ $entry->summary }}</summary>
                                            <div class="border-blue-100 border-2 p-2 ml-4">
                                                <div class="float-right">
                                                    <a class="h-6 w-6 text-red-500 hover:text-red-700 hover:border-red-300 float-right text-sm"
                                                       href="{{ route('journal-entries.delete', $entry) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div>
                                                    <span class="font-bold">nutrients:</span>
                                                    @foreach($nutrients as $nutrient)
                                                        {{ round($entry->{$nutrient}, 2) }}g
                                                        {{ $nutrient }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </div>
                                                @if($entry->foods()->exists())
                                                    <div>
                                                        <span class="font-bold">foods:</span>
                                                        @foreach($entry->foods as $food)
                                                            <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                                               href="{{ route('foods.show', $food) }}">
                                                                {{ $food->name }}</a>@if(!$loop->last), @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @if($entry->recipes()->exists())
                                                    <div>
                                                        <span class="font-bold">recipes:</span>
                                                        @foreach($entry->recipes as $recipe)
                                                            <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                                               href="{{ route('recipes.show', $recipe) }}">
                                                                {{ $recipe->name }}</a>@if(!$loop->last), @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </details>
                                    @empty
                                        <em>No entries.</em>
                                    @endforelse
                                </div>
                            @endforeach
                        </div>
                        <div class="w-1/12 text-right">
                            <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                               href="{{ route(Route::current()->getName(), ['date' => $date->copy()->addDay(1)->toDateString()]) }}">
                                next</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
