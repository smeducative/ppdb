<?php

namespace App\View\Composers;

use App\Models\PesertaPPDB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class YearVisibleComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct(protected PesertaPPDB $users) {}

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $oldestYear = Cache::remember('oldest_year', 60 * 24 * 28, function () {
            $oldest = $this->users->oldest('created_at')->first();
            return $oldest ? $oldest->created_at->year : date('Y');
        });

        $view->with('years_visible', $oldestYear);
    }
}
