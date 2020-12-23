<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $task->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-5 flex">
                        @include('task.links._to_task_list')
                        <a href="{{ route('task.edit', $task) }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                            {{ __('task.edit') }}
                        </a>
                        <form action="{{ route('task.delete', $task) }}" method="post" onsubmit="return confirm('{{ __('task.confirm_delete') }}')">
                            @csrf
                            @method('delete')
                            <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 mr-2">{{ __('task.delete') }}</button>
                        </form>
                        @if($task->completed)
                            <form action="{{ route('task.incomplete', $task) }}" method="post">
                                @csrf
                                @method('patch')
                                <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">{{ __('task.incomplete') }}</button>
                            </form>
                        @else
                            <form action="{{ route('task.complete', $task) }}" method="post">
                                @csrf
                                @method('patch')
                                <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">{{ __('task.complete') }}</button>
                            </form>
                        @endif
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ __('task.title') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $task->title }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ __('task.description') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $task->description }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ __('task.status') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if($task->completed)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ __('task.completed') }}</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-green-800">{{ __('task.not_completed') }}</span>
                                @endif
                            </dd>
                        </div>
                        @if($task->steps()->exists())
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    {{ __('step.steps') }}
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                        @foreach($task->steps as $step)
                                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                <div class="w-0 flex-1 flex items-center">
                                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="ml-2 flex-1 w-0 truncate">{{ $step->title }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
