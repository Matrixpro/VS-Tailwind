<?php

namespace App\Http\Controllers;

use App\Models\Location;
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
        /*
         * Build locations' select menu values
         */

        $locations = Location::selectRaw('locations.city, count(id) as number_of_locations')
            ->groupBy('city')
            ->get();

        $locations_select = [];

        foreach ($locations as $location) {
            $val = $location->city.' ('.$location->number_of_locations.')';
            $locations_select[$location->city] = $val;
        }

        /*
         * Get paginated results, set vars and return the view
         */

        $communitiesQuery = $this->getCommunityQuery();

        $communities = $communitiesQuery->paginate(9);

        $lipsum = new LoremIpsum();

        return Inertia::render('Communities', [
            'sort_sqft_selected' => null,
            'sort_price_selected' => null,
            'filter_location_selected' => null,
            'locations_select' => $locations_select,
            'communities' => $communities,
            'description' => $lipsum->sentences(2),
        ]);
    }

    /**
     * Handles AJAX request to filter (set cache values)
     * @param $params string filter and sort values
     */
    public function filterAndSort(Request $request)
    {
        $params = $request->get('filter_data');

        $filter_exp = explode('-', $params);

        if (!is_array($filter_exp))
            return response()->json([
                'message' => 'Invalid data type!',
            ], 422);

        $filter_in = $filter_exp[0];
        $filter_for = $filter_exp[1];

        /*
         * Set filter/sort in cache
         */

        switch ($filter_in) {
            case 'filter_location':
                if ($filter_for != 'reset') {
                    Cache::put('filter_location', $filter_for);
                } else {
                    Cache::forget('filter_location');
                }
                break;
            case 'sort_price':
                Cache::put('sort_price', $filter_for);
                Cache::forget('sort_sqft');
                break;
            case 'sort_sqft':
                Cache::put('sort_sqft', $filter_for);
                Cache::forget('sort_price');
                break;
            default:
                return response()->json([
                    'message' => 'Invalid filter/sort options',
                ], 422);
        }

        return back();
    }

    /**
     * Build and return community query based on cached values
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getCommunityQuery()
    {
        $location_city = Cache::get('filter_location', null);
        $sort_price = Cache::get('sort_price', null);
        $sort_sqft = Cache::get('sort_sqft', null);

        $communitiesQuery = Community::query()->with('location.state');

        if (!is_null($location_city))
            $communitiesQuery->whereHas('location', function($q) use($location_city) {
                $q->where('city', $location_city);
            });

        if (!is_null($sort_price))
            $communitiesQuery->orderby('price_min', $sort_price);

        if (!is_null($sort_sqft))
            $communitiesQuery->orderby('sqft_min', $sort_sqft);

        return $communitiesQuery;
    }

}
