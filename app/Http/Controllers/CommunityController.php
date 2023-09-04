<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use App\Models\Community;
use Illuminate\Http\Request;
use Inertia\Inertia;
use joshtronic\LoremIpsum;
use function PHPUnit\Framework\throwException;

class CommunityController extends Controller
{
    /**
     * Display a listing of the communities.
     * @return \Inertia\Response
     */
    public function index()
    {
        $locations = Location::withCityCount()
            ->get()
            ->mapWithKeys(fn($location) => [
                $location->city => $location->city . ' (' . $location->number_of_locations . ')',
            ]);

        $communities = $this->getCommunityQuery()->paginate(9);
        $lipsum = new LoremIpsum();
        $description = $lipsum->words(64);

        return Inertia::render('Communities', get_defined_vars());
    }

    /** Build and return community query based on cached values */
    public function getCommunityQuery(): Builder
    {
        return Community::query()
            ->with('location.state')
            ->when(request('filter_location'),
                fn($query, $location_city) => $query->whereHas('location',
                    fn($q) => $q->where('city', $location_city)
                )
            )
            ->when(request('sort_price'),
                fn($query, $sort_price) => $query->orderBy('price_min', $sort_price)
            )
            ->when(request('sort_sqft'),
                fn($query, $sort_sqft) => $query->orderBy('sqft_min', $sort_sqft)
            );
    }

}
