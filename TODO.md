# Styling Issues:
- [~] masterlist redo
- [ ] No 18+ popup banner
- [ ] system clock
- [ ] currency counter? [root-level](app/Models/Currency/Currency.php#310)
- [ ] add a [ > menu ] button to expand out the sidebar menu for mobile
- [ ] Bat transformation should always be listed first
- [ ] native `<details name="">` exclusive toggle for tabs

# Future Issues
- [~] finish bootstrap 5 upgrade (data-bs-toggle, data-bs-parent, and data-bs-target)
- [ ] wheels on the wheel-dailies don't show up properly even after adding the necessary js files
- [ ] featured character should only pull from active participants

# To Re-enable
- [ ] Custom Profile Header Image
- [ ] imageMagick module
- [ ] re-add Recipies to prompt page
- [ ] Shop coupons

# First-round enhancement
- [ ] localstorage site settings
- [ ] request-throttling issues
- [ ] page transition api
- [ ] CSS Color mixing for custom color palettes
- [ ] subgrid alignment for complicated items

# Bonuses:
- [ ] move all modal dialogs to [root-level](resources/views/layouts/app.blade.php#L173)
- [ ] Combine News and Sales to a Newsfeed
- [ ] Get a recursive Image Optimization CLI script
      - (tinypng equivalent for the many local assets we'll have)
- [?] change sidebar routes to array for better `active` matching

# low-prio
- [ ] fix no ::backdrop on modals
- [ ] slim down google fonts payload
- [?] rarity glow
-
# funsies!
- [ ] pinnable quick links for each menu
- [ ] all common quick links in the corner
- [ ] SOUND EFFECT TOGGLE
- [ ] rpg splitter text


# FIXED!!!
- [x] remove sex selectors
- [x] fuckign... backdrop-filter breaks positioning 😮‍💨
- [x] finalize navbar links
- [x] item category search no results
- [x] wysywig textboxes
- [x] admin/raffle create buttons dont work
- [x] settings page avatar upload broken
- [x] profile pronouns (maybe) not saving
- [x] image block settings twice
- [x] 500 editing character profile from sidebar
- [x] Cultivation/professions/dailies settings not linked properly
- [x] shop editing super broken
- [x] Modals don't scroll
- [x] selected character extension
- [x] logo mirage animation
- [x] Upon activating an MYO-tagged item in your inventory `/inventory`, the following error is thrown:
      - production.ERROR: count(): Argument #1 (value) must be of type Countable|array, string given {"userId":1,"exception":"object} (TypeError(code: 0): count(): Argument #1 ($value) must be of type Countable|array, string given [at](/app/Services/CharacterManager.php#107))
- [x] "remove current image" checkbox not functioning on relevant admin pages (such as `/admin/data/rarities/edit/1`)
- [x] Transformation info and transformation Origin
- [x] Sidebar expand animation broke (firefox)?
- [x] scale rarity icons appropriately
- [x] link color purple and change on hover
- [x] minification cli
- [x] add padding between buttons they all touch rn
- [x] http://127.0.0.1:8000/character/tst-001/profile/edit have any profile content [root-level](resources/views/character/character.blade.php#64)
- [x] need to customize and make the homepages nice, both for logged out and logged in.
- [x] break up name into two elements
- [x] basic level rarities
- [x] `Undefined array key "subtype_id"` toast when attempting to edit a character MYO page
- [x] contains: paint; on the ML top level image
- [~] figure out how to make dialogs launch at root
- [x] tiny notification box
- [x] subtypes (plural) still around
- [x] checkboxes are offset / too tall?
- [x] "___ somnivore" when you hover over the palate icons
- [x] Remove MYO Image (resources/views/admin/designs/_approve_request_modal.blade.php)
- [x] rarity incorrectly requires an icon
- [x] multiple shop issues -> CYL: fixed as to where creating stock and buying from the shop works
- [x] character creation 'subtypes'/'transformation' select a species first
- [x] profile page still busted
- [x] 'my characters' page not listing characters
- [x] profile comments
- [x] inventory MYO item broken, no idea how it submits???
- [x] ironically logs page is broken
- [x] toggles arent toggling
- [x] delete item doesnt work
- [x] pets
- [x] Item Preview Error
- [x] background image fixed
- [x] merge in awards extension
- [x] server profile picture 500
- [x] 'shops' are dispalying twice and unclickable
- [x] somnivores logo misalignment
- [~] broken pages:
    - [x] /characters 500 error
    - [x] /inventory 500 error
    - [x] /designs 500 error
- [~] Mailersend Error Fix
- [~] mobile css
- [x] Critical CSS Render Path to avoid flickering
    - [x] look into caching to avoid redraws?
- [ ] - [x] Cannot add shop stock
- [x] 'Set Active' and 'FTO Only' toggles does not save successfully
