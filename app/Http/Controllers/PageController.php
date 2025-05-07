<?php

namespace App\Http\Controllers;

use App\Models\SitePage;
use Illuminate\Support\Facades\DB;
use App\Models\Map\Map;

class PageController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Page Controller
    |--------------------------------------------------------------------------
    |
    | Displays site pages, editable from the admin panel.
    |
    */

    /**
     * Shows the page with the given key.
     *
     * @param string $key
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPage($key) {
        $page = SitePage::where('key', $key)->where('is_visible', 1)->first();
        if (!$page) {
            abort(404);

        // replace @map(int) with the map's HTML
        $text = $page->text;
        $text = preg_replace_callback('/@map\((\d+)\)/', function($matches) {
            $map = Map::find($matches[1]);
            if($map) return view('widgets._map', ['map' => $map])->render();
            else return '';
        }, $text);

        }

        return view('pages.page', ['page' => $page, 'text' => $text]);
    }

    /**
     * Shows the credits page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreditsPage() {
        return view('pages.credits', [
            'credits'    => SitePage::where('key', 'credits')->first(),
            'extensions' => DB::table('site_extensions')->get(),
        ]);
    }
}
