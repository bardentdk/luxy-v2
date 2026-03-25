<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(private readonly AnalyticsService $analytics)
    {}

    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats'         => $this->analytics->getGlobalStats(),
            'topPages'      => $this->analytics->getTopPages(10),
            'viewsChart'    => $this->analytics->getViewsLast30Days(),
            'topFormations' => $this->analytics->getTopFormations(5),
        ]);
    }
}