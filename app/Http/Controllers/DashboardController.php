<?php

namespace App\Http\Controllers;

use App\Models\GeneratedQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $totalDomains = $user->domains()->count();
        $totalConcepts = $user->concepts()->count();

        if ($totalConcepts > 0) {
            $mastered = $user->concepts()->where('status', 'mastered')->count();
            $inProgress = $user->concepts()->where('status', 'in_progress')->count();
            $toReview = $user->concepts()->where('status', 'to_review')->count();
            $masteryPercentage = round(($mastered / $totalConcepts) * 100);
        } else {
            $mastered = 0;
            $inProgress = 0;
            $toReview = 0;
            $masteryPercentage = 0;
        }

        $recentDomains = $user->domains()->withCount('concepts')->latest()->take(4)->get();
        $recentConcepts = $user->concepts()
            ->with(['domain', 'generatedQuestions'])
            ->latest()
            ->take(5)
            ->get();

        $generatedCount = GeneratedQuestion::whereHas('concept', function ($q) use ($user) {
            $q->whereHas('domain', fn($dq) => $dq->where('user_id', $user->id));
        })->count();

        return view('dashboard', compact(
            'totalDomains',
            'totalConcepts',
            'mastered',
            'inProgress',
            'toReview',
            'masteryPercentage',
            'recentDomains',
            'recentConcepts',
            'generatedCount',
        ));
    }
}