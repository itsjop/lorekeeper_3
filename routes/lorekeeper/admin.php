<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Routes for users with powers.
|
*/

Route::get('/', 'HomeController@getIndex');

Route::get('logs', 'HomeController@getLogs');
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
    Route::get('currencies', 'CurrencyController@getIndex');
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

    // Activities
    Route::get('activities', 'ActivityController@getIndex');
    Route::get('activities/create', 'ActivityController@getCreateActivity');
    Route::get('activities/edit/{id}', 'ActivityController@getEditActivity');
    Route::get('activities/delete/{id}', 'ActivityController@getDeleteActivity');
    Route::post('activities/create', 'ActivityController@postCreateEditActivity');
    Route::post('activities/edit/{id?}', 'ActivityController@postCreateEditActivity');
    Route::post('activities/module/{id}', 'ActivityController@postEditModule');
    Route::post('activities/delete/{id}', 'ActivityController@postDeleteActivity');
    Route::post('activities/sort', 'ActivityController@postSortActivity');

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
});

// PAGES
Route::group(['prefix' => 'pages', 'middleware' => 'power:edit_pages'], function () {
    Route::get('/', 'PageController@getIndex');
    Route::get('create', 'PageController@getCreatePage');
    Route::get('edit/{id}', 'PageController@getEditPage');
    Route::get('delete/{id}', 'PageController@getDeletePage');
    Route::post('create', 'PageController@postCreateEditPage');
    Route::post('edit/{id?}', 'PageController@postCreateEditPage');
    Route::post('delete/{id}', 'PageController@postDeletePage');
});

// NEWS
Route::group(['prefix' => 'news', 'middleware' => 'power:manage_news'], function () {
    Route::get('/', 'NewsController@getIndex');
    Route::get('create', 'NewsController@getCreateNews');
    Route::get('edit/{id}', 'NewsController@getEditNews');
    Route::get('delete/{id}', 'NewsController@getDeleteNews');
    Route::post('create', 'NewsController@postCreateEditNews');
    Route::post('edit/{id?}', 'NewsController@postCreateEditNews');
    Route::post('delete/{id}', 'NewsController@postDeleteNews');
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

    Route::get('items', 'GrantController@getItems');
    Route::post('items', 'GrantController@postItems');

    Route::get('item-search', 'GrantController@getItemSearch');

    Route::get('borders', 'GrantController@getBorders');
    Route::post('borders', 'GrantController@postBorders');
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
    Route::get('check-transformation', 'CharacterController@getCreateCharacterMyoTransformation');
});
Route::group(['prefix' => 'character', 'namespace' => 'Characters', 'middleware' => 'power:edit_inventories'], function () {
    Route::post('{slug}/grant', 'GrantController@postCharacterCurrency');
    Route::post('{slug}/grant-items', 'GrantController@postCharacterItems');
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

// SUBMISSIONS
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

// WORLD EXPANSION
Route::group(['prefix' => 'world',  'namespace' => 'World', 'middleware' => 'power:manage_world'], function () {
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
