  <div class="col-span-full xl:col-span-6 bg-white shadow-lg rounded-sm border border-gray-200">

    <div class="p-3">
        <div class="overflow-x-auto w-full">
            @if(Route::is('notes.edit.archived'))
                <form action="{{ route('notes.update.archived',$note->id) }}" method="post">
            @else
                <form action="{{ route('notes.update',$note) }}" method="post">
            @endif
                @csrf
                @method('put')
                    <x-checkbox :note="$note"></x-checkbox>
                <x-input
                    type="text"
                    name="title"
                    field="title"
                    placeholder="Title"
                    class="w-full"
                    autocomplete="off"
                    :value="@old('title',$note->title)"></x-input>
                <x-textarea
                    name="text"
                    rows="10"
                    field="text"
                    placeholder="Start typing here..."
                    class="w-full mt-6"
                    :value="@old('text',$note->text)"></x-textarea>
                <x-button name="action" value="save" class="mt-6 btn-success">{{ trans('notes.btn.save') }}</x-button>
                <x-button name="action" value="cancel" class="mt-6 btn-danger">{{ trans('notes.btn.cancel') }}</x-button>
            </form>
        </div>

    </div>
</div>
