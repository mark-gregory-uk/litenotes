<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $notes = Note::withoutArchived()
            ->whereBelongsTo(Auth::user())
            ->latest('updated_at')->paginate(10);

        return view('pages.notes.index')->with('notes', $notes);
    }

    public function archived()
    {
        $notes = Note::onlyArchived()
            ->whereBelongsTo(Auth::user())
            ->latest('updated_at')->paginate(10);

        return view('pages.notes.index')->with('notes', $notes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages.notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        switch ($request->input('action')) {
            case 'save':
                $request->validate([
                    'title' => 'required|max:120',
                    'text' => 'required',
                ]);
                Auth::user()->notes()->create([
                    'uuid' => Str::uuid(),
                    'title' => $request->title,
                    'text' => $request->text,
                ]);
                break;
        }

        return to_route('notes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Note $note)
    {
        if (! $note->user->is(Auth::user())) {
            return abort(403, 'Access Denied');
        }

        return view('pages.notes.show')->with('note', $note);
    }

    /**
     * Show Archived Note
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|never
     */
    public function archivedShow(string $id)
    {
        $note = Note::withArchived()->find($id);
        if ($note) {
            if (! $note->user->is(Auth::user())) {
                return abort(403, 'Access Denied');
            }

            return view('pages.notes.show')->with('note', $note);
        }

        return abort(403, 'not Found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Note $note)
    {
        if (! $note->user->is(Auth::user())) {
            return abort(403, 'Access Denied');
        }

        return view('pages.notes.edit')->with('note', $note);
    }

    /**
     * Edit an archived not
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|never
     */
    public function editArchived(string $id)
    {
        $note = Note::withArchived()->find($id);
        if ($note) {
            if (! $note->user->is(Auth::user())) {
                return abort(403, 'Access Denied');
            }

            return view('pages.notes.edit')->with('note', $note);
        }

        return abort(403, 'not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request, Note $note)
    {
        $hasUpdated = false;
        switch ($request->input('action')) {
            case 'save':
                if (! $note->user->is(Auth::user())) {
                    return abort(403, 'Access Denied');
                }
                $request->validate([
                    'title'         => 'required|max:120',
                    'text'          => 'required',
                    'is_favorite'   => 'int',
                ]);

                $note->update([
                    'title' => $request->title,
                    'text' => $request->text,
                    'is_favorite'=> ($request->is_favorite ? $request->is_favorite : 0 )
                ]);
                $note->updated_at = Carbon::now();
                $hasUpdated = true;
                break;
        }

        if ($hasUpdated) {
            return to_route('notes.show', $note)->with('success', 'Note Updated successfully');
        }

        return to_route('notes.index');
    }

    public function updateArchive(Request $request, string $id)
    {
        $note = Note::withArchived()->find($id);
        if ($note) {
            $hasUpdated = false;
            switch ($request->input('action')) {
                case 'save':
                    if (! $note->user->is(Auth::user())) {
                        return abort(403, 'Access Denied');
                    }
                    $request->validate([
                        'title' => 'required|max:120',
                        'text' => 'required',
                    ]);

                    $note->update([
                        'title' => $request->title,
                        'text' => $request->text,
                    ]);
                    $hasUpdated = true;
                    break;
            }

            if ($hasUpdated) {
                return to_route('notes.archived', $note)->with('success', 'Note Updated successfully');
            }
        }

        return to_route('notes.archived');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(string $id)
    {
        $note = Note::withArchived()->find($id);
        if ($note) {
            if (! $note->user->is(Auth::user())) {
                return abort(403, 'Access Denied');
            }
            $note->delete();
        }

        return to_route('notes.index')->with('success', 'Note moved to trash successfully');
    }

    /**
     * Archive a Note
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function archive(string $id)
    {
        $note = Note::find($id);
        if ($note) {
            $note->archive();
            $note->save();

            return to_route('notes.index');
        }

        return to_route('notes.index');
    }

    /**
     * Unarchive a note
     *
     * @return RedirectResponse
     */
    public function unArchive($id)
    {
        $note = Note::withArchived()->find($id);
        if ($note) {
            $note->unArchive();
            $note->save();

            return to_route('notes.index');
        }

        return to_route('notes.index');
    }
}
