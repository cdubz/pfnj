<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($recipe->exists ? "Edit {$recipe->name}" : 'Add Recipe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ ($recipe->exists ? route('recipes.update', $recipe) : route('recipes.store')) }}">
                    @if ($recipe->exists)@method('put')@endif
                    @csrf
                        <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                            <!-- Name -->
                            <div class="flex-auto">
                                <x-inputs.label for="name" value="Name" />

                                <x-inputs.input name="name"
                                                type="text"
                                                class="block mt-1 w-full"
                                                :value="old('name', $recipe->name)"
                                                required />
                            </div>

                            <!-- Servings -->
                            <div class="flex-auto">
                                <x-inputs.label for="servings" value="Servings" />

                                <x-inputs.input name="servings"
                                                type="number"
                                                class="block mt-1 w-full"
                                                :value="old('servings', $recipe->servings)"
                                                required />
                            </div>

                            <!-- Weight -->
                            <div class="flex-auto">
                                <x-inputs.label for="weight" value="Total weight (g)" />

                                <x-inputs.input name="weight"
                                                type="number"
                                                step="any"
                                                class="block mt-1 w-full"
                                                :value="old('weight', $recipe->weight)" />
                            </div>
                        </div>
                        <div class="flex flex-col space-y-4 mt-4">
                            <!-- Source -->
                            <div class="flex-auto">
                                <x-inputs.label for="source" value="Source" />

                                <x-inputs.input name="source"
                                                type="text"
                                                class="block mt-1 w-full"
                                                :value="old('source', $recipe->source)" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-inputs.label for="description" value="Description" />

                                <x-inputs.textarea name="description"
                                                   class="block mt-1 w-full"
                                                   :value="old('description', $recipe->description)" />
                            </div>

                            <!-- Tags -->
                            <x-tagger :defaultTags="$recipe_tags"/>
                        </div>

                        <!-- Ingredients -->
                        <h3 class="mt-6 mb-2 font-extrabold text-lg">Ingredients</h3>
                        <div x-data class="ingredients space-y-4">
                            @forelse($ingredients as $ingredient)
                                @include('recipes.partials.ingredient-input', $ingredient)
                            @empty
                                @include('recipes.partials.ingredient-input')
                            @endforelse
                            <div class="template ingredient-template hidden">
                                @include('recipes.partials.ingredient-input')
                            </div>
                            <div class="template heading-template hidden">
                                @include('recipes.partials.heading-input')
                            </div>
                            <x-inputs.icon-button type="button" color="green" x-on:click="cloneTemplate($el, 'ingredient');">
                                <svg class="h-10 w-10 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg> Ingredient
                            </x-inputs.icon-button>
                            <x-inputs.icon-button type="button" color="green" x-on:click="cloneTemplate($el, 'heading');">
                                <svg class="h-10 w-10 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg> Heading
                            </x-inputs.icon-button>
                        </div>

                        <!-- Steps -->
                        <h3 class="mt-6 mb-2 font-extrabold text-lg">Steps</h3>
                        <div x-data class="steps">
                            @forelse($steps as $step)
                                @include('recipes.partials.step-input', $step)
                            @empty
                                @include('recipes.partials.step-input')
                            @endforelse
                            <div class="template step-template hidden">
                                @include('recipes.partials.step-input')
                            </div>
                            <div class="template heading-template hidden">
                                @include('recipes.partials.heading-input')
                            </div>
                            <x-inputs.icon-button type="button" color="green" x-on:click="cloneTemplate($el, 'step');">
                                <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg> Step
                            </x-inputs.icon-button>
                            <x-inputs.icon-button type="button" color="green" x-on:click="cloneTemplate($el, 'heading');">
                                <svg class="h-10 w-10 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg> Heading
                            </x-inputs.icon-button>
                        </div>

                        <div x-data class="flex items-center justify-end mt-4">
                            <x-inputs.button x-on:click="removeTemplates();" class="ml-3">
                                {{ ($recipe->exists ? 'Save' : 'Add') }}
                            </x-inputs.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @once
        @push('scripts')
            <script src="{{ asset('js/recipes/edit.js') }}"></script>
            <script type="text/javascript">
                new Draggable.Sortable(document.querySelector('.ingredients'), {
                    draggable: '.draggable',
                    handle: '.draggable-handle',
                    mirror: {
                        appendTo: '.ingredients',
                        constrainDimensions: true,
                    },
                })

                new Draggable.Sortable(document.querySelector('.steps'), {
                    draggable: '.draggable',
                    handle: '.draggable-handle',
                    mirror: {
                        appendTo: '.steps',
                        constrainDimensions: true,
                    },
                })
            </script>
            <script type="text/javascript">
                /**
                 * Adds a set of entry form fields from the template.
                 *
                 * @param {object} $el Entry parent element.
                 * @param {string} type Entry type.
                 */
                let cloneTemplate = ($el, type) => {
                    // Create clone of template entry.
                    let template = $el.querySelector(`:scope .${type}-template`);
                    let newEntry = template.cloneNode(true).firstElementChild;

                    // Insert new entry before add button.
                    $el.insertBefore(newEntry, template);
                }

                /**
                 * Removes any hidden templates before form submit.
                 */
                let removeTemplates = () => {
                    document.querySelector(':scope .template').remove();
                }
            </script>
        @endpush
    @endonce
</x-app-layout>
