<?php

use Illuminate\Support\Facades\Route;

/*
| Admin Routes
|--------------------------------------------------------------------------
| Routes for users with powers.
*/

Route::get('/', 'HomeController@getIndex');

Route::get('admin-logs', 'HomeController@getLogs');

Route::group(['middleware' => 'admin'], function () {
  Route::get('staff-reward-settings', 'HomeController@getStaffRewardSettings');
  Route::post('staff-reward-settings/{key}', 'HomeController@postEditStaffRewardSetting');
});

Route::group(['prefix' => 'users', 'namespace' => 'Users'], function () {
  // USER LIST
  Route::group(['middleware' => 'power:edit_user_info'], function () {
    Route::get('/', 'UserController@getIndex');

    Route::get('{name}/edit', 'UserController@getUser');
    Route::post('{name}/basic', 'UserController@postUserBasicInfo');
    Route::post('{name}/location', 'UserController@postUserLocation');
    Route::post('{name}/faction', 'UserController@postUserFaction');
    Route::post('{name}/alias/{id}', 'UserController@postUserAlias');
    Route::post('{name}/account', 'UserController@postUserAccount');
    Route::post('{name}/birthday', 'UserController@postUserBirthday');
    Route::get('{name}/updates', 'UserController@getUserUpdates');
    Route::get('{name}/ban', 'UserController@getBan');
    Route::get('{name}/ban-confirm', 'UserController@getBanConfirmation');
    Route::post('{name}/ban', 'UserController@postBan');
    Route::get('{name}/unban-confirm', 'UserController@getUnbanConfirmation');
    Route::post('{name}/unban', 'UserController@postUnban');
    Route::get('{name}/deactivate', 'UserController@getDeactivate');
    Route::get('{name}/deactivate-confirm', 'UserController@getDeactivateConfirmation');
    Route::post('{name}/deactivate', 'UserController@postDeactivate');
    Route::get('{name}/reactivate-confirm', 'UserController@getReactivateConfirmation');
    Route::post('{name}/reactivate', 'UserController@postReactivate');
  });

  // RANKS
  Route::group(['middleware' => 'admin'], function () {
    Route::get('ranks', 'RankController@getIndex');
    Route::get('ranks/create', 'RankController@getCreateRank');
    Route::get('ranks/edit/{id}', 'RankController@getEditRank');
    Route::get('ranks/delete/{id}', 'RankController@getDeleteRank');
    Route::post('ranks/create', 'RankController@postCreateEditRank');
    Route::post('ranks/edit/{id?}', 'RankController@postCreateEditRank');
    Route::post('ranks/delete/{id}', 'RankController@postDeleteRank');
    Route::post('ranks/sort', 'RankController@postSortRanks');
  });
});

// SETTINGS
Route::group(['prefix' => 'invitations', 'middleware' => 'power:edit_site_settings'], function () {
  Route::get('/', 'InvitationController@getIndex');
  Route::post('create', 'InvitationController@postGenerateKey');
  Route::post('delete/{id}', 'InvitationController@postDeleteKey');
});

Route::group(['prefix' => 'prizecodes', 'middleware' => 'power:edit_site_settings'], function () {
  Route::get('/', 'PrizeCodeController@getIndex');
  Route::get('/create', 'PrizeCodeController@getCreatePrize');
  Route::get('/edit/{id}', 'PrizeCodeController@getEditPrize');
  Route::get('/delete/{id}', 'PrizeCodeController@getDeletePrize');
  Route::post('/create', 'PrizeCodeController@postCreateEditPrize');
  Route::post('/edit/{id?}', 'PrizeCodeController@postCreateEditPrize');
  Route::post('/delete/{id}', 'PrizeCodeController@postDeletePrize');
});

Route::group(['prefix' => 'prizecodes', 'middleware' => 'power:edit_site_settings'], function () {
  Route::get('/', 'PrizeCodeController@getIndex');
  Route::get('/create', 'PrizeCodeController@getCreatePrize');
  Route::get('/edit/{id}', 'PrizeCodeController@getEditPrize');
  Route::get('/delete/{id}', 'PrizeCodeController@getDeletePrize');
  Route::post('/create', 'PrizeCodeController@postCreateEditPrize');
  Route::post('/edit/{id?}', 'PrizeCodeController@postCreateEditPrize');
  Route::post('/delete/{id}', 'PrizeCodeController@postDeletePrize');
});

// FILE MANAGER
Route::group(['prefix' => 'files', 'middleware' => 'power:edit_site_settings'], function () {
  Route::get('/{folder?}', 'FileController@getIndex');
  Route::post('upload', 'FileController@postUploadFile');
  Route::post('move', 'FileController@postMoveFile');
  Route::post('rename', 'FileController@postRenameFile');
  Route::post('delete', 'FileController@postDeleteFile');
  Route::post('folder/create', 'FileController@postCreateFolder');
  Route::post('folder/delete', 'FileController@postDeleteFolder');
  Route::post('folder/rename', 'FileController@postRenameFolder');
});

// LOG VIEWER
Route::group(['prefix' => 'logs', 'middleware' => 'power:edit_site_settings'], function () {
  Route::get('/', 'LogController@getIndex');
  Route::get('/{name}', 'LogController@getLog');
  Route::post('/delete', 'LogController@postDeleteLog');
});

// SITE IMAGES
Route::group(['prefix' => 'images', 'middleware' => 'power:edit_site_settings'], function () {
  Route::get('/', 'FileController@getSiteImages');

  Route::post('upload/css', 'FileController@postUploadCss');
  Route::post('upload', 'FileController@postUploadImage');
  Route::post('reset', 'FileController@postResetFile');
});

// DATA
Route::group(['prefix' => 'data', 'namespace' => 'Data', 'middleware' => 'power:edit_data'], function () {
  // GALLERIES
  Route::get('galleries', 'GalleryController@getIndex');
  Route::get('galleries/create', 'GalleryController@getCreateGallery');
  Route::get('galleries/edit/{id}', 'GalleryController@getEditGallery');
  Route::get('galleries/delete/{id}', 'GalleryController@getDeleteGallery');
  Route::post('galleries/create', 'GalleryController@postCreateEditGallery');
  Route::post('galleries/edit/{id?}', 'GalleryController@postCreateEditGallery');
  Route::post('galleries/delete/{id}', 'GalleryController@postDeleteGallery');
  Route::post('galleries/sort', 'GalleryController@postSortGallery');

  // CURRENCIES
  Route::get('currency-categories', 'CurrencyController@getIndex');
  Route::get('currency-categories/create', 'CurrencyController@getCreateCurrencyCategory');
  Route::get('currency-categories/edit/{id}', 'CurrencyController@getEditCurrencyCategory');
  Route::get('currency-categories/delete/{id}', 'CurrencyController@getDeleteCurrencyCategory');
  Route::post('currency-categories/create', 'CurrencyController@postCreateEditCurrencyCategory');
  Route::post('currency-categories/edit/{id?}', 'CurrencyController@postCreateEditCurrencyCategory');
  Route::post('currency-categories/delete/{id}', 'CurrencyController@postDeleteCurrencyCategory');
  Route::post('currency-categories/sort', 'CurrencyController@postSortCurrencyCategory');

  Route::get('currencies', 'CurrencyController@getCurrencyIndex');
  Route::get('currencies/sort', 'CurrencyController@getSort');
  Route::get('currencies/create', 'CurrencyController@getCreateCurrency');
  Route::get('currencies/edit/{id}', 'CurrencyController@getEditCurrency');
  Route::get('currencies/delete/{id}', 'CurrencyController@getDeleteCurrency');
  Route::post('currencies/create', 'CurrencyController@postCreateEditCurrency');
  Route::post('currencies/edit/{id?}', 'CurrencyController@postCreateEditCurrency');
  Route::post('currencies/delete/{id}', 'CurrencyController@postDeleteCurrency');
  Route::post('currencies/sort/{type}', 'CurrencyController@postSortCurrency')->where('type', 'user|character');

  // RARITIES
  Route::get('rarities', 'RarityController@getIndex');
  Route::get('rarities/create', 'RarityController@getCreateRarity');
  Route::get('rarities/edit/{id}', 'RarityController@getEditRarity');
  Route::get('rarities/delete/{id}', 'RarityController@getDeleteRarity');
  Route::post('rarities/create', 'RarityController@postCreateEditRarity');
  Route::post('rarities/edit/{id?}', 'RarityController@postCreateEditRarity');
  Route::post('rarities/delete/{id}', 'RarityController@postDeleteRarity');
  Route::post('rarities/sort', 'RarityController@postSortRarity');

  // CHARACTER TITLES
  Route::get('character-titles', 'CharacterTitleController@getIndex');
  Route::get('character-titles/create', 'CharacterTitleController@getCreateTitle');
  Route::get('character-titles/edit/{id}', 'CharacterTitleController@getEditTitle');
  Route::get('character-titles/delete/{id}', 'CharacterTitleController@getDeleteTitle');
  Route::post('character-titles/create', 'CharacterTitleController@postCreateEditTitle');
  Route::post('character-titles/edit/{id?}', 'CharacterTitleController@postCreateEditTitle');
  Route::post('character-titles/delete/{id}', 'CharacterTitleController@postDeleteTitle');
  Route::post('character-titles/sort', 'CharacterTitleController@postSortTitle');

  // SPECIES
  Route::get('species', 'SpeciesController@getIndex');
  Route::get('species/create', 'SpeciesController@getCreateSpecies');
  Route::get('species/edit/{id}', 'SpeciesController@getEditSpecies');
  Route::get('species/delete/{id}', 'SpeciesController@getDeleteSpecies');
  Route::post('species/create', 'SpeciesController@postCreateEditSpecies');
  Route::post('species/edit/{id?}', 'SpeciesController@postCreateEditSpecies');
  Route::post('species/delete/{id}', 'SpeciesController@postDeleteSpecies');
  Route::post('species/sort', 'SpeciesController@postSortSpecies');
  Route::get('subtypes', 'SpeciesController@getSubtypeIndex');
  Route::get('subtypes/create', 'SpeciesController@getCreateSubtype');
  Route::get('subtypes/edit/{id}', 'SpeciesController@getEditSubtype');
  Route::get('subtypes/delete/{id}', 'SpeciesController@getDeleteSubtype');
  Route::post('subtypes/create', 'SpeciesController@postCreateEditSubtype');
  Route::post('subtypes/edit/{id?}', 'SpeciesController@postCreateEditSubtype');
  Route::post('subtypes/delete/{id}', 'SpeciesController@postDeleteSubtype');
  Route::post('subtypes/sort', 'SpeciesController@postSortSubtypes');

  // ITEMS
  Route::get('item-categories', 'ItemController@getIndex');
  Route::get('item-categories/create', 'ItemController@getCreateItemCategory');
  Route::get('item-categories/edit/{id}', 'ItemController@getEditItemCategory');
  Route::get('item-categories/delete/{id}', 'ItemController@getDeleteItemCategory');
  Route::post('item-categories/create', 'ItemController@postCreateEditItemCategory');
  Route::post('item-categories/edit/{id?}', 'ItemController@postCreateEditItemCategory');
  Route::post('item-categories/delete/{id}', 'ItemController@postDeleteItemCategory');
  Route::post('item-categories/sort', 'ItemController@postSortItemCategory');

  Route::get('items', 'ItemController@getItemIndex');
  Route::get('items/create', 'ItemController@getCreateItem');
  Route::get('items/edit/{id}', 'ItemController@getEditItem');
  Route::get('items/delete/{id}', 'ItemController@getDeleteItem');
  Route::post('items/create', 'ItemController@postCreateEditItem');
  Route::post('items/edit/{id?}', 'ItemController@postCreateEditItem');
  Route::post('items/delete/{id}', 'ItemController@postDeleteItem');

  Route::get('items/delete-tag/{id}/{tag}', 'ItemController@getDeleteItemTag');
  Route::post('items/delete-tag/{id}/{tag}', 'ItemController@postDeleteItemTag');
  Route::get('items/tag/{id}/{tag}', 'ItemController@getEditItemTag');
  Route::post('items/tag/{id}/{tag}', 'ItemController@postEditItemTag');
  Route::get('items/tag/{id}', 'ItemController@getAddItemTag');
  Route::post('items/tag/{id}', 'ItemController@postAddItemTag');

  # AWARDS
  Route::get('award-categories', 'AwardController@getIndex');
  Route::get('award-categories/create', 'AwardController@getCreateAwardCategory');
  Route::get('award-categories/edit/{id}', 'AwardController@getEditAwardCategory');
  Route::get('award-categories/delete/{id}', 'AwardController@getDeleteAwardCategory');
  Route::post('award-categories/create', 'AwardController@postCreateEditAwardCategory');
  Route::post('award-categories/edit/{id?}', 'AwardController@postCreateEditAwardCategory');
  Route::post('award-categories/delete/{id}', 'AwardController@postDeleteAwardCategory');
  Route::post('award-categories/sort', 'AwardController@postSortAwardCategory');

  Route::get('awards', 'AwardController@getAwardIndex');
  Route::get('awards/create', 'AwardController@getCreateAward');
  Route::get('awards/edit/{id}', 'AwardController@getEditAward');
  Route::get('awards/delete/{id}', 'AwardController@getDeleteAward');
  Route::post('awards/create', 'AwardController@postCreateEditAward');
  Route::post('awards/edit/{id?}', 'AwardController@postCreateEditAward');
  Route::post('awards/delete/{id}', 'AwardController@postDeleteAward');

  // PETS
  Route::get('pet-categories', 'PetController@getIndex');
  Route::get('pet-categories/create', 'PetController@getCreatePetCategory');
  Route::get('pet-categories/edit/{id}', 'PetController@getEditPetCategory');
  Route::get('pet-categories/delete/{id}', 'PetController@getDeletePetCategory');
  Route::post('pet-categories/create', 'PetController@postCreateEditPetCategory');
  Route::post('pet-categories/edit/{id?}', 'PetController@postCreateEditPetCategory');
  Route::post('pet-categories/delete/{id}', 'PetController@postDeletePetCategory');
  Route::post('pet-categories/sort', 'PetController@postSortPetCategory');

  Route::get('pets', 'PetController@getPetIndex');
  Route::get('pets/create', 'PetController@getCreatePet');
  Route::get('pets/edit/{id}', 'PetController@getEditPet');
  Route::get('pets/delete/{id}', 'PetController@getDeletePet');
  Route::post('pets/create', 'PetController@postCreateEditPet');
  Route::post('pets/edit/{id?}', 'PetController@postCreateEditPet');
  Route::post('pets/delete/{id}', 'PetController@postDeletePet');

  // evolutions
  Route::get('pets/edit/{pet_id}/evolution/create', 'PetController@getCreateEditEvolution');
  Route::get('pets/edit/{pet_id}/evolution/edit/{id}', 'PetController@getCreateEditEvolution');
  Route::post('pets/edit/{pet_id}/evolution/create', 'PetController@postCreateEditEvolution');
  Route::post('pets/edit/{pet_id}/evolution/edit/{id}', 'PetController@postCreateEditEvolution');

  Route::get('pets/drops', 'PetController@getDropIndex');
  Route::get('pets/drops/create', 'PetController@getCreateDrop');
  Route::get('pets/drops/edit/{pet_id}', 'PetController@getEditDrop');
  Route::get('pets/drops/delete/{pet_id}', 'PetController@getDeleteDrop');
  Route::post('pets/drops/create', 'PetController@postCreateEditDrop');
  Route::post('pets/drops/edit/{pet_id}', 'PetController@postCreateEditDrop');
  Route::post('pets/drops/delete/{pet_id}', 'PetController@postDeleteDrop');
  Route::get('pets/drops/widget/{id}', 'PetController@getDropWidget');

  // levels
  Route::get('pets/levels', 'PetController@getLevelIndex');
  Route::get('pets/levels/create', 'PetController@getCreateLevel');
  Route::get('pets/levels/edit/{id}', 'PetController@getEditLevel')->where('id', '[0-9]+');
  Route::get('pets/levels/delete/{id}', 'PetController@getDeleteLevel')->where('id', '[0-9]+');
  Route::post('pets/levels/create', 'PetController@postCreateEditLevel');
  Route::post('pets/levels/edit/{id}', 'PetController@postCreateEditLevel')->where('id', '[0-9]+');
  Route::post('pets/levels/delete/{id}', 'PetController@postDeleteLevel')->where('id', '[0-9]+');

  // level pets
  Route::get('pets/levels/edit/{level_id}/pets/add', 'PetController@getAddPetToLevel')->where('level_id', '[0-9]+');
  Route::get('pets/levels/edit/{level_id}/pets/edit/{id}', 'PetController@getEditPetLevel')->where('level_id', '[0-9]+')->where('id', '[0-9]+');
  Route::post('pets/levels/edit/{level_id}/pets/add', 'PetController@postAddPetToLevel')->where('level_id', '[0-9]+');
  Route::post('pets/levels/edit/{level_id}/pets/edit/{id}', 'PetController@postEditPetLevel')->where('level_id', '[0-9]+')->where('id', '[0-9]+');

  // RECIPES
  Route::get('recipes', 'RecipeController@getRecipeIndex');
  Route::get('recipes/create', 'RecipeController@getCreateRecipe');
  Route::get('recipes/edit/{id}', 'RecipeController@getEditRecipe');
  Route::get('recipes/delete/{id}', 'RecipeController@getDeleteRecipe');
  Route::post('recipes/create', 'RecipeController@postCreateEditRecipe');
  Route::post('recipes/edit/{id?}', 'RecipeController@postCreateEditRecipe');
  Route::post('recipes/delete/{id}', 'RecipeController@postDeleteRecipe');

  // SHOPS
  Route::get('shops', 'ShopController@getIndex');
  Route::get('shops/create', 'ShopController@getCreateShop');
  Route::get('shops/edit/{id}', 'ShopController@getEditShop');
  Route::get('shops/delete/{id}', 'ShopController@getDeleteShop');
  Route::post('shops/create', 'ShopController@postCreateEditShop');
  Route::post('shops/edit/{id?}', 'ShopController@postCreateEditShop');
  Route::post('shops/stock/{id}', 'ShopController@postEditShopStock');
  Route::post('shops/delete/{id}', 'ShopController@postDeleteShop');
  Route::post('shops/sort', 'ShopController@postSortShop');
  Route::post('shops/restrictions/{id}', 'ShopController@postRestrictShop');
  // stock
  // create
  Route::get('shops/stock/{id}', 'ShopController@getCreateShopStock');
  Route::post('shops/stock/{id}', 'ShopController@postCreateShopStock');
  // edit
  Route::get('shops/stock/edit/{id}', 'ShopController@getEditShopStock');
  Route::post('shops/stock/edit/{id}', 'ShopController@postEditShopStock');
  // delete
  Route::get('shops/stock/delete/{id}', 'ShopController@getDeleteShopStock');
  Route::post('shops/stock/delete/{id}', 'ShopController@postDeleteShopStock');
  // misc
  Route::get('shops/stock-type', 'ShopController@getShopStockType');

  // stock
  // create
  Route::get('shops/stock/{id}', 'ShopController@getCreateShopStock');
  Route::post('shops/stock/{id}', 'ShopController@postCreateShopStock');
  // edit
  Route::get('shops/stock/edit/{id}', 'ShopController@getEditShopStock');
  Route::post('shops/stock/edit/{id}', 'ShopController@postEditShopStock');
  // delete
  Route::get('shops/stock/delete/{id}', 'ShopController@getDeleteShopStock');
  Route::post('shops/stock/delete/{id}', 'ShopController@postDeleteShopStock');
  // misc
  Route::get('shops/stock-type', 'ShopController@getShopStockType');
  Route::get('shops/stock-cost-type', 'ShopController@getShopStockCostType');

  // FEATURES (TRAITS)
  Route::get('trait-categories', 'FeatureController@getIndex');
  Route::get('trait-categories/create', 'FeatureController@getCreateFeatureCategory');
  Route::get('trait-categories/edit/{id}', 'FeatureController@getEditFeatureCategory');
  Route::get('trait-categories/delete/{id}', 'FeatureController@getDeleteFeatureCategory');
  Route::post('trait-categories/create', 'FeatureController@postCreateEditFeatureCategory');
  Route::post('trait-categories/edit/{id?}', 'FeatureController@postCreateEditFeatureCategory');
  Route::post('trait-categories/delete/{id}', 'FeatureController@postDeleteFeatureCategory');
  Route::post('trait-categories/sort', 'FeatureController@postSortFeatureCategory');

  Route::get('traits', 'FeatureController@getFeatureIndex');
  Route::get('traits/create', 'FeatureController@getCreateFeature');
  Route::get('traits/edit/{id}', 'FeatureController@getEditFeature');
  Route::get('traits/delete/{id}', 'FeatureController@getDeleteFeature');
  Route::get('traits/check-subtype', 'FeatureController@getCreateEditFeatureSubtype');
  Route::post('traits/create', 'FeatureController@postCreateEditFeature');
  Route::post('traits/edit/{id?}', 'FeatureController@postCreateEditFeature');
  Route::post('traits/delete/{id}', 'FeatureController@postDeleteFeature');

  // CHARACTER CATEGORIES
  Route::get('character-categories', 'CharacterCategoryController@getIndex');
  Route::get('character-categories/create', 'CharacterCategoryController@getCreateCharacterCategory');
  Route::get('character-categories/edit/{id}', 'CharacterCategoryController@getEditCharacterCategory');
  Route::get('character-categories/delete/{id}', 'CharacterCategoryController@getDeleteCharacterCategory');
  Route::post('character-categories/create', 'CharacterCategoryController@postCreateEditCharacterCategory');
  Route::post('character-categories/edit/{id?}', 'CharacterCategoryController@postCreateEditCharacterCategory');
  Route::post('character-categories/delete/{id}', 'CharacterCategoryController@postDeleteCharacterCategory');
  Route::post('character-categories/sort', 'CharacterCategoryController@postSortCharacterCategory');

  // SUB MASTERLISTS
  Route::get('sublists', 'SublistController@getIndex');
  Route::get('sublists/create', 'SublistController@getCreateSublist');
  Route::get('sublists/edit/{id}', 'SublistController@getEditSublist');
  Route::get('sublists/delete/{id}', 'SublistController@getDeleteSublist');
  Route::post('sublists/create', 'SublistController@postCreateEditSublist');
  Route::post('sublists/edit/{id?}', 'SublistController@postCreateEditSublist');
  Route::post('sublists/delete/{id}', 'SublistController@postDeleteSublist');
  Route::post('sublists/sort', 'SublistController@postSortSublist');

  // LOOT TABLES
  Route::get('loot-tables', 'LootTableController@getIndex');
  Route::get('loot-tables/create', 'LootTableController@getCreateLootTable');
  Route::get('loot-tables/edit/{id}', 'LootTableController@getEditLootTable');
  Route::get('loot-tables/delete/{id}', 'LootTableController@getDeleteLootTable');
  Route::get('loot-tables/roll/{id}', 'LootTableController@getRollLootTable');
  Route::post('loot-tables/create', 'LootTableController@postCreateEditLootTable');
  Route::post('loot-tables/edit/{id?}', 'LootTableController@postCreateEditLootTable');
  Route::post('loot-tables/delete/{id}', 'LootTableController@postDeleteLootTable');

  // PROMPTS
  Route::get('prompt-categories', 'PromptController@getIndex');
  Route::get('prompt-categories/create', 'PromptController@getCreatePromptCategory');
  Route::get('prompt-categories/edit/{id}', 'PromptController@getEditPromptCategory');
  Route::get('prompt-categories/delete/{id}', 'PromptController@getDeletePromptCategory');
  Route::post('prompt-categories/create', 'PromptController@postCreateEditPromptCategory');
  Route::post('prompt-categories/edit/{id?}', 'PromptController@postCreateEditPromptCategory');
  Route::post('prompt-categories/delete/{id}', 'PromptController@postDeletePromptCategory');
  Route::post('prompt-categories/sort', 'PromptController@postSortPromptCategory');

  Route::get('prompts', 'PromptController@getPromptIndex');
  Route::get('prompts/create', 'PromptController@getCreatePrompt');
  Route::get('prompts/edit/{id}', 'PromptController@getEditPrompt');
  Route::get('prompts/delete/{id}', 'PromptController@getDeletePrompt');
  Route::post('prompts/create', 'PromptController@postCreateEditPrompt');
  Route::post('prompts/edit/{id?}', 'PromptController@postCreateEditPrompt');
  Route::post('prompts/delete/{id}', 'PromptController@postDeletePrompt');

  Route::get('advent-calendars', 'AdventController@getAdventIndex');
  Route::get('advent-calendars/create', 'AdventController@getCreateAdvent');
  Route::get('advent-calendars/edit/{id}', 'AdventController@getEditAdvent');
  Route::get('advent-calendars/delete/{id}', 'AdventController@getDeleteAdvent');
  Route::post('advent-calendars/create', 'AdventController@postCreateEditAdvent');
  Route::post('advent-calendars/edit/{id?}', 'AdventController@postCreateEditAdvent');
  Route::post('advent-calendars/delete/{id}', 'AdventController@postDeleteAdvent');

  # SCAVENGER HUNTS
  Route::get('hunts', 'HuntController@getHuntIndex');
  Route::get('hunts/create', 'HuntController@getCreateHunt');
  Route::get('hunts/edit/{id}', 'HuntController@getEditHunt');
  Route::get('hunts/delete/{id}', 'HuntController@getDeleteHunt');
  Route::post('hunts/create', 'HuntController@postCreateEditHunt');
  Route::post('hunts/edit/{id?}', 'HuntController@postCreateEditHunt');
  Route::post('hunts/delete/{id}', 'HuntController@postDeleteHunt');

  Route::get('hunts/targets/create/{id}', 'HuntController@getCreateHuntTarget');
  Route::post('hunts/targets/create', 'HuntController@postCreateEditHuntTarget');
  Route::get('hunts/targets/edit/{id}', 'HuntController@getEditHuntTarget');
  Route::post('hunts/targets/edit/{id}', 'HuntController@postCreateEditHuntTarget');
  Route::get('hunts/targets/delete/{id}', 'HuntController@getDeleteHuntTarget');
  Route::post('hunts/targets/delete/{id}', 'HuntController@postDeleteHuntTarget');

  # DAILIES
  Route::get('dailies', 'DailyController@getIndex');
  Route::get('dailies/create', 'DailyController@getCreateDaily');
  Route::get('dailies/edit/{id}', 'DailyController@getEditDaily');
  Route::get('dailies/delete/{id}', 'DailyController@getDeleteDaily');
  Route::post('dailies/create', 'DailyController@postCreateEditDaily');
  Route::post('dailies/edit/{id?}', 'DailyController@postCreateEditDaily');
  Route::post('dailies/delete/{id}', 'DailyController@postDeleteDaily');
  Route::post('dailies/sort', 'DailyController@postSortDaily');

  # PROFESSIONS
  Route::get('profession-categories', 'ProfessionController@getCategoryIndex');
  Route::get('profession-categories/create', 'ProfessionController@getCreateProfessionCategory');
  Route::get('profession-categories/edit/{id}', 'ProfessionController@getEditProfessionCategory');
  Route::get('profession-categories/delete/{id}', 'ProfessionController@getDeleteProfessionCategory');
  Route::post('profession-categories/create', 'ProfessionController@postCreateEditProfessionCategory');
  Route::post('profession-categories/edit/{id?}', 'ProfessionController@postCreateEditProfessionCategory');
  Route::post('profession-categories/delete/{id}', 'ProfessionController@postDeleteProfessionCategory');
  Route::post('profession-categories/sort', 'ProfessionController@postSortProfessionCategory');

  Route::get('profession-subcategories', 'ProfessionController@getSubcategoryIndex');
  Route::get('profession-subcategories/create', 'ProfessionController@getCreateProfessionSubcategory');
  Route::get('profession-subcategories/edit/{id}', 'ProfessionController@getEditProfessionSubcategory');
  Route::get('profession-subcategories/delete/{id}', 'ProfessionController@getDeleteProfessionSubcategory');
  Route::post('profession-subcategories/create', 'ProfessionController@postCreateEditProfessionSubcategory');
  Route::post('profession-subcategories/edit/{id?}', 'ProfessionController@postCreateEditProfessionSubcategory');
  Route::post('profession-subcategories/delete/{id}', 'ProfessionController@postDeleteProfessionSubcategory');
  Route::post('profession-subcategories/sort', 'ProfessionController@postSortProfessionSubcategory');

  Route::get('professions', 'ProfessionController@getProfessionIndex');
  Route::get('professions/create', 'ProfessionController@getCreateProfession');
  Route::get('professions/edit/{id}', 'ProfessionController@getEditProfession');
  Route::get('professions/delete/{id}', 'ProfessionController@getDeleteProfession');
  Route::post('professions/create', 'ProfessionController@postCreateEditProfession');
  Route::post('professions/edit/{id?}', 'ProfessionController@postCreateEditProfession');
  Route::post('professions/delete/{id}', 'ProfessionController@postDeleteProfession');
  Route::post('professions/sort', 'ProfessionController@postSortProfession');


  # BORDERS
  Route::get('border-categories', 'BorderController@getIndex');
  Route::get('border-categories/create', 'BorderController@getCreateBorderCategory');
  Route::get('border-categories/edit/{id}', 'BorderController@getEditBorderCategory');
  Route::get('border-categories/delete/{id}', 'BorderController@getDeleteBorderCategory');
  Route::post('border-categories/create', 'BorderController@postCreateEditBorderCategory');
  Route::post('border-categories/edit/{id?}', 'BorderController@postCreateEditBorderCategory');
  Route::post('border-categories/delete/{id}', 'BorderController@postDeleteBorderCategory');
  Route::post('border-categories/sort', 'BorderController@postSortBorderCategory');

  Route::get('borders', 'BorderController@getBorderIndex');
  Route::get('borders/create', 'BorderController@getCreateBorder');
  Route::get('borders/edit/{id}', 'BorderController@getEditBorder');
  Route::get('borders/delete/{id}', 'BorderController@getDeleteBorder');
  Route::post('borders/create', 'BorderController@postCreateEditBorder');
  Route::post('borders/edit/{id?}', 'BorderController@postCreateEditBorder');
  Route::post('borders/delete/{id}', 'BorderController@postDeleteBorder');

  Route::get('borders/edit/{border_id}/{type}s/create', 'BorderController@getCreateEditVariant');
  Route::get('borders/edit/{border_id}/{type}s/edit/{id}', 'BorderController@getCreateEditVariant');
  Route::post('borders/edit/{border_id}/{type}s/create', 'BorderController@postCreateEditVariant');
  Route::post('borders/edit/{border_id}/{type}s/edit/{id}', 'BorderController@postCreateEditVariant');

  Route::post('borders/item/{id}', 'BorderController@postCreateItem');

  # TRANSFORMATIONS
  Route::get('transformations', 'TransformationController@getTransformationIndex');
  Route::get('transformations/create', 'TransformationController@getCreateTransformation');
  Route::get('transformations/edit/{id}', 'TransformationController@getEditTransformation');
  Route::get('transformations/delete/{id}', 'TransformationController@getDeleteTransformation');
  Route::post('transformations/create', 'TransformationController@postCreateEditTransformation');
  Route::post('transformations/edit/{id?}', 'TransformationController@postCreateEditTransformation');
  Route::post('transformations/delete/{id}', 'TransformationController@postDeleteTransformation');
  Route::post('transformations/sort', 'TransformationController@postSortTransformations');

  // DYNAMIC LIMITS
  Route::get('limits', 'LimitController@getIndex');
  Route::get('limits/create', 'LimitController@getCreateLimit');
  Route::get('limits/edit/{id}', 'LimitController@getEditLimit');
  Route::get('limits/delete/{id}', 'LimitController@getDeleteLimit');
  Route::post('limits/create', 'LimitController@postCreateEditLimit');
  Route::post('limits/edit/{id?}', 'LimitController@postCreateEditLimit');
  Route::post('limits/delete/{id}', 'LimitController@postDeleteLimit');

  // Criteria
  Route::get('criteria', 'CriterionController@getIndex');
  Route::get('criteria/create', 'CriterionController@getCreateEditCriterion');
  Route::post('criteria/create', 'CriterionController@postCreateEditCriterion');
  Route::get('criteria/edit/{id}', 'CriterionController@getCreateEditCriterion');
  Route::post('criteria/edit/{id}', 'CriterionController@postCreateEditCriterion');
  Route::get('criteria/{id}/step', 'CriterionController@getCreateEditCriterionStep');
  Route::get('criteria/{id}/step/{step_id}', 'CriterionController@getCreateEditCriterionStep');
  Route::post('criteria/{id}/step', 'CriterionController@postCreateEditCriterionStep');
  Route::post('criteria/{id}/step/{step_id}', 'CriterionController@postCreateEditCriterionStep');
  Route::get('criteria/delete/{id}', 'CriterionController@getDeleteCriterion');
  Route::post('criteria/delete/{id}', 'CriterionController@postDeleteCriterion');
  Route::get('criteria/step/delete/{step_id}', 'CriterionController@getDeleteCriterionStep');
  Route::post('criteria/step/delete/{id}', 'CriterionController@postDeleteCriterionStep');
  Route::get('criteria/step/{step_id}/option/{id}', 'CriterionController@getCreateEditCriterionOption');
  Route::get('criteria/step/{step_id}/option', 'CriterionController@getCreateEditCriterionOption');
  Route::post('criteria/step/{step_id}/option', 'CriterionController@postCreateEditCriterionOption');
  Route::post('criteria/step/{step_id}/option/{id}', 'CriterionController@postCreateEditCriterionOption');
  Route::get('criteria/option/delete/{id}', 'CriterionController@getDeleteCriterionOption');
  Route::post('criteria/option/delete/{id}', 'CriterionController@postDeleteCriterionOption');

  Route::get('criteria-defaults', 'CriterionController@getDefaultIndex');
  Route::get('criteria-defaults/create', 'CriterionController@getCreateEditCriterionDefault');
  Route::post('criteria-defaults/create', 'CriterionController@postCreateEditCriterionDefault');
  Route::get('criteria-defaults/edit/{id}', 'CriterionController@getCreateEditCriterionDefault');
  Route::post('criteria-defaults/edit/{id}', 'CriterionController@postCreateEditCriterionDefault');
  Route::get('criteria-defaults/delete/{id}', 'CriterionController@getDeleteCriterionDefault');
  Route::post('criteria-defaults/delete/{id}', 'CriterionController@postDeleteCriterionDefault');

  # ENCOUNTERS
  Route::get('encounters', 'EncounterController@getEncounterIndex');
  Route::get('encounters/create', 'EncounterController@getCreateEncounter');
  Route::get('encounters/edit/{id}', 'EncounterController@getEditEncounter');
  Route::get('encounters/delete/{id}', 'EncounterController@getDeleteEncounter');
  Route::post('encounters/create', 'EncounterController@postCreateEditEncounter');
  Route::post('encounters/edit/{id?}', 'EncounterController@postCreateEditEncounter');
  Route::post('encounters/delete/{id}', 'EncounterController@postDeleteEncounter');

  Route::get('encounters/edit/{encounter_id}/prompts/create', 'EncounterController@getCreateEditPrompt');
  Route::get('encounters/edit/{encounter_id}/prompts/edit/{id}', 'EncounterController@getCreateEditPrompt');
  Route::post('encounters/edit/{encounter_id}/prompts/create', 'EncounterController@postCreateEditPrompt');
  Route::post('encounters/edit/{encounter_id}/prompts/edit/{id}', 'EncounterController@postCreateEditPrompt');

  # ENCOUNTER AREAS
  Route::get('encounters/areas', 'EncounterController@getEncounterAreaIndex');
  Route::get('encounters/areas/create', 'EncounterController@getCreateEncounterArea');
  Route::get('encounters/areas/edit/{id}', 'EncounterController@getEditEncounterArea');
  Route::get('encounters/areas/delete/{id}', 'EncounterController@getDeleteEncounterArea');
  Route::post('encounters/areas/create', 'EncounterController@postCreateEditEncounterArea');
  Route::post('encounters/areas/edit/{id?}', 'EncounterController@postCreateEditEncounterArea');
  Route::post('encounters/areas/delete/{id}', 'EncounterController@postDeleteEncounterArea');
  Route::get('encounters/areas/roll/{id}', 'EncounterController@getRollArea');
  Route::post('encounters/areas/restrictions/{id}', 'EncounterController@postRestrictArea');
});

// PAGES
Route::group(['prefix' => 'pages', 'middleware' => 'power:edit_pages'], function () {
  Route::get('/', 'PageController@getIndex');
  Route::get('create', 'PageController@getCreatePage');
  Route::get('edit/{id}', 'PageController@getEditPage');
  Route::get('delete/{id}', 'PageController@getDeletePage');
  Route::get('regen/{id}', 'PageController@getRegenPage');
  Route::post('create', 'PageController@postCreateEditPage');
  Route::post('edit/{id?}', 'PageController@postCreateEditPage');
  Route::post('delete/{id}', 'PageController@postDeletePage');
  Route::post('regen/{id}', 'PageController@postRegenPage');
});

// NEWS
Route::group(['prefix' => 'news', 'middleware' => 'power:manage_news'], function () {
  Route::get('/', 'NewsController@getIndex');
  Route::get('create', 'NewsController@getCreateNews');
  Route::get('edit/{id}', 'NewsController@getEditNews');
  Route::get('delete/{id}', 'NewsController@getDeleteNews');
  Route::get('regen/{id}', 'NewsController@getRegenNews');
  Route::post('create', 'NewsController@postCreateEditNews');
  Route::post('edit/{id?}', 'NewsController@postCreateEditNews');
  Route::post('delete/{id}', 'NewsController@postDeleteNews');
  Route::post('regen/{id}', 'NewsController@postRegenNews');
});


# FORMS
Route::group(['prefix' => 'forms', 'middleware' => 'power:manage_sales'], function () {

  Route::get('/', 'SiteFormController@getIndex');
  Route::get('create', 'SiteFormController@getCreateSiteForm');
  Route::get('edit/{id}', 'SiteFormController@getEditSiteForm');
  Route::get('delete/{id}', 'SiteFormController@getDeleteSiteForm');
  Route::post('create', 'SiteFormController@postCreateEditSiteForm');
  Route::post('edit/{id?}', 'SiteFormController@postCreateEditSiteForm');
  Route::post('delete/{id}', 'SiteFormController@postDeleteSiteForm');
  Route::get('results/{id}', 'SiteFormController@getSiteFormResults');
});

# FORMS
Route::group(['prefix' => 'forms', 'middleware' => 'power:edit_pages'], function () {
  Route::get('/', 'SiteFormController@getIndex');
  Route::get('create', 'SiteFormController@getCreateSiteForm');
  Route::get('edit/{id}', 'SiteFormController@getEditSiteForm');
  Route::get('delete/{id}', 'SiteFormController@getDeleteSiteForm');
  Route::post('create', 'SiteFormController@postCreateEditSiteForm');
  Route::post('edit/{id?}', 'SiteFormController@postCreateEditSiteForm');
  Route::post('delete/{id}', 'SiteFormController@postDeleteSiteForm');
  Route::get('results/{id}', 'SiteFormController@getSiteFormResults');
});

// SALES
Route::group(['prefix' => 'sales', 'middleware' => 'power:manage_sales'], function () {
  Route::get('/', 'SalesController@getIndex');
  Route::get('create', 'SalesController@getCreateSales');
  Route::get('edit/{id}', 'SalesController@getEditSales');
  Route::get('delete/{id}', 'SalesController@getDeleteSales');
  Route::post('create', 'SalesController@postCreateEditSales');
  Route::post('edit/{id?}', 'SalesController@postCreateEditSales');
  Route::post('delete/{id}', 'SalesController@postDeleteSales');

  Route::get('character/{slug}', 'SalesController@getCharacterInfo');
});

// SITE SETTINGS
Route::group(['prefix' => 'settings', 'middleware' => 'power:edit_site_settings'], function () {
  Route::get('/', 'SettingsController@getIndex');
  Route::post('{key}', 'SettingsController@postEditSetting');
});

// GRANTS
Route::group(['prefix' => 'grants', 'namespace' => 'Users', 'middleware' => 'power:edit_inventories'], function () {
  Route::get('user-currency', 'GrantController@getUserCurrency');
  Route::post('user-currency', 'GrantController@postUserCurrency');

  Route::get('item-search', 'GrantController@getItemSearch');
  Route::get('items', 'GrantController@getItems');
  Route::post('items', 'GrantController@postItems');

  Route::get('pets', 'GrantController@getPets');
  Route::post('pets', 'GrantController@postPets');
  Route::get('pets/variants/{id}', 'GrantController@getPetVariants');
  Route::get('pets/evolutions/{id}', 'GrantController@getPetEvolutions');
  Route::get('awards', 'GrantController@getAwards');
  Route::post('awards', 'GrantController@postAwards');
  Route::get('borders', 'GrantController@getBorders');
  Route::post('borders', 'GrantController@postBorders');
  Route::get('recipes', 'GrantController@getRecipes');
  Route::post('recipes', 'GrantController@postRecipes');
  
  Route::get('encounter-energy', 'GrantController@getEncounterEnergyGrants');
  Route::post('encounter-energy', 'GrantController@postEncounterEnergyGrant');
});

// PETS
Route::group(['prefix' => 'pets', 'middleware' => 'power:edit_inventories'], function () {
  Route::post('pet/{id}', 'Data\PetController@postEditPetDrop');
});

// MASTERLIST
Route::group(['prefix' => 'masterlist', 'namespace' => 'Characters', 'middleware' => 'power:manage_characters'], function () {
  Route::get('create-character', 'CharacterController@getCreateCharacter');
  Route::post('create-character', 'CharacterController@postCreateCharacter');

  Route::get('get-number', 'CharacterController@getPullNumber');

  Route::get('transfers/{type}', 'CharacterController@getTransferQueue');
  Route::get('transfer/{id}', 'CharacterController@getTransferInfo');
  Route::get('transfer/act/{id}/{type}', 'CharacterController@getTransferModal');
  Route::post('transfer/{id}', 'CharacterController@postTransferQueue');

  Route::get('trades/{type}', 'CharacterController@getTradeQueue');
  Route::get('trade/{id}', 'CharacterController@getTradeInfo');
  Route::get('trade/act/{id}/{type}', 'CharacterController@getTradeModal');
  Route::post('trade/{id}', 'CharacterController@postTradeQueue');

  Route::get('create-myo', 'CharacterController@getCreateMyo');
  Route::post('create-myo', 'CharacterController@postCreateMyo');

  Route::get('check-subtype', 'CharacterController@getCreateCharacterMyoSubtype');
  Route::get('get-warnings', 'CharacterController@getContentWarnings');
  Route::get('check-transformation', 'CharacterController@getCreateCharacterMyoTransformation');
});
Route::group(['prefix' => 'character', 'namespace' => 'Characters', 'middleware' => 'power:edit_inventories'], function () {
  Route::post('{slug}/grant', 'GrantController@postCharacterCurrency');
  Route::post('{slug}/grant-items', 'GrantController@postCharacterItems');
  Route::post('{slug}/grant-awards', 'GrantController@postCharacterAwards');
});
Route::group(['prefix' => 'character', 'namespace' => 'Characters', 'middleware' => 'power:manage_characters'], function () {
  // IMAGES
  Route::get('{slug}/image', 'CharacterImageController@getNewImage');
  Route::post('{slug}/image', 'CharacterImageController@postNewImage');
  Route::get('image/subtype', 'CharacterImageController@getNewImageSubtype');

  Route::get('image/{id}/traits', 'CharacterImageController@getEditImageFeatures');
  Route::post('image/{id}/traits', 'CharacterImageController@postEditImageFeatures');
  Route::get('image/traits/subtype', 'CharacterImageController@getEditImageSubtype');

  Route::get('image/{id}/notes', 'CharacterImageController@getEditImageNotes');
  Route::post('image/{id}/notes', 'CharacterImageController@postEditImageNotes');

  Route::get('image/{id}/credits', 'CharacterImageController@getEditImageCredits');
  Route::post('image/{id}/credits', 'CharacterImageController@postEditImageCredits');

  Route::get('image/{id}/reupload', 'CharacterImageController@getImageReupload');
  Route::post('image/{id}/reupload', 'CharacterImageController@postImageReupload');

  Route::post('image/{id}/settings', 'CharacterImageController@postImageSettings');

  Route::get('image/{id}/active', 'CharacterImageController@getImageActive');
  Route::post('image/{id}/active', 'CharacterImageController@postImageActive');

  Route::get('image/{id}/delete', 'CharacterImageController@getImageDelete');
  Route::post('image/{id}/delete', 'CharacterImageController@postImageDelete');

  Route::post('{slug}/images/sort', 'CharacterImageController@postSortImages');
  Route::get('image/transformation', 'CharacterImageController@getNewImageTransformation');
  Route::get('image/traits/transformation', 'CharacterImageController@getEditImageTransformation');

  Route::post('image/{id}/colours', 'CharacterImageController@postImageColours');

  // CHARACTER
  Route::get('{slug}/stats', 'CharacterController@getEditCharacterStats');
  Route::post('{slug}/stats', 'CharacterController@postEditCharacterStats');

  Route::get('{slug}/description', 'CharacterController@getEditCharacterDescription');
  Route::post('{slug}/description', 'CharacterController@postEditCharacterDescription');

  Route::get('{slug}/profile', 'CharacterController@getEditCharacterProfile');
  Route::post('{slug}/profile', 'CharacterController@postEditCharacterProfile');

  Route::get('{slug}/delete', 'CharacterController@getCharacterDelete');
  Route::post('{slug}/delete', 'CharacterController@postCharacterDelete');

  Route::post('{slug}/settings', 'CharacterController@postCharacterSettings');

  Route::post('{slug}/transfer', 'CharacterController@postTransfer');

  # LINEAGE
  Route::get('{slug}/lineage', 'CharacterLineageController@getEditCharacterLineage');
  Route::post('{slug}/lineage', 'CharacterLineageController@postEditCharacterLineage');
});
// Might rewrite these parts eventually so there's less code duplication...
Route::group(['prefix' => 'myo', 'namespace' => 'Characters', 'middleware' => 'power:manage_characters'], function () {
  // CHARACTER
  Route::get('{id}/stats', 'CharacterController@getEditMyoStats');
  Route::post('{id}/stats', 'CharacterController@postEditMyoStats');

  Route::get('{id}/description', 'CharacterController@getEditMyoDescription');
  Route::post('{id}/description', 'CharacterController@postEditMyoDescription');

  Route::get('{id}/profile', 'CharacterController@getEditMyoProfile');
  Route::post('{id}/profile', 'CharacterController@postEditMyoProfile');

  Route::get('{id}/delete', 'CharacterController@getMyoDelete');
  Route::post('{id}/delete', 'CharacterController@postMyoDelete');

  Route::post('{id}/settings', 'CharacterController@postMyoSettings');

  Route::post('{id}/transfer', 'CharacterController@postMyoTransfer');

  # LINEAGE
  Route::get('{id}/lineage', 'CharacterLineageController@getEditMyoLineage');
  Route::post('{id}/lineage', 'CharacterLineageController@postEditMyoLineage');
});

// RAFFLES
Route::group(['prefix' => 'raffles', 'middleware' => 'power:manage_raffles'], function () {
  Route::get('/', 'RaffleController@getRaffleIndex');
  Route::get('edit/group/{id?}', 'RaffleController@getCreateEditRaffleGroup');
  Route::post('edit/group/{id?}', 'RaffleController@postCreateEditRaffleGroup');
  Route::get('edit/raffle/{id?}', 'RaffleController@getCreateEditRaffle');
  Route::post('edit/raffle/{id?}', 'RaffleController@postCreateEditRaffle');

  Route::get('view/{id}', 'RaffleController@getRaffleTickets');
  Route::post('view/ticket/{id}', 'RaffleController@postCreateRaffleTickets');
  Route::post('view/ticket/delete/{id}', 'RaffleController@postDeleteRaffleTicket');

  Route::get('roll/raffle/{id}', 'RaffleController@getRollRaffle');
  Route::post('roll/raffle/{id}', 'RaffleController@postRollRaffle');
  Route::get('roll/group/{id}', 'RaffleController@getRollRaffleGroup');
  Route::post('roll/group/{id}', 'RaffleController@postRollRaffleGroup');
});

# CULTIVATION
Route::group(['prefix' => 'cultivation', 'middleware' => 'power:edit_data'], function () {
  Route::get('areas', 'CultivationController@getAreaIndex');
  Route::get('plots', 'CultivationController@getPlotIndex');

  Route::get('areas/edit/{id?}', 'CultivationController@getCreateEditArea');
  Route::post('areas/edit/{id?}', 'CultivationController@postCreateEditArea');
  Route::get('plots/edit/{id?}', 'CultivationController@getCreateEditPlot');
  Route::post('plots/edit/{id?}', 'CultivationController@postCreateEditPlot');
  Route::post('areas/sort', 'CultivationController@postSortAreas');
  Route::post('plots/sort', 'CultivationController@postSortPlot');
  Route::get('areas/delete/{id}', 'CultivationController@getDeleteArea');
  Route::get('plots/delete/{id}', 'CultivationController@getDeletePlot');
  Route::post('areas/delete/{id}', 'CultivationController@postDeleteArea');
  Route::post('plots/delete/{id}', 'CultivationController@postDeletePlot');
});


# SUBMISSIONS
Route::group(['prefix' => 'submissions', 'middleware' => 'power:manage_submissions'], function () {
  Route::get('/', 'SubmissionController@getSubmissionIndex');
  Route::get('/{status}', 'SubmissionController@getSubmissionIndex')->where('status', 'pending|approved|rejected');
  Route::get('edit/{id}', 'SubmissionController@getSubmission');
  Route::post('edit/{id}/{action}', 'SubmissionController@postSubmission')->where('action', 'approve|reject|cancel');
});

// CLAIMS
Route::group(['prefix' => 'claims', 'middleware' => 'power:manage_submissions'], function () {
  Route::get('/', 'SubmissionController@getClaimIndex');
  Route::get('/{status}', 'SubmissionController@getClaimIndex')->where('status', 'pending|approved|rejected');
  Route::get('edit/{id}', 'SubmissionController@getClaim');
  Route::post('edit/{id}/{action}', 'SubmissionController@postSubmission')->where('action', 'approve|reject|cancel');
});

// SUBMISSIONS
Route::group(['prefix' => 'gallery', 'middleware' => 'power:manage_submissions'], function () {
  Route::get('/submissions', 'GalleryController@getSubmissionIndex');
  Route::get('/submissions/{status}', 'GalleryController@getSubmissionIndex')->where('status', 'pending|accepted|rejected');
  Route::get('/currency', 'GalleryController@getCurrencyIndex');
  Route::get('/currency/{status}', 'GalleryController@getCurrencyIndex')->where('status', 'pending|valued');
  Route::post('edit/{id}/{action}', 'GalleryController@postEditSubmission')->where('action', 'accept|reject|comment|move|value');
});

// REPORTS
Route::group(['prefix' => 'reports', 'middleware' => 'power:manage_reports'], function () {
  Route::get('/', 'ReportController@getReportIndex');
  Route::get('/{status}', 'ReportController@getReportIndex')->where('status', 'pending|assigned|assigned-to-me|closed');
  Route::get('edit/{id}', 'ReportController@getReport');
  Route::post('edit/{id}/{action}', 'ReportController@postReport')->where('action', 'assign|close');
});

// DESIGN APPROVALS
Route::group(['prefix' => 'designs', 'middleware' => 'power:manage_characters'], function () {
  Route::get('edit/{id}/{action}', 'DesignController@getDesignConfirmation')->where('action', 'cancel|approve|reject');
  Route::post('edit/{id}/{action}', 'DesignController@postDesign')->where('action', 'cancel|approve|reject');
  Route::post('vote/{id}/{action}', 'DesignController@postVote')->where('action', 'approve|reject');
});

Route::get('{type}/{status}', 'DesignController@getDesignIndex')->where('type', 'myo-approvals|design-approvals')->where('status', 'pending|approved|rejected');

// LIMITS
Route::group(['prefix' => 'limits', 'middleware' => 'power:manage_data'], function () {
  Route::post('/', 'LimitController@postCreateEditLimits');
});

// WORLD EXPANSION
Route::group(['prefix' => 'world', 'namespace' => 'World', 'middleware' => 'power:manage_world'], function () {
  // LOCATIONS
  Route::get('location-types', 'LocationController@getIndex');
  Route::get('location-types/create', 'LocationController@getCreateLocationType');
  Route::get('location-types/edit/{id}', 'LocationController@getEditLocationType');
  Route::get('location-types/delete/{id}', 'LocationController@getDeleteLocationType');
  Route::post('location-types/create', 'LocationController@postCreateEditLocationType');
  Route::post('location-types/edit/{id?}', 'LocationController@postCreateEditLocationType');
  Route::post('location-types/delete/{id}', 'LocationController@postDeleteLocationType');
  Route::post('location-types/sort', 'LocationController@postSortLocationType');

  Route::get('locations', 'LocationController@getLocationIndex');
  Route::get('locations/create', 'LocationController@getCreateLocation');
  Route::get('locations/edit/{id}', 'LocationController@getEditLocation');
  Route::get('locations/delete/{id}', 'LocationController@getDeleteLocation');
  Route::post('locations/create', 'LocationController@postCreateEditLocation');
  Route::post('locations/edit/{id?}', 'LocationController@postCreateEditLocation');
  Route::post('locations/delete/{id}', 'LocationController@postDeleteLocation');
  Route::post('locations/sort', 'LocationController@postSortLocation');

  // FAUNA
  Route::get('fauna-categories', 'FaunaController@getFaunaCategories');
  Route::get('fauna-categories/create', 'FaunaController@getCreateFaunaCategory');
  Route::get('fauna-categories/edit/{id}', 'FaunaController@getEditFaunaCategory');
  Route::get('fauna-categories/delete/{id}', 'FaunaController@getDeleteFaunaCategory');
  Route::post('fauna-categories/create', 'FaunaController@postCreateEditFaunaCategory');
  Route::post('fauna-categories/edit/{id?}', 'FaunaController@postCreateEditFaunaCategory');
  Route::post('fauna-categories/delete/{id}', 'FaunaController@postDeleteFaunaCategory');
  Route::post('fauna-categories/sort', 'FaunaController@postSortFaunaCategory');

  Route::get('faunas', 'FaunaController@getFaunaIndex');
  Route::get('faunas/create', 'FaunaController@getCreateFauna');
  Route::get('faunas/edit/{id}', 'FaunaController@getEditFauna');
  Route::get('faunas/delete/{id}', 'FaunaController@getDeleteFauna');
  Route::post('faunas/create', 'FaunaController@postCreateEditFauna');
  Route::post('faunas/edit/{id?}', 'FaunaController@postCreateEditFauna');
  Route::post('faunas/delete/{id}', 'FaunaController@postDeleteFauna');
  Route::post('faunas/sort', 'FaunaController@postSortFauna');

  // FLORA
  Route::get('flora-categories', 'FloraController@getFloraCategories');
  Route::get('flora-categories/create', 'FloraController@getCreateFloraCategory');
  Route::get('flora-categories/edit/{id}', 'FloraController@getEditFloraCategory');
  Route::get('flora-categories/delete/{id}', 'FloraController@getDeleteFloraCategory');
  Route::post('flora-categories/create', 'FloraController@postCreateEditFloraCategory');
  Route::post('flora-categories/edit/{id?}', 'FloraController@postCreateEditFloraCategory');
  Route::post('flora-categories/delete/{id}', 'FloraController@postDeleteFloraCategory');
  Route::post('flora-categories/sort', 'FloraController@postSortFloraCategory');

  Route::get('floras', 'FloraController@getFloraIndex');
  Route::get('floras/create', 'FloraController@getCreateFlora');
  Route::get('floras/edit/{id}', 'FloraController@getEditFlora');
  Route::get('floras/delete/{id}', 'FloraController@getDeleteFlora');
  Route::post('floras/create', 'FloraController@postCreateEditFlora');
  Route::post('floras/edit/{id?}', 'FloraController@postCreateEditFlora');
  Route::post('floras/delete/{id}', 'FloraController@postDeleteFlora');
  Route::post('floras/sort', 'FloraController@postSortFlora');

  // EVENTS
  Route::get('event-categories', 'EventController@getEventCategories');
  Route::get('event-categories/create', 'EventController@getCreateEventCategory');
  Route::get('event-categories/edit/{id}', 'EventController@getEditEventCategory');
  Route::get('event-categories/delete/{id}', 'EventController@getDeleteEventCategory');
  Route::post('event-categories/create', 'EventController@postCreateEditEventCategory');
  Route::post('event-categories/edit/{id?}', 'EventController@postCreateEditEventCategory');
  Route::post('event-categories/delete/{id}', 'EventController@postDeleteEventCategory');
  Route::post('event-categories/sort', 'EventController@postSortEventCategory');

  Route::get('events', 'EventController@getEventIndex');
  Route::get('events/create', 'EventController@getCreateEvent');
  Route::get('events/edit/{id}', 'EventController@getEditEvent');
  Route::get('events/delete/{id}', 'EventController@getDeleteEvent');
  Route::post('events/create', 'EventController@postCreateEditEvent');
  Route::post('events/edit/{id?}', 'EventController@postCreateEditEvent');
  Route::post('events/delete/{id}', 'EventController@postDeleteEvent');
  Route::post('events/sort', 'EventController@postSortEvent');

  // FIGURES
  Route::get('figure-categories', 'FigureController@getFigureCategories');
  Route::get('figure-categories/create', 'FigureController@getCreateFigureCategory');
  Route::get('figure-categories/edit/{id}', 'FigureController@getEditFigureCategory');
  Route::get('figure-categories/delete/{id}', 'FigureController@getDeleteFigureCategory');
  Route::post('figure-categories/create', 'FigureController@postCreateEditFigureCategory');
  Route::post('figure-categories/edit/{id?}', 'FigureController@postCreateEditFigureCategory');
  Route::post('figure-categories/delete/{id}', 'FigureController@postDeleteFigureCategory');
  Route::post('figure-categories/sort', 'FigureController@postSortFigureCategory');

  Route::get('figures', 'FigureController@getFigureIndex');
  Route::get('figures/create', 'FigureController@getCreateFigure');
  Route::get('figures/edit/{id}', 'FigureController@getEditFigure');
  Route::get('figures/delete/{id}', 'FigureController@getDeleteFigure');
  Route::post('figures/create', 'FigureController@postCreateEditFigure');
  Route::post('figures/edit/{id?}', 'FigureController@postCreateEditFigure');
  Route::post('figures/delete/{id}', 'FigureController@postDeleteFigure');
  Route::post('figures/sort', 'FigureController@postSortFigure');

  // FACTIONS
  Route::get('faction-types', 'FactionController@getIndex');
  Route::get('faction-types/create', 'FactionController@getCreateFactionType');
  Route::get('faction-types/edit/{id}', 'FactionController@getEditFactionType');
  Route::get('faction-types/delete/{id}', 'FactionController@getDeleteFactionType');
  Route::post('faction-types/create', 'FactionController@postCreateEditFactionType');
  Route::post('faction-types/edit/{id?}', 'FactionController@postCreateEditFactionType');
  Route::post('faction-types/delete/{id}', 'FactionController@postDeleteFactionType');
  Route::post('faction-types/sort', 'FactionController@postSortFactionType');

  Route::get('factions', 'FactionController@getFactionIndex');
  Route::get('factions/create', 'FactionController@getCreateFaction');
  Route::get('factions/edit/{id}', 'FactionController@getEditFaction');
  Route::get('factions/delete/{id}', 'FactionController@getDeleteFaction');
  Route::post('factions/create', 'FactionController@postCreateEditFaction');
  Route::post('factions/edit/{id?}', 'FactionController@postCreateEditFaction');
  Route::post('factions/delete/{id}', 'FactionController@postDeleteFaction');
  Route::post('factions/sort', 'FactionController@postSortFaction');

  // CONCEPTS
  Route::get('concept-categories', 'ConceptController@getConceptCategories');
  Route::get('concept-categories/create', 'ConceptController@getCreateConceptCategory');
  Route::get('concept-categories/edit/{id}', 'ConceptController@getEditConceptCategory');
  Route::get('concept-categories/delete/{id}', 'ConceptController@getDeleteConceptCategory');
  Route::post('concept-categories/create', 'ConceptController@postCreateEditConceptCategory');
  Route::post('concept-categories/edit/{id?}', 'ConceptController@postCreateEditConceptCategory');
  Route::post('concept-categories/delete/{id}', 'ConceptController@postDeleteConceptCategory');
  Route::post('concept-categories/sort', 'ConceptController@postSortConceptCategory');

  Route::get('concepts', 'ConceptController@getConceptIndex');
  Route::get('concepts/create', 'ConceptController@getCreateConcept');
  Route::get('concepts/edit/{id}', 'ConceptController@getEditConcept');
  Route::get('concepts/delete/{id}', 'ConceptController@getDeleteConcept');
  Route::post('concepts/create', 'ConceptController@postCreateEditConcept');
  Route::post('concepts/edit/{id?}', 'ConceptController@postCreateEditConcept');
  Route::post('concepts/delete/{id}', 'ConceptController@postDeleteConcept');
  Route::post('concepts/sort', 'ConceptController@postSortConcept');

  // GLOSSARY
  Route::get('glossary', 'GlossaryController@getGlossaryIndex');
  Route::post('glossary/toggle-setting', 'GlossaryController@postToggleSetting');
  Route::get('glossary/create', 'GlossaryController@getCreateEditTerm');
  Route::get('glossary/edit/{id}', 'GlossaryController@getCreateEditTerm');
  Route::post('glossary/create', 'GlossaryController@postCreateEditTerm');
  Route::post('glossary/edit/{id}', 'GlossaryController@postCreateEditTerm');
  Route::get('glossary/delete/{id}', 'GlossaryController@getDeleteTerm');
  Route::post('glossary/delete/{id}', 'GlossaryController@postDeleteTerm');
});

// DISCORD
Route::group(['prefix' => 'discord', 'middleware' => 'power:manage_discord'], function () {
  // levels
  Route::get('levels', 'DiscordController@getDiscordLevelIndex');
  // rewards
  Route::get('rewards', 'DiscordController@getDiscordRewardIndex');
  Route::get('rewards/create', 'DiscordController@getCreateReward');
  Route::get('rewards/edit/{id}', 'DiscordController@getEditReward');
  Route::post('rewards', 'DiscordController@postCreateReward');
  Route::post('rewards/create', 'DiscordController@postCreateEditReward');
  Route::post('rewards/edit/{id?}', 'DiscordController@postCreateEditReward');
  Route::get('rewards/delete/{id}', 'DiscordController@getDeleteReward');
  Route::post('rewards/delete/{id}', 'DiscordController@postDeleteReward');
});

# MAPS
Route::group(['prefix' => 'maps', 'middleware' => 'power:manage_maps'], function () {
  Route::get('/', 'MapController@getMapIndex');
  Route::get('create', 'MapController@getCreateMap');
  Route::post('create', 'MapController@postCreateEditMap');
  Route::get('edit/{id}', 'MapController@getEditMap');
  Route::post('edit/{id}', 'MapController@postCreateEditMap');
  Route::get('delete/{id}', 'MapController@getDeleteMap');
  Route::post('delete/{id}', 'MapController@postDeleteMap');
  # LOCATIONS
  Route::get('locations/create/{map_id}', 'MapController@getCreateLocation');
  Route::post('locations/create/{map_id}', 'MapController@postCreateEditLocation');
  Route::get('locations/edit/{id}', 'MapController@getEditLocation');
  Route::post('locations/edit/{id}/{map_id}', 'MapController@postCreateEditLocation');
  Route::get('locations/delete/{id}', 'MapController@getDeleteLocation');
  Route::post('locations/delete/{id}', 'MapController@postDeleteLocation');
});

# MAPS
Route::group(['prefix' => 'maps', 'middleware' => 'power:manage_maps'], function () {
  Route::get('/', 'MapController@getMapIndex');
  Route::get('create', 'MapController@getCreateMap');
  Route::post('create', 'MapController@postCreateEditMap');
  Route::get('edit/{id}', 'MapController@getEditMap');
  Route::post('edit/{id}', 'MapController@postCreateEditMap');
  Route::get('delete/{id}', 'MapController@getDeleteMap');
  Route::post('delete/{id}', 'MapController@postDeleteMap');
  # LOCATIONS
  Route::get('locations/create/{map_id}', 'MapController@getCreateLocation');
  Route::post('locations/create/{map_id}', 'MapController@postCreateEditLocation');
  Route::get('locations/edit/{id}', 'MapController@getEditLocation');
  Route::post('locations/edit/{id}/{map_id}', 'MapController@postCreateEditLocation');
  Route::get('locations/delete/{id}', 'MapController@getDeleteLocation');
  Route::post('locations/delete/{id}', 'MapController@postDeleteLocation');
});

// PAIRINGS
Route::group(['prefix' => 'pairings', 'middleware' => 'power:manage_raffles'], function () {
  Route::get('roller', 'PairingController@getRoller');
  Route::post('roller', 'PairingController@postRoll');
});
