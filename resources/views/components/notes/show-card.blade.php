  <div class="col-span-full xl:col-span-6 bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-6 border-b border-gray-100">

        @if(route::is('notes.show.archived'))
                <a href="{{route('notes.archived')}}" style="float: right;" class="btn btn-primary">{{ trans('notes.btn.back') }}</a>
                <a href="{{route('notes.edit.archived', $note->id)}}" style="float: right;" class="btn btn-success mr-2">{{ trans('notes.btn.edit') }}</a>
            @else
            <a href="{{route('notes.index')}}" style="float: right;" class="mr-2 btn btn-primary">{{ trans('notes.btn.back') }}</a>
            <form style="float: right;" action="{{ route('note.trash', $note->id) }}"
                      method="post">
                    @method('delete')
                    @csrf
                    <button type="submit" onclick="return confirm('Are you sure you wish to move this to trash?')" style="float: right;" class="mr-2 btn btn-danger">{{ trans('notes.btn.trash') }}</button>
                </form>

            @if ($note->isNotArchived())
                <a href="{{route('note.archive', $note)}}" style="float: right;" class="mr-2 btn btn-warning">{{ trans('notes.btn.archive') }}</a>
            @endif
            <a href="{{route('notes.edit', $note)}}" style="float: right;" class="mr-2 btn btn-success">{{ trans('notes.btn.edit') }}</a>
        @endif
        <span><i @class(['','fa fa-star text-red-600' => $note->is_favorite,'' => ! $note->is_favorite])></i></span>
        <span class="font-semibold text-gray-800"> {!! $note->title !!}</span>
    </header>
    <div class="p-3">
        <div class="overflow-x-auto w-full">
            <div class="">
                <div class="container maxwidth prose-sm prose w-full">
                   {!! $note->text !!}
                </div>
            </div>
        </div>
    </div>
</div>
