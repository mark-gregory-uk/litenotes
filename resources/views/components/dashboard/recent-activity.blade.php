<div class="col-span-full xl:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4 border-b border-slate-100">
        <h2 class="font-semibold text-slate-800">Recent Activity</h2>
    </header>
    <div class="p-3">
        <!-- Card content -->
        <!-- "Today" group -->
        <div>
            <header class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm font-semibold p-2">Today</header>
            <ul class="my-1">
                <!-- Item -->
                @foreach($todaysNotes as $note)
                    <li class="flex px-2">
                    <div class="w-9 h-9 rounded-full shrink-0 bg-indigo-500 my-2 mr-3">
                        <svg class="w-9 h-9 fill-current text-indigo-50" viewBox="0 0 36 36">
                            <path d="M18 10c-4.4 0-8 3.1-8 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L18.9 22H18c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
                        </svg>
                    </div>
                    <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                            <div class="grow flex justify-between">
                                <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900" href="{{ route('notes.show',$note->id) }}">{{ $note->title }}</a></div>
                                <div class="shrink-0 self-end ml-2">
                                    <a class="font-medium text-indigo-500 hover:text-indigo-600" href="{{ route('notes.show',$note->id) }}">View<span class="hidden sm:inline"> -&gt;</span></a>
                                </div>
                            </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <!-- "Yesterday" group -->
        <div>
            <header class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm font-semibold p-2">Yesterday</header>
            <ul class="my-1">
                @foreach($yesterdaysNotes as $note)
                    <li class="flex px-2">
                        <div class="w-9 h-9 rounded-full shrink-0 bg-indigo-500 my-2 mr-3">
                            <svg class="w-9 h-9 fill-current text-indigo-50" viewBox="0 0 36 36">
                                <path d="M18 10c-4.4 0-8 3.1-8 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L18.9 22H18c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
                            </svg>
                        </div>
                        <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                            <div class="grow flex justify-between">
                                <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900" href="{{ route('notes.show',$note->id) }}">{{ $note->title }}</a></div>
                                <div class="shrink-0 self-end ml-2">
                                    <a class="font-medium text-indigo-500 hover:text-indigo-600" href="{{ route('notes.show',$note->id) }}">View<span class="hidden sm:inline"> -&gt;</span></a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
