<?php

namespace App\Http\Controllers;

class LoreController extends Controller {
  /*
    |--------------------------------------------------------------------------
    | Lore Controller
    |--------------------------------------------------------------------------
    */
  public function getIndex() {
    return view('_lore.index', [
      'lore' => '',
    ]);
  }
}
