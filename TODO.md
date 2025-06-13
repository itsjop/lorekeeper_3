# fuck it
- [x] trait during myo creation
  - final tab on myo submission
  - make item, add myo tag, make sure its 'active' (reorder?), grant it, use it (slot created), click the link, submit, then final tab is 'traits'
- [ ] the BE and db code for the traits page would need changing for allowing multiple subtypes (it does not save correctly right now in the design update and might not transfer to the character upon approval either)

# KNOWN ISSUES
- [x] rarity incorrectly requires an icon
- [x] multiple shop issues -> CYL: fixed as to where creating stock and buying from the shop works
- [x] character creation 'subtypes'/'transformation' select a species first
- [x] profile page still busted
- [x] 'my characters' page not listing characters
- [ ] settings page avatar upload broken -> CYL: it works for me locally?
  - [x] profile pronouns (maybe) not saving
  - [ ] image block settings twice
- [x] 500 editing character profile from sidebar -> CYL: make sure composer update/install ran for the league dependency
- [ ] 404 badge logs not found
- [x] Cultivation/professions/dailies settings not linked properly -> CYL: added to admin sidebar and checked for basic functionality, errors I saw below!
- [ ] wheels on wheel dailies don't show up properly even after adding the necessary js files -> CYL: it seems you did some changes there so you may have to look into that yourself as it works on base lk for me...
- [x] shop stock popup fucked -> CYL: fixed with the multiple shop issues I think
- [ ] need wysywig textboxes
- [ ] titles missing on create myo
- [ ] Featured Character is 'character of the moment'??? on refresh??? wtf
- [x] profile comments
- [ ] remove sex -> CYL: would strongly discourage this as long as pairings is in here because the code depends on it, and it's not worth the effort - since unless you set one, no character will have or show one.
- [ ] featured character only from active participants
- [x] shops still fucked -> CYL: fixed with the multiple shop issues I think
- [ ] appprovals?
- [ ] item category search no results
- [x] shop editing super broken -> CYL: fixed with the multiple shop issues I think
- [ ] wysywig textboxes -> CYL: this is an extension iirc! It's called tinymce or smth
- [ ] admin/raffle create buttons dont work
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

# Re-enable
- [ ] Profile Header Image
- [ ] shop coupons
- [ ] custom titles on character creation

# HIGH PRIORITY
- [ ] Critical CSS Render Path to avoid flickering
    - [ ] look into caching to avoid redraws?
- [ ] request-throttling issues
- [ ] page transition api
- [ ] fucking backdrop-filter breaks positioning

# BONUSES
- [ ] Combine News and Sales to a Newsfeed
- [ ] Get recursive Image Optimization CLI script
- [ ] re-add Recipies to prompt page
- [ ] change sidebar routes to array for better `active` matching

# CSS
- [ ] store current vanilla version of lorekeeper for the "accessible" version

# funsies!
- [ ] pinnable quick links for each menu
- [ ] all common quick links in the corner
- [ ] SOUND EFFECT TOGGLE
- [ ] rpg splitter text

# low-prio
- [ ] no ::backdrop on modals
- [ ] slim down google fonts payload




### FIXED!! ###
