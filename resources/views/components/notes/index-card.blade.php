  <div class="col-span-full xl:col-span-6 bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-4 border-b border-gray-100">
        @if(route::is('trashed.index'))
            <button class="font-semibold text-gray-800 py-2">{{ trans('notes.title_trashed') }}</button>
        @elseif (route::is('notes.archived'))
            <button class="font-semibold text-gray-800 py-2">{{ trans('notes.title_archived') }}</button>
        @else
            <button class="font-semibold text-gray-800 py-2">{{ trans('notes.title') }}</button>
        @endif
        <a href="{{ route('notes.create') }}" style="float: right;" class="btn btn-success">{{ trans('notes.btn.new') }}</a>
    </header>
    <div class="p-3">
        <!-- Table -->
        <div class="overflow-x-auto w-full">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                    <tr>
                        <th class="p-2 whitespace-nowrap"></th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">{{ trans('notes.tables.index.title') }}</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">{{ trans('notes.tables.index.created') }}</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">{{ trans('notes.tables.index.actions') }}</div>
                        </th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-gray-100">
                    @foreach($notes as $note)
                        <tr id="{{ $note->id }}">
                            <td class="p-1 whitespace-nowrap">
                                <span>
                                    <i
                                        @class(['','fa fa-star text-red-600' => $note->is_favorite,'' => ! $note->is_favorite])>
                                    </i>
                                </span>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-gray-800">{!! $note->title !!}</div>
                                </div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-left">{{ date("d/m/y", strtotime($note->created_at)) }}</div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                @if(!$note->trashed())
                                    @if(route::is('notes.archived'))
                                        <div class="text-center font-medium text-green-500">
                                            <a href="{{route('notes.show.archived', $note->id)}}"
                                               class="justify-start btn btn-sm mb-2 btn-success btnArchived"
                                               id="btnNotes"
                                               name="btnNotes"
                                               data-url = "">{{ __('View')}}
                                            </a>
                                            <a href="{{route('note.unuarchive', $note->id)}}"
                                               class="justify-start btn btn-sm mb-2 btn-danger btnNoteUnArchive"
                                               id="btnNoteUnArchive"
                                               data-url = "">{{ __('UnArchive')}}
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center font-medium text-green-500">
                                            <a href="{{route('notes.show', $note)}}"
                                               class="justify-start btn btn-sm mb-2 btn-success btnFeedBackArchive"
                                               id="btnNotes"
                                               data-url = "">{{ trans('notes.btn.view')}}
                                            </a>
                                            <a href="{{route('note.archive', $note->id)}}"
                                               class="justify-start btn btn-sm mb-2 btn-danger btnNoteArchive"
                                               id="btnNoteArchive"
                                               data-url = "">{{ trans('notes.btn.archive')}}
                                            </a>
                                        </div>
                                    @endif
                                @else

                                    <a href="{{route('trashed.update',$note)}}" style="float: right;" class="mr-2 btn btn-success">{{ trans('notes.btn.undelete') }}</a>
                                    <a href="{{route('trashed.destroy',$note)}}" style="float: right;" class="mr-2 btn btn-danger">{{ trans('notes.btn.delete')}}</a>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>

    </div>
</div>
