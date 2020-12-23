<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('user.create_task_header') }}
        </h2>
    </x-slot>

    <div class="py-12">

        @if(count($errors))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
                    <div class="p-6 bg-red-300 border-b border-gray-200">{{ __('task.create_validation_failed') }}</div>
                </div>
            </div>
        @endif

        @if(session('create-failed'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
                    <div class="p-6 bg-red-300 border-b border-gray-200">{{ session('create-failed') }}</div>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-5">
                        @include('task.links._to_task_list')
                    </div>
                    <div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form action="{{ route('task.store') }}" method="POST">
                                @csrf
                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="title" class="block text-sm font-medium text-gray-700">{{ __('task.title') }}</label>
                                            <input type="text" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('title') }}" required>
                                            @if ($errors->has('title'))
                                                @foreach($errors->get('title') as $error)
                                                    <span class="text-red-500">{{ $error }}</span>
                                                @endforeach
                                            @endif
                                        </div>

                                        <div>
                                            <label for="description" class="block text-sm font-medium text-gray-700">
                                                {{ __('task.description') }}
                                            </label>
                                            <div class="mt-1">
                                                <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" required>{{ old('description') }}</textarea>
                                            </div>
                                            @if ($errors->has('description'))
                                                @foreach($errors->get('description') as $error)
                                                    <span class="text-red-500">{{ $error }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div class="text-xl mb-2">{{ __('step.steps') }}</div>
                                        @if ($errors->has('steps.*'))
                                            <span class="text-red-500">{{ __('step.validation_errors') }}</span>
                                        @endif
                                        @livewire('step.create', ['steps' => old('steps', [])])
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('task.create') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
