<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class TrashedNoteController extends Controller
{
    /**
     * Main display for all notes
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $notes = Note::whereBelongsTo(Auth::user())
            ->onlyTrashed()
            ->latest('updated_at')
            ->paginate(5);

        return view('pages.notes.index')->with('notes', $notes);
    }

    /**
     * Display a separate note
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|never
     */
    public function show(Note $note)
    {
        $notes = Note::withoutArchived()
            ->whereBelongsTo(Auth::user())
            ->latest('updated_at')->paginate(10);

        if (! $note->user->is(Auth::user())) {
            return abort(403, 'Access Denied');
        }

        return view('pages.notes.index')->with('notes', $notes);
    }

    /**
     * Update a Note
     *
     * @return \Illuminate\Http\RedirectResponse|never
     */
    public function update(Note $note)
    {
        if (! $note->user->is(Auth::user())) {
            return abort(403, 'Access Denied');
        }
        $note->restore();

        return to_route('notes.index', $note)->with('success', 'Note Restored');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if (! $note->user->is(Auth::user())) {
            return abort(403, 'Access Denied');
        }
        $note->forceDelete();

        return to_route('trashed.index')->with('success', 'Note moved to trash successfully');
    }
}
