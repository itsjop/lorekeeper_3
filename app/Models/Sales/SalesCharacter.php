<?php

namespace App\Models\Sales;

use App\Models\Character\Character;
use App\Models\Character\CharacterImage;
use App\Models\Model;
use Config;

class SalesCharacter extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sales_id', 'character_id', 'image_id', 'description', 'type', 'data', 'link', 'is_open',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_characters';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'type'          => 'required',
        'link'          => 'nullable|url',

        // Flatsale
        'price'         => 'required_if:sale_type,flat',

        // Auction/XTA
        'starting_bid'  => 'required_if:type,auction',
        'min_increment' => 'required_if:type,auction',
        'end_point'     => 'exclude_unless:type,auction,xta,ota|max:255',
    ];

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the sale this is attached to.
     */
    public function sales() {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    /**
     * Get the character being attached to the sale.
     */
    public function character() {
        return $this->belongsTo(Character::class, 'character_id')->withTrashed();
    }

    /**
     * Get the image being attached to the sale.
     */
    public function image() {
        return $this->belongsTo('App\Models\Character\CharacterImage', 'image_id');
    }

    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/

    /**
     * Get the data attribute as an associative array.
     *
     * @return string
     */
    public function getDisplayTypeAttribute() {
        switch ($this->attributes['type']) {
            case 'flatsale': return 'Flatsale';
            case 'auction': return 'Auction';
            case 'ota': return 'OTA';
            case 'xta': return 'XTA';
            case 'flaffle': return 'Flatsale Raffle';
            case 'raffle': return 'Raffle';
            case 'pwyw': return 'PWYW';
        }
    }

    /**
     * Get the data attribute as an associative array.
     *
     * @return string
     */
    public function getTypeLinkAttribute() {
        switch ($this->attributes['type']) {
            case 'flatsale': return 'Claim Here';
            case 'auction': return 'Bid Here';
            case 'ota': return 'Offer Here';
            case 'xta': return 'Enter Here';
            case 'flaffle': return 'Enter Here';
            case 'raffle': return 'Enter Here';
            case 'pwyw': return 'Claim Here';
        }
    }

    /**
     * Get formatted pricing information.
     *
     * @return string
     */
    public function getPriceAttribute() {
        if ($this->type == 'raffle') {
            return null;
        }
        $symbol = config('lorekeeper.settings.currency_symbol');

        switch ($this->type) {
            case 'flatsale':
                return 'Price: '.$symbol.$this->data['price'];;
            case 'auction':
                return 'Starting Bid: '.$symbol.$this->data['starting_bid'].'<br/>'.
                'Minimum Increment: '.$symbol.$this->data['min_increment'].
                (isset($this->data['autobuy']) ? '<br/>Autobuy: '.$symbol.$this->data['autobuy'] : '');;
            case 'ota':
                return (isset($this->data['autobuy']) ? 'Autobuy: '.$symbol.$this->data['autobuy'].'<br/>' : '').
                (isset($this->data['minimum']) ? 'Minimum: '.$symbol.$this->data['minimum'].'<br/>' : '');;
            case 'xta':
                return (isset($this->data['autobuy']) ? 'Autobuy: '.$symbol.$this->data['autobuy'].'<br/>' : '').
                (isset($this->data['minimum']) ? 'Minimum: '.$symbol.$this->data['minimum'].'<br/>' : '');;
            case 'flaffle':
                return 'Price: '.$symbol.$this->data['price'];;
            case 'pwyw':
                return isset($this->data['minimum']) ? 'Minimum: '.$symbol.$this->data['minimum'].'<br/>' : '';;
        }
    }

    /**
     * Get the first image for the associated character.
     *
     * @return App\Models\Character\CharacterImage
     */
    public function getImageAttribute() {
        // Have to call the relationship function or it doesn't grab it correctly
        // likely because of the function name override
        return $this->image()->first() ?? CharacterImage::where('is_visible', 1)->where('character_id', $this->character_id)->orderBy('created_at')->first();
    }
}
