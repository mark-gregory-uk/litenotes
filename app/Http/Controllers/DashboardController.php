<?php

namespace App\Http\Controllers;

    use App\Models\DataFeed;
    use App\Models\Note;
    use Carbon\Carbon;
    use Illuminate\Contracts\View\View;

    class DashboardController extends Controller
    {
        /**
         * Displays the dashboard screen
         *
         * @return View
         */
        public function index() : View
        {
            $dataFeed = new DataFeed();
            $todaysNotes = Note::whereDate('updated_at',Carbon::today())
                ->orWhereDate('created_at',Carbon::today())
                ->orderBy('created_at','DESC')
                ->limit(4)
                ->get();
            $yesterdaysNotes = Note::whereDate('updated_at',Carbon::today()->subDays(11))
                ->orWhereDate('created_at',Carbon::today()->subDays(11))
                ->orderBy('created_at','DESC')
                ->limit(4)
                ->get();
            return view('pages/dashboard/dashboard', compact('dataFeed','todaysNotes','yesterdaysNotes'));
        }
    }
