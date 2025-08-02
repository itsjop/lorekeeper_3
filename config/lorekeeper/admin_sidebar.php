<?php

return [

  /*
|--------------------------------------------------------------------------
| Admin Sidebar Links
|--------------------------------------------------------------------------
|
| Admin panel sidebar links.
| Add links here to have them show up in the admin panel.
| Users that do not have the listed power will not be able to
| view the links in that section.
|
*/

  'Data' => [
    'power' => 'edit_data',
    'meta' => 'tworow nonlinear',
    'links' => [
      ['name' => 'Galleries', 'url' => 'admin/data/galleries',],
      ['name' => 'Character Categories', 'url' => 'admin/data/character-categories',],
      ['name' => 'Sub Masterlists', 'url' => 'admin/data/sublists',],
      ['name' => 'Rarities', 'url' => 'admin/data/rarities',],
      ['name' => 'Species', 'url' => 'admin/data/species',],
      ['name' => 'Subtypes', 'url' => 'admin/data/subtypes',],
      ['name' => 'Traits', 'url' => 'admin/data/traits',],
      ['name' => 'Shops', 'url' => 'admin/data/shops',],
      ['name' => 'Currencies', 'url' => 'admin/data/currencies',],
      ['name' => 'Prompts', 'url' => 'admin/data/prompts',],
      ['name' => 'Loot Tables', 'url' => 'admin/data/loot-tables',],
      ['name' => 'Items', 'url' => 'admin/data/items',],
      ['name' => 'Pets', 'url' => 'admin/data/pets',],
      ['name' => 'Dynamic Limits', 'url' => 'admin/data/limits',],
      ['name' => 'Badges', 'url' => 'admin/data/awards'],
      ['name' => 'Criteria Rewards', 'url' => 'admin/data/criteria'],
      ['name' => 'Recipes', 'url' => 'admin/data/recipes',],
      ['name' => 'Transformations', 'url'  => 'admin/data/transformations',],
      ['name' => 'Character Titles', 'url'  => 'admin/data/character-titles',],
      ['name' => 'Professions', 'url' => 'admin/data/professions',],
      ['name' => 'Dailies', 'url' => 'admin/data/dailies',],
      ['name' => 'Pairing Roller', 'url'  => 'admin/pairings/roller',],
      ['name' => 'Encounters', 'url' => 'admin/data/encounters',],
      ['name' => 'Encounter Areas', 'url' => 'admin/data/encounters/areas',],
    ],
  ],
  'Cultivation' => [
    'power' => 'edit_data',
    'links' => [
      ['name' => 'Areas', 'url' => 'admin/cultivation/areas',],
      ['name' => 'Plots', 'url' => 'admin/cultivation/plots',],
    ]
  ],
  'Admin' => [
    'power' => 'mixed',
    'links' => [
      ['name' => 'User Ranks', 'url' => 'admin/users/ranks', 'power' => 'admin',],
      ['name' => 'Admin Logs', 'url' => 'admin/admin-logs', 'power' => 'admin',],
      ['name' => 'Staff Reward Settings', 'url' => 'admin/staff-reward-settings', 'power' => 'admin',],
      ['name' => 'Report Queue', 'url' => 'admin/reports/pending', 'power' => 'manage_reports',],
    ],
  ],
  'Pages' => [
    'power' => 'mixed',
    'links' => [
      ['power' => 'manage_news', 'name' => 'News', 'url' => 'admin/news',],
      ['power' => 'manage_sales', 'name' => 'Sales', 'url' => 'admin/sales',],
      ['power' => 'edit_pages', 'name' => 'Edit Pages', 'url' => 'admin/pages',],
    ],
  ],

  'Users' => [
    'power' => 'edit_user_info',
    'links' => [
      ['name' => 'User Index', 'url' => 'admin/users',],
      ['name' => 'Invitation Keys', 'url' => 'admin/invitations',],
      ['name' => 'Mod Mail', 'url'  => 'admin/mail',],
    ],
  ],
  'Queues' => [
    'power' => 'manage_submissions',
    'links' => [
      ['name' => 'Gallery Submissions', 'url' => 'admin/gallery/submissions',],
      ['name' => 'Gallery Currency Awards', 'url' => 'admin/gallery/currency',],
      ['name' => 'Prompt Submissions', 'url' => 'admin/submissions',],
      ['name' => 'Claim Submissions', 'url' => 'admin/claims',],
    ],
  ],
  'Grants' => [
    'power' => 'edit_inventories',
    'links' => [
      ['name' => 'Currency Grants', 'url' => 'admin/grants/user-currency'],
      ['name' => 'Item Grants', 'url' => 'admin/grants/items'],
      ['name' => 'Pet Grants', 'url' => 'admin/grants/pets',],
      ['name' => 'Award Grants', 'url' => 'admin/grants/awards'],
      ['name' => 'Recipe Grants', 'url' => 'admin/grants/recipes'],
      ['name' => 'Codes', 'url' => 'admin/prizecodes'],
    ]
  ],
  'Characters' => [
    'power' => 'manage_characters',
    'links' => [
      ['name' => 'Create Character', 'url' => 'admin/masterlist/create-character'],
      ['name' => 'Create MYO Slot', 'url' => 'admin/masterlist/create-myo'],
      ['name' => 'Character Transfers', 'url' => 'admin/masterlist/transfers/incoming'],
      ['name' => 'Character Trades', 'url' => 'admin/masterlist/trades/incoming'],
      ['name' => 'Design Updates', 'url' => 'admin/design-approvals/pending'],
      ['name' => 'MYO Approvals', 'url' => 'admin/myo-approvals/pending'],
    ]
  ],
  'Raffles' => [
    'power' => 'manage_raffles',
    'links' => [
      ['name' => 'Raffles', 'url' => 'admin/raffles'],
    ]
  ],
  'World' => [
    'power' => 'manage_world',
    'links' => [
      ['name' => 'Locations', 'url' => 'admin/world/locations'],
      ['name' => 'Faunas', 'url' => 'admin/world/faunas'],
      ['name' => 'Floras', 'url' => 'admin/world/floras'],
      ['name' => 'Events', 'url' => 'admin/world/events'],
      ['name' => 'Figures', 'url' => 'admin/world/figures'],
      ['name' => 'Factions', 'url' => 'admin/world/factions'],
      ['name' => 'Concepts', 'url' => 'admin/world/concepts'],
      ['name' => 'Glossary', 'url' => 'admin/world/glossary'],
    ]
  ],
  'Site Settings' => [
    'power' => 'edit_site_settings',
    'links' => [
      ['name' => 'Site Settings', 'url' => 'admin/settings',],
      ['name' => 'Site Images', 'url' => 'admin/images',],
      ['name' => 'File Manager', 'url' => 'admin/files',],
      ['name' => 'Log Viewer', 'url' => 'admin/logs',],
    ],
  ],
];
