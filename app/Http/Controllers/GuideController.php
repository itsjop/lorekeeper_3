<?php

namespace App\Http\Controllers;

class GuideController extends Controller {
  /*
    |--------------------------------------------------------------------------
    | Guide Controller
    |--------------------------------------------------------------------------
  */
  public function getIndex() {
    return view('_guide.index', []);
  }
}
