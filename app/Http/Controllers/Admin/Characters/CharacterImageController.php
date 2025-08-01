<?php

namespace App\Http\Controllers\Admin\Characters;

use App\Http\Controllers\Controller;
use App\Models\Character\Character;
use App\Models\Character\CharacterImage;
use App\Models\Character\CharacterTitle;
use App\Models\Feature\Feature;
use App\Models\Rarity;
use App\Models\Species\Species;
use App\Models\Species\Subtype;
use App\Models\User\User;
use App\Services\CharacterManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Character\CharacterTransformation as Transformation;

class CharacterImageController extends Controller {
  /*
    |--------------------------------------------------------------------------
    | Admin / Character Image Controller
    |--------------------------------------------------------------------------
    |
    | Handles admin creation/editing of character images.
    |
    */

  /**
   * Shows the add image page. Existing characters only, not MYO slots.
   *
   * @param string $slug
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getNewImage($slug) {
    $this->character = Character::where('slug', $slug)->first();
    if (!$this->character) {
      abort(404);
    }

    return view('character.admin.upload_image', [
      'isMyo'     => false,
      'character' => $this->character,
      'rarities'  => ['0' => 'Select Rarity'] + Rarity::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'specieses' => ['0' => 'Select Species'] + Species::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'subtypes' => ['0' => 'Select Subtype'] + Subtype::where('species_id', '=', $this->character->image->species_id)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'users' => User::query()->orderBy('name')->pluck('name', 'id')->toArray(),
      'features' => Feature::orderBy('name')->pluck('name', 'id')->toArray(),
      'transformations' => ['0' => 'Select ' . ucfirst(__('transformations.transformation'))] + Transformation::where('species_id', '=', $this->character->image->species_id)->orWhereNull('species_id')->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
    ]);
  }

  /**
   * Shows the edit image subtype portion of the modal.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getNewImageSubtype(Request $request) {
    $species = $request->input('species');
    $id = $request->input('id');

    return view('character.admin._upload_image_subtype', [
      'subtypes' => Subtype::where('species_id', '=', $species)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'image'    => CharacterImage::find($id),
    ]);
  }
  /**
   * Shows the edit image transformation portion of the modal.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getNewImageTransformation(Request $request) {
    $species = $request->input('species');
    $id = $request->input('id');
    return view('character.admin._upload_image_transformation', [
      'transformations' => ['0' => 'Select ' . ucfirst(__('transformations.transformation'))] + Transformation::where('species_id', '=', $species)->orWhereNull('species_id')->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'transformation'  => $id,
    ]);
  }

  /**
   * Creates a new image for a character.
   *
   * @param App\Services\CharacterManager $service
   * @param string                        $slug
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postNewImage(Request $request, CharacterManager $service, $slug) {
    $request->validate(CharacterImage::$createRules);
    $data = $request->only([
      'image',
      'thumbnail',
      'x0',
      'x1',
      'y0',
      'y1',
      'use_cropper',
      'artist_url',
      'artist_id',
      'designer_url',
      'designer_id',
      'species_id',
      'subtype_id',
      'rarity_id',
      'feature_id',
      'feature_data',
      'is_valid',
      'is_visible',
      'transformation_id',
      'transformation_info',
      'transformation_description',
      'sex',
    ]);

    $this->character = Character::where('slug', $slug)->first();
    if (!$this->character) {
      abort(404);
    }
    if ($service->createImage($data, $this->character, Auth::user())) {
      flash('Image uploaded successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }

      return redirect()->back()->withInput();
    }

    return redirect()->to($this->character->url . '/images');
  }

  /**
   * Shows the edit image features modal.
   *
   * @param int $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getEditImageFeatures($id) {
    $image = CharacterImage::find($id);

    return view('character.admin._edit_features_modal', [
      'image'     => $image,
      'titles'    => ['custom' => 'Custom Title'] + CharacterTitle::orderBy('sort', 'DESC')->pluck('title', 'id')->toArray(),
      'rarities'  => ['0' => 'Select Rarity'] + Rarity::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'specieses' => ['0' => 'Select ' . ucfirst(__('lorekeeper.species'))] + Species::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'subtypes'  => ['0' => 'Select ' . ucfirst(__('lorekeeper.subtype'))] + Subtype::where('species_id', '=', $image->species_id)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
      'features'  => Feature::getDropdownItems(1),
      'transformations' => ['0' => 'Select ' . ucfirst(__('transformations.transformation'))] + Transformation::where('species_id', '=', $image->species_id)->orWhereNull('species_id')->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
    ]);
  }

  /**
   * Edits the features of an image.
   *
   * @param App\Services\CharacterManager $service
   * @param int                           $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postEditImageFeatures(Request $request, CharacterManager $service, $id) {
    $data = $request->only(['species_id', 'subtype_id', 'rarity_id', 'feature_id', 'feature_data', 'sex', 'transformation_id', 'transformation_info', 'transformation_description', 'title_ids', 'title_data']);
    $image = CharacterImage::find($id);
    if (!$image) {
      abort(404);
    }
    if ($service->updateImageFeatures($data, $image, Auth::user())) {
      flash(ucfirst(__('lorekeeper.character')) . ' traits edited successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back()->withInput();
  }

  /**
   * Shows the edit image subtype portion of the modal
   *
   * @param  Request  $request
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getEditImageSubtype(Request $request) {
    $species = $request->input('species');
    $id = $request->input('id');
    return view('character.admin._edit_features_subtype', [
      'image' => CharacterImage::find($id),
      'subtypes' => ['0' => 'Select Subtype'] + Subtype::where('species_id', '=', $species)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
    ]);
  }
  /**
   * Shows the edit image transformation portion of the modal.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getEditImageTransformation(Request $request) {
    $species = $request->input('species');
    $id = $request->input('id');
    return view('character.admin._edit_features_transformation', [
      'image'           => CharacterImage::find($id),
      'transformations' => ['0' => 'Select ' . ucfirst(__('transformations.transformation'))] + Transformation::where('species_id', '=', $species)->orWhereNull('species_id')->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
    ]);
  }
  /**
   * Shows the edit image notes modal.
   *
   * @param int $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getEditImageNotes($id) {
    return view('character.admin._edit_notes_modal', [
      'image' => CharacterImage::find($id),
    ]);
  }

  /**
   * Edits the features of an image.
   *
   * @param App\Services\CharacterManager $service
   * @param int                           $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postEditImageNotes(Request $request, CharacterManager $service, $id) {
    $data = $request->only(['description']);
    $image = CharacterImage::find($id);
    if (!$image) {
      abort(404);
    }
    if ($service->updateImageNotes($data, $image, Auth::user())) {
      flash('Image notes edited successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Shows the edit image credits modal.
   *
   * @param int $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getEditImageCredits($id) {
    return view('character.admin._edit_credits_modal', [
      'image' => CharacterImage::find($id),
      'users' => User::query()->orderBy('name')->pluck('name', 'id')->toArray(),
    ]);
  }

  /**
   * Edits the credits of an image.
   *
   * @param App\Services\CharacterManager $service
   * @param int                           $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postEditImageCredits(Request $request, CharacterManager $service, $id) {
    $data = $request->only(['artist_url', 'artist_id', 'designer_url', 'designer_id']);
    $image = CharacterImage::find($id);
    if (!$image) {
      abort(404);
    }
    if ($service->updateImageCredits($data, $image, Auth::user())) {
      flash('Image credits edited successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Shows the reupload image modal.
   *
   * @param int $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getImageReupload($id) {
    return view('character.admin._reupload_image_modal', [
      'image' => CharacterImage::find($id),
    ]);
  }

  /**
   * Reuploads an image.
   *
   * @param App\Services\CharacterManager $service
   * @param int                           $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postImageReupload(Request $request, CharacterManager $service, $id) {
    $request->validate(['image' => CharacterImage::$createRules['image'], 'thumbnail' => CharacterImage::$createRules['thumbnail']]);
    $data = $request->only(['image', 'thumbnail', 'x0', 'x1', 'y0', 'y1', 'use_cropper']);
    $image = CharacterImage::find($id);
    if (!$image) {
      abort(404);
    }
    if ($service->reuploadImage($data, $image, Auth::user())) {
      flash('Image uploaded successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Edits an image's settings.
   *
   * @param App\Services\CharacterManager $service
   * @param int                           $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postImageSettings(Request $request, CharacterManager $service, $id) {
    $data = $request->only(['is_valid', 'is_visible', 'content_warnings']);

    $image = CharacterImage::find($id);
    if (!$image) {
      abort(404);
    }
    if ($service->updateImageSettings($data, $image, Auth::user())) {
      flash('Image settings edited successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Shows the set active image modal.
   *
   * @param int $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getImageActive($id) {
    return view('character.admin._active_image_modal', [
      'image' => CharacterImage::find($id),
    ]);
  }

  /**
   * Sets an image to be the character's active image.
   *
   * @param App\Services\CharacterManager $service
   * @param int                           $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postImageActive(Request $request, CharacterManager $service, $id) {
    $image = CharacterImage::find($id);
    if (!$image) {
      abort(404);
    }
    if ($service->updateActiveImage($image, Auth::user())) {
      flash('Active ' . __('lorekeeper.character') . ' image set successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Shows the delete image modal.
   *
   * @param int $id
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function getImageDelete($id) {
    return view('character.admin._delete_image_modal', [
      'image' => CharacterImage::find($id),
    ]);
  }

  /**
   * Deletes an image.
   *
   * @param App\Services\CharacterManager $service
   * @param int                           $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postImageDelete(Request $request, CharacterManager $service, $id) {
    $image = CharacterImage::find($id);
    if (!$image) {
      abort(404);
    }
    if ($service->deleteImage($image, Auth::user())) {
      flash(ucfirst(__('lorekeeper.character')) . ' image deleted successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Sorts a character's images.
   *
   * @param App\Services\CharacterManager $service
   * @param string                        $slug
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postSortImages(Request $request, CharacterManager $service, $slug) {
    $this->character = Character::where('slug', $slug)->first();
    if (!$this->character) {
      abort(404);
    }

    if ($service->sortImages($request->only(['sort']), $this->character, Auth::user())) {
      flash('Images sorted successfully.')->success();

      return redirect()->back();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    }

    return redirect()->back();
  }

  /**
   * Generates an images character colours.
   *
   * @param App\Services\CharacterManager $service
   * @param int                           $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postImageColours(Request $request, CharacterManager $service, $id) {
    $image = CharacterImage::find($id);
    if (!$image) {
      abort(404);
    }
    $colours = null;
    if ($request->input('edit')) {
      $colours = $request->input('colours');
    }
    if ($service->imageColours($image, Auth::user(), $colours)) {
      flash('Character image colours updated successfully.')->success();
    } else {
      foreach ($service->errors()->getMessages()['error'] as $error) {
        flash($error)->error();
      }
    };
    return redirect()->back();
  }
}
