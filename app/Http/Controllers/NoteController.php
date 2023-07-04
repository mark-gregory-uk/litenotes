<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the all resource but not the archive.
     *
     * @return View
     */
    public function index() : View
    {
        $notes = Note::withoutArchived()
            ->whereBelongsTo(Auth::user())
            ->latest('updated_at')->paginate(10);

        return view('pages.notes.index')->with('notes', $notes);
    }

    /**
     * Display the archive index
     * @return View
     */
    public function archived() : View
    {
        $notes = Note::onlyArchived()
            ->whereBelongsTo(Auth::user())
            ->latest('updated_at')->paginate(10);

        return view('pages.notes.index')->with('notes', $notes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create() : View
    {
        return view('pages.notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
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
     * @param Note $note
     * @return RedirectResponse|View
     */
    public function show(Note $note) : RedirectResponse|View
    {
        if (! $note->user->is(Auth::user())) {
            return abort(403, 'Access Denied');
        }

        return view('pages.notes.show')->with('note', $note);
    }

    /**
     * Show Archived Note
     *
     * @param string $id
     * @return View
     */
    public function archivedShow(string $id) : View
    {
        $note = Note::withArchived()->find($id);
        if ($note) {
            if (! $note->user->is(Auth::user())) {
                return abort(403, 'Access Denied');
            }

            return view('pages.notes.show')->with('note', $note);
        }

        return abort(403, 'error not Found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|\Illuminate\Contracts\Foundation\Application|View
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
     * @param string $id
     * @return View
     */
    public function editArchived(string $id) : View
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
     * @return RedirectResponse
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

    /**
     * Update the archived note
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|never
     */
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
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id) : RedirectResponse
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

            return to_route('notes.archived');
        }

        return to_route('notes.archived');
    }
}
