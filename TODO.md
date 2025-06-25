# Known Issues:
- [ ] finalize navbar links
- [ ] No 18+ popup banner
- [ ] Modals don't scroll
- [ ] Sidebar expand animation broke (firefox)?

# Potential Issues
- [ ] character profile
- [ ] 404 badge logs not found
- [ ] wheels on the wheel-dailies don't show up properly even after adding the necessary js files
    -> CYL: it seems you did some changes there so you may have to look into that yourself as it works on base lk for me..
- [ ] remove sex selectors
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
- [ ] custom titles on character creation
- [ ] re-add Recipies to prompt page

# First-round enhancement
- [ ] request-throttling issues
- [ ] page transition api
- [ ] fuckign... backdrop-filter breaks positioning 😮‍💨

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
