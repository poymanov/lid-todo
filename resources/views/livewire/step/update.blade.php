<div>
    <span wire:click="add" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-2">{{ __('step.add') }}</span>

    @foreach($steps as $key => $step)
        <div wire:key="{{$key}}" class="flex">
            <input type="text" name="steps[]" value="{{ $step['title'] }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md mb-3 mr-2" placeholder="{{ __('step.description') }}" required>
            <span wire:click="remove({{$key}})" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 mb-2">{{ __('step.remove') }}</span>
        </div>
    @endforeach
</div>

