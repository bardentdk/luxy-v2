<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ContactForm;
use App\Models\Formation;
use App\Models\PageView;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Données globales pour le dashboard.
     */
    public function getDashboardData(): array
    {
        return [
            'stats'        => $this->getGlobalStats(),
            'top_pages'    => $this->getTopPages(10),
            'recent_views' => $this->getViewsLast30Days(),
            'new_contacts' => ContactForm::unread()->count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
        ];
    }

    /**
     * Statistiques globales.
     */
    public function getGlobalStats(): array
    {
        return [
            'total_users'       => User::count(),
            'active_users'      => User::active()->count(),
            'total_formations'  => Formation::count(),
            'published_formations' => Formation::published()->count(),
            'total_articles'    => Article::count(),
            'published_articles'=> Article::published()->count(),
            'total_contacts'    => ContactForm::count(),
            'unread_contacts'   => ContactForm::unread()->count(),
            'total_reviews'     => Review::count(),
            'approved_reviews'  => Review::approved()->count(),
            'total_page_views'  => PageView::count(),
            'views_today'       => PageView::whereDate('created_at', today())->count(),
            'views_this_month'  => PageView::whereMonth('created_at', now()->month)->count(),
        ];
    }

    /**
     * Pages les plus vues.
     */
    public function getTopPages(int $limit = 10): Collection
    {
        return PageView::select('route_name', 'url', DB::raw('COUNT(*) as views'))
            ->whereNotNull('route_name')
            ->groupBy('route_name', 'url')
            ->orderByDesc('views')
            ->limit($limit)
            ->get();
    }

    /**
     * Vues des 30 derniers jours (pour graphique).
     */
    public function getViewsLast30Days(): Collection
    {
        return PageView::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as views')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(fn($item) => [$item->date => $item->views]);
    }

    /**
     * Formations les plus vues.
     */
    public function getTopFormations(int $limit = 5): Collection
    {
        return Formation::select('id', 'title', 'slug', 'view_count', 'thumbnail')
            ->orderByDesc('view_count')
            ->limit($limit)
            ->get();
    }
}