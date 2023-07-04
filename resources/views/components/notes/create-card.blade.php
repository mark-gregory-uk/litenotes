  <div class="col-span-full xl:col-span-6 bg-white shadow-lg rounded-sm border border-gray-200">

    <div class="p-3">
        <div class="overflow-x-auto w-full">

            <form action="{{ route('notes.store') }}" method="post">
                @csrf
                <x-input
                    type="text"
                    name="title"
                    id="title_field"
                    field="title"
                    placeholder="Title"
                    class="w-full mb-1"
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
