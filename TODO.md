# top prio
- [ ] the new Boostrap 5, the attributes are data-bs-toggle, data-bs-parent, and data-bs-target
- [ ] basic level rarities
- [ ] contains: paint; on the ML top level image
- [ ] figure out how to make dialogs launch at root
- [ ] tiny notification box
- [ ] subtypes (plural) still around
- [x] checkboxes are offset / too tall?
- [ ] "___ somnivore" when you hover over the palate icons
- [ ] Remove MYO Image (resources/views/admin/designs/_approve_request_modal.blade.php)

# Functional Issues (for Cyl) (Sorted by priority)
## MYO
- [ ] Upon activating an MYO-tagged item in your inventory `/inventory`, the following error is thrown:
- production.ERROR: count(): Argument #1 (value) must be of type Countable|array, string given {"userId":1,"exception":"object} (TypeError(code: 0): count(): Argument #1 ($value) must be of type Countable|array, string given [at](/app/Services/CharacterManager.php#107))
## Shops
- [ ] Cannot add stock
- [ ] 'Set Active' and 'FTO Only' toggles does not save successfully
## Character Profile Page
- [ ] `Undefined array key "subtype_id"` toast when attempting to edit a character MYO page
- [ ] Make it so the Bat transformation is always listed first.
    - Changing the order of the list in the transformation settings has no effect
- [ ] Is it possible to enable uploading multiple images at once?
## Low-prio
- [ ] "remove current image" checkbox not functioning on relevant admin pages (such as `/admin/data/rarities/edit/1`)
- [ ] Transformation info and transformation Origin

# Styling Issues (for joz):
- [x] finalize navbar links
- [ ] No 18+ popup banner
- [ ] Modals don't scroll
- [x] Sidebar expand animation broke (firefox)?
- [x] scale rarity icons appropriately
- [ ] imageMagick module not availible with this php installation
- [x] link color purple and change on hover
- [ ] system clock
- [x] minification cli
- [ ] currency counter? [root-level](app/Models/Currency/Currency.php#310)
- [ ] add padding between buttons they all touch rn
- [ ] gotta make the masterlist look nice. we can start on this after i actually upload some characters so you can get a good idea of how it will actually look. https://www.cupidcats.online/masterlist for ref
- [ ] http://127.0.0.1:8000/character/tst-001/profile/edit have any profile content [root-level](resources/views/character/character.blade.php#64)
- [ ] add a [ > menu ] button to expand out the sidebar menu for mobile
- [ ] need to customize and make the homepages nice, both for logged out and logged in.
- [ ] break up name into two elements
- [ ] the masterlist pages will need a whole rehaul. profile in its own box, pulled from the text field that users can enter things in that's hidden away in the sidebar by default. everyone tells me this is a very simple fix. we will also need to make a field that nicely displays pets and inventory in two tabs that you can click between. cupid cats did this too - you can see theirs. ours would be profile, then pets / inventory https://www.cupidcats.online/character/MYO-545 (random chara example)


# Future Issues
- [ ] 404 badge logs not found
- [ ] wheels on the wheel-dailies don't show up properly even after adding the necessary js files
- [x] remove sex selectors
- [ ] featured character only from active participants

# In-progress / Partial Fixes:
- [ ] item category search no results
- [ ] wysywig textboxes
- [x] admin/raffle create buttons dont work
- [x] settings page avatar upload broken
  - [x] profile pronouns (maybe) not saving
  - [x] image block settings twice
- [x] 500 editing character profile from sidebar
- [x] Cultivation/professions/dailies settings not linked properly
- [x] shop editing super broken

# To Re-enable
- [ ] Custom Profile Header Image
- [ ] Shop coupons
- [ ] re-add Recipies to prompt page

# First-round enhancement
- [ ] request-throttling issues
- [ ] page transition api
- [ ] fuckign... backdrop-filter breaks positioning 😮‍💨
- [ ] selected character extension
- [ ] logo mirage animation
- [ ] rarity glow
- [ ] CSS Color mixing for custom color palettes

# Bonuses:
- [ ] move all modal dialogs to [root-level](resources/views/layouts/app.blade.php#L173)
  - [ ] Most dialog issues stem from them being far down the DOM tree and easily getting put into new render layers
  - [ ] this causes position: fixed; to go off of a random parent instead of fixed to the viewport
- [ ] Combine News and Sales to a Newsfeed
- [ ] Get recursive Image Optimization CLI script (tinypng equivalent for the many local assets we'll have)
- [ ] change sidebar routes to array for better `active` matching

# CSS
- [ ] store current vanilla version of lorekeeper for the "accessible" version

# funsies!
- [ ] pinnable quick links for each menu
- [ ] all common quick links in the corner
- [ ] SOUND EFFECT TOGGLE
- [ ] rpg splitter text

# low-prio
- [ ] fix no ::backdrop on modals
- [ ] slim down google fonts payload

# FIXED!!!
- [x] rarity incorrectly requires an icon
- [x] multiple shop issues
    -> CYL: fixed as to where creating stock and buying from the shop works
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
