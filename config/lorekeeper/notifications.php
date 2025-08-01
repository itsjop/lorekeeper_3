<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    |
    | A list of notification type IDs and the messages associated with them.
    |
    */

  // CURRENCY_GRANT
  0   => [
    'name'    => 'Currency Grant',
    'message' => 'You have received a staff grant of {currency_quantity} {currency_name} from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Bank</a>)',
    'url'     => 'bank',
  ],

  // ITEM_GRANT
  1   => [
    'name'    => 'Item Grant',
    'message' => 'You have received a staff grant of {item_name} (×{item_quantity}) from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Inventory</a>)',
    'url'     => 'inventory',
  ],

  // CURRENCY_REMOVAL
  2   => [
    'name'    => 'Currency Removal',
    'message' => '{currency_quantity} {currency_name} was removed from your bank by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Bank</a>)',
    'url'     => 'bank',
  ],

  // ITEM_REMOVAL
  3   => [
    'name'    => 'Item Removal',
    'message' => '{item_name} (×{item_quantity}) was removed from your inventory by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Inventory</a>)',
    'url'     => 'inventory',
  ],

  // CURRENCY_TRANSFER
  4   => [
    'name'    => 'Currency Transfer',
    'message' => 'You have received {currency_quantity} {currency_name} from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Bank</a>)',
    'url'     => 'bank',
  ],

  // ITEM_TRANSFER
  5   => [
    'name'    => 'Item Transfer',
    'message' => 'You have received {item_name} (×{item_quantity}) from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Inventory</a>)',
    'url'     => 'inventory',
  ],

  // FORCED_ITEM_TRANSFER
  6   => [
    'name'    => 'Forced Item Transfer',
    'message' => '{item_name} (×{item_quantity}) was transferred out of your inventory by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Inventory</a>)',
    'url'     => 'inventory',
  ],

  // CHARACTER_UPLOAD
  7   => [
    'name'    => 'Character Upload',
    'message' => 'A new character (<a href="{character_url}">{character_slug}</a>) has been uploaded for you. (<a href="{url}">View Characters</a>)',
    'url'     => 'characters',
  ],

  // CHARACTER_CURRENCY_GRANT
  8   => [
    'name'    => 'Character Currency Grant',
    'message' => '{character_name} has received a staff grant of {currency_quantity} {currency_name} from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Bank</a>)',
    'url'     => 'character/{character_slug}/bank',
  ],

  // CHARACTER_CURRENCY_REMOVAL
  9   => [
    'name'    => 'Character Currency Removal',
    'message' => '{currency_quantity} {currency_name} was removed from {character_name} by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Bank</a>)',
    'url'     => 'character/{character_slug}/bank',
  ],

  // CHARACTER_PROFILE_EDIT
  10  => [
    'name'    => 'Character Profile Edited',
    'message' => '{character_name}\'s profile was edited by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Character</a>)',
    'url'     => 'character/{character_slug}/profile',
  ],

  // IMAGE_UPLOAD
  11  => [
    'name'    => 'Image Upload',
    'message' => 'A new image for {character_name} was uploaded by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Character</a>)',
    'url'     => 'character/{character_slug}/images',
  ],

  // CHARACTER_TRANSFER_RECEIVED
  12  => [
    'name'    => 'Character Transfer Received',
    'message' => 'You have received a transfer for <a href="{character_url}">{character_name}</a> from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Transfers</a>)',
    'url'     => 'characters/transfers/incoming',
  ],

  // CHARACTER_TRANSFER_REJECTED
  13  => [
    'name'    => 'Character Transfer Rejected',
    'message' => 'Your transfer request for <a href="{character_url}">{character_name}</a> was rejected by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Transfers</a>)',
    'url'     => 'characters/transfers/completed',
  ],

  // CHARACTER_TRANSFER_CANCELED
  14  => [
    'name'    => 'Character Transfer Cancelled',
    'message' => 'The transfer for <a href="{character_url}">{character_name}</a> was canceled by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Transfers</a>)',
    'url'     => 'characters/transfers/completed',
  ],

  // CHARACTER_TRANSFER_DENIED
  15  => [
    'name'    => 'Character Transfer Denied',
    'message' => 'Your transfer request for <a href="{character_url}">{character_name}</a> was denied by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Transfers</a>)',
    'url'     => 'characters/transfers/completed',
  ],

  // CHARACTER_TRANSFER_ACCEPTED
  16  => [
    'name'    => 'Character Transfer Accepted',
    'message' => 'Your transfer request for <a href="{character_url}">{character_name}</a> was accepted by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Transfers</a>)',
    'url'     => 'characters/transfers/completed',
  ],

  // CHARACTER_TRANSFER_APPROVED
  17  => [
    'name'    => 'Character Transfer Approved',
    'message' => 'The transfer for <a href="{character_url}">{character_name}</a> was approved by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Transfers</a>)',
    'url'     => 'characters/transfers/completed',
  ],

  // CHARACTER_SENT
  18  => [
    'name'    => 'Character Sent',
    'message' => '{character_name} was transferred to <a href="{recipient_url}">{recipient_name}</a> by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Character</a>)',
    'url'     => '/{character_url}',
  ],

  // CHARACTER_RECEIVED
  19  => [
    'name'    => 'Character Received',
    'message' => '{character_name} was transferred to you by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Character</a>)',
    'url'     => '/{character_url}',
  ],

  // SUBMISSION_APPROVED
  20  => [
    'name'    => 'Submission Approved',
    'message' => 'Your submission (#{submission_id}) was approved by <a href="{staff_url}">{staff_name}</a>. (<a href="{url}">View Submission</a>)',
    'url'     => 'submissions/view/{submission_id}',
  ],

  // SUBMISSION_REJECTED
  21  => [
    'name'    => 'Submission Rejected',
    'message' => 'Your submission (#{submission_id}) was rejected by <a href="{staff_url}">{staff_name}</a>. (<a href="{url}">View Submission</a>)',
    'url'     => 'submissions/view/{submission_id}',
  ],

  // CLAIM_APPROVED
  22  => [
    'name'    => 'Claim Approved',
    'message' => 'Your claim (#{submission_id}) was approved by <a href="{staff_url}">{staff_name}</a>. (<a href="{url}">View Claim</a>)',
    'url'     => 'claims/view/{submission_id}',
  ],

  // CLAIM_REJECTED
  23  => [
    'name'    => 'Claim Rejected',
    'message' => 'Your claim (#{submission_id}) was rejected by <a href="{staff_url}">{staff_name}</a>. (<a href="{url}">View Claim</a>)',
    'url'     => 'claims/view/{submission_id}',
  ],

  // MYO_GRANT
  24  => [
    'name'    => 'MYO Grant',
    'message' => 'A new MYO slot (<a href="{character_url}">{name}</a>) has been created for you. (<a href="{url}">View MYO Slots</a>)',
    'url'     => 'myos',
  ],

  // DESIGN_APPROVED
  25  => [
    'name'    => 'Design Update Approved',
    'message' => 'The <a href="{design_url}">design update</a> for <a href="{character_url}">{name}</a> has been approved. (<a href="{url}">View Design Approvals</a>)',
    'url'     => 'designs/approved',
  ],

  // DESIGN_REJECTED
  26  => [
    'name'    => 'Design Update Requested',
    'message' => 'The <a href="{design_url}">design update</a> for <a href="{character_url}">{name}</a> has been rejected. (<a href="{url}">View Design Approvals</a>)',
    'url'     => 'designs/rejected',
  ],

  // DESIGN_CANCELED
  27  => [
    'name'    => 'Design Update Cancelled',
    'message' => 'The <a href="{design_url}">design update</a> for <a href="{character_url}">{name}</a> has been canceled. (<a href="{url}">View Design Approvals</a>)',
    'url'     => 'designs',
  ],

  // TRADE_RECEIVED
  28  => [
    'name'    => 'Trade Received',
    'message' => 'You have received a new trade from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Trade</a>)',
    'url'     => 'trades/{trade_id}',
  ],

  // TRADE_UPDATE
  29  => [
    'name'    => 'Trade Updated',
    'message' => '<a href="{sender_url}">{sender_name}</a> has updated their half of a trade. (<a href="{url}">View Trade</a>)',
    'url'     => 'trades/{trade_id}',
  ],

  // TRADE_CANCELED
  30  => [
    'name'    => 'Trade Cancelled',
    'message' => '<a href="{sender_url}">{sender_name}</a> has canceled a trade. (<a href="{url}">View Trade</a>)',
    'url'     => 'trades/{trade_id}',
  ],

  // TRADE_COMPLETED
  31  => [
    'name'    => 'Trade Completed',
    'message' => 'A trade has been completed. (<a href="{url}">View Trade</a>)',
    'url'     => 'trades/{trade_id}',
  ],

  // TRADE_REJECTED
  32  => [
    'name'    => 'Trade Rejected',
    'message' => 'A trade has been rejected from the character transfer queue. (<a href="{url}">View Trade</a>)',
    'url'     => 'trades/{trade_id}',
  ],

  // TRADE_CONFIRMED
  33  => [
    'name'    => 'Trade Confirmed',
    'message' => 'A trade has been confirmed and placed in the character transfer queue to be reviewed. (<a href="{url}">View Trade</a>)',
    'url'     => 'trades/{trade_id}',
  ],

  // BOOKMARK_TRADING
  34  => [
    'name'    => 'Bookmark Trading Status',
    'message' => 'A character you have bookmarked (<a href="{character_url}">{character_name}</a>) has had its Open For Trading status changed. (<a href="{url}">View Bookmarks</a>)',
    'url'     => 'account/bookmarks',
  ],

  // BOOKMARK_GIFTS
  35  => [
    'name'    => 'Bookmark Gift Art Status',
    'message' => 'A character you have bookmarked (<a href="{character_url}">{character_name}</a>) has had its Gift Art Allowed status changed. (<a href="{url}">View Bookmarks</a>)',
    'url'     => 'account/bookmarks',
  ],

  // BOOKMARK_OWNER
  36  => [
    'name'    => 'Bookmark Owner',
    'message' => 'A character you have bookmarked (<a href="{character_url}">{character_name}</a>) has been transferred to a different owner. (<a href="{url}">View Bookmarks</a>)',
    'url'     => 'account/bookmarks',
  ],

  // BOOKMARK_IMAGE
  37  => [
    'name'    => 'Bookmark Image',
    'message' => 'A new image has been uploaded for a character you have bookmarked (<a href="{character_url}">{character_name}</a>). (<a href="{url}">View Bookmarks</a>)',
    'url'     => 'account/bookmarks',
  ],

  // Technically this was acceptable before this point
  // CHARACTER_TRANSFER_ACCEPTABLE
  38  => [
    'name'    => 'Character Transfer Acceptable',
    'message' => 'The transfer for <a href="{character_url}">{character_name}</a> was approved by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Transfers</a>)',
    'url'     => 'characters/transfers/incoming',
  ],

  // BOOKMARK_GIFT_WRITING
  39  => [
    'message' => 'A character you have bookmarked (<a href="{character_url}">{character_name}</a>) has had its Gift Writing Allowed status changed. (<a href="{url}">View Bookmarks</a>)',
    'url'     => 'account/bookmarks',
  ],

  // USER_REACTIVATED
  103 => [
    'name'      => 'User Reactivated',
    'message'   => '<a href="{user_url}">{user_name}\'s</a> account has been reactivated by <a href="{staff_url}">{staff_name}</a>.',
    'url'       => '',
  ],

  // USER_DEACTIVATED
  104 => [
    'name'      => 'User Deactivated',
    'message'   => '<a href="{user_url}">{user_name}\'s</a> account has been deactivated by <a href="{staff_url}">{staff_name}</a>.',
    'url'       => '',
  ],

  // SUBMISSION_CANCELLED
  108 => [
    'name'    => 'Submission Cancelled',
    'message' => 'Your submission (#{submission_id}) was cancelled and sent back to drafts by <a href="{staff_url}">{staff_name}</a>. (<a href="{url}">View Submission</a>)',
    'url'     => 'submissions/view/{submission_id}',
  ],

  // CLAIM_CANCELLED
  109 => [
    'name'    => 'Claim Cancelled',
    'message' => 'Your claim (#{submission_id}) was cancelled and sent back to drafts by <a href="{staff_url}">{staff_name}</a>. (<a href="{url}">View Claim</a>)',
    'url'     => 'claims/view/{submission_id}',
  ],

  // REPORT_ASSIGNED
  220 => [
    'name'    => 'Report Assigned',
    'message' => 'Your report (#{report_id}) was assigned to <a href="{staff_url}">{staff_name}</a>, you can expect a response soon. (<a href="{url}">View Report</a>)',
    'url'     => 'reports/view/{report_id}',
  ],

  // LINK_REQUESTED
  200 => [
    'name'    => 'Link Requested',
    'message' => '<a href="{link}">{user}</a> has requested to link your character {requested} to {character}.'
      . '<div class="btn btn-sm btn-success m-1 accept-link" data-link-id="{id}">Accept</div>'
      . '<div class="btn btn-sm btn-danger m-1 reject-link" data-link-id="{id}">Reject</div>',
    'url'  => '',
    'view' => 'links',
  ],

  // LINK_ACCEPTED
  201 => [
    'name'    => 'Link Accepted',
    'message' => '<a href="{link}">{user}</a> has accepted your link request to {requested}. (<a href="{character}/links">View Character Links.</a>)',
    'url'     => '',
  ],

  // REPORT_ASSIGNED
  220 => [
    'name'    => 'Report Assigned',
    'message' => 'Your report (#{report_id}) was assigned to <a href="{staff_url}">{staff_name}</a>, you can expect a response soon. (<a href="{url}">View Report</a>)',
    'url'     => 'reports/view/{report_id}',
  ],

  // REPORT_CLOSED
  221 => [
    'name'    => 'Report Closed',
    'message' => 'Your report (#{report_id}) was closed by <a href="{staff_url}">{staff_name}</a>. (<a href="{url}">View Report</a>)',
    'url'     => 'reports/view/{report_id}',
  ],

  // Comment made on user's model
  // COMMENT_MADE
  239 => [
    'name'    => 'Comment Made',
    'message' => '<a href="{sender_url}">{sender}</a> has made a comment on {post_type}. <a href="{comment_url}">See Context.</a>',
    'url'     => '',
  ],
  // Comment recieved reply
  // COMMENT_REPLY
  240 => [
    'name'    => 'Comment Reply',
    'message' => '<a href="{sender_url}">{sender}</a> has made a reply to your comment. <a href="comment/{comment_url}">See Reply.</a>',
    'url'     => '',
  ],
  // PET_REMOVAL
  241 => [
    'name'    => 'Pet Removal',
    'message' => '{pet_name} (×{pet_quantity}) was removed from your inventory by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Pets</a>)',
    'url'     => 'pets',
  ],
  // PET_TRANSFER
  242 => [
    'name'    => 'Pet Transfer',
    'message' => 'You have received {pet_name} (×{pet_quantity}) from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Pets</a>)',
    'url'     => 'pets',
  ],
  // FORCED_PET_TRANSFER
  243 => [
    'name'    => 'Forced Pet Transfer',
    'message' => '{pet_name} (×{pet_quantity}) was transferred out of your inventory by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Pets</a>)',
    'url'     => 'pets',
  ],
  // PET_GRANT
  244 => [
    'name'    => 'Pet Grant',
    'message' => 'You have received a staff grant of {pet_name} (×{pet_quantity}) from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Pets</a>)',
    'url'     => 'pets',
  ],
  // CHARACTER_ITEM_GRANT
  501 => [
    'name'    => 'Character Item Grant',
    'message' => '{character_name} has received a staff grant of {item_name} (×{item_quantity}) from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Inventory</a>)',
    'url'     => 'character/{character_slug}/inventory',
  ],

  // CHARACTER_ITEM_REMOVAL
  502 => [
    'name'    => 'Character Item Removal',
    'message' => '{item_name} (×{item_quantity}) was removed from {character_name} by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Inventory</a>)',
    'url'     => 'character/{character_slug}/inventory',
  ],

  // GALLERY_SUBMISSION_COLLABORATOR
  505 => [
    'name'    => 'Gallery Submission Collaborator',
    'message' => '<a href="{sender_url}">{sender}</a> has added you as a collaborator on a gallery submission, which needs your approval. (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/view/{submission_id}',
  ],

  // GALLERY_COLLABORATORS_APPROVED
  506 => [
    'name'    => 'Gallery Submission Collaborators Approved',
    'message' => 'All of the collaborators on your submission <strong>{submission_title}</strong> (#{submission_id}) have approved it, and it is now pending staff review. (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/view/{submission_id}',
  ],

  // GALLERY_SUBMISSION_ACCEPTED
  507 => [
    'name'    => 'Gallery Submission Accepted',
    'message' => 'Your submission <strong>{submission_title}</strong> (#{submission_id}) was accepted. (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/queue/{submission_id}',
  ],

  // GALLERY_SUBMISSION_REJECTED
  508 => [
    'name'    => 'Gallery Submission Rejected',
    'message' => 'Your submission <strong>{submission_title}</strong> (#{submission_id}) was rejected. (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/queue/{submission_id}',
  ],

  // GALLERY_SUBMISSION_VALUED
  509 => [
    'name'    => 'Gallery Submission Valued',
    'message' => 'You have been awarded {currency_quantity} {currency_name} for the gallery submission <strong>{submission_title}</strong> (#{submission_id}). (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/queue/{submission_id}',
  ],

  // GALLERY_SUBMISSION_MOVED
  510 => [
    'name'    => 'Gallery Submission Moved',
    'message' => 'Your gallery submission <strong>{submission_title}</strong> (#{submission_id}) has been moved by <a href="{staff_url}">{staff_name}</a>. (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/view/{submission_id}',
  ],

  // GALLERY_SUBMISSION_CHARACTER
  511 => [
    'name'    => 'Gallery Submission Character',
    'message' => '<a href="{sender_url}">{sender}</a> has added your character <a href="{character_url}">{character}</a> to a gallery submission. (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/view/{submission_id}',
  ],

  // GALLERY_SUBMISSION_FAVORITE
  512 => [
    'name'    => 'Gallery Submission Favorite',
    'message' => '<a href="{sender_url}">{sender}</a> has added your gallery submission <strong>{submission_title}</strong> (#{submission_id}) to their favorites. (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/view/{submission_id}',
  ],

  // GALLERY_SUBMISSION_STAFF_COMMENTS
  513 => [
    'name'    => 'Gallery Submission Staff Comments',
    'message' => '<a href="{sender_url}">{sender}</a> updated the staff comments on your gallery submission <strong>{submission_title}</strong> (#{submission_id}). (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/queue/{submission_id}',
  ],

  // GALLERY_SUBMISSION_EDITED
  514 => [
    'name'    => 'Gallery Submission Edited',
    'message' => 'Your gallery submission <strong>{submission_title}</strong> (#{submission_id}) has been edited by <a href="{staff_url}">{staff_name}</a>. (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/view/{submission_id}',
  ],

  // GALLERY_SUBMISSION_PARTICIPANT
  515 => [
    'name'    => 'Gallery Submission Participant',
    'message' => '<a href="{sender_url}">{sender}</a> has added you as a participant on a gallery submission. (<a href="{url}">View Submission</a>)',
    'url'     => 'gallery/view/{submission_id}',
  ],

  // GIFT_SUBMISSION_RECEIVED
  1002 => [
    'name' => 'Gift Submission Received',
    'message' => 'Your character (<a href="{character_url}">{character}</a>) has been included in a submission by <a href="{sender_url}">{sender}</a>. (<a href="{url}">View Submission</a>)',
    'url' => 'submissions/view/{submission_id}'
  ],

  // GIFT_CLAIM_RECEIVED
  1003 => [
    'name' => 'Gift Claim Received',
    'message' => 'Your character (<a href="{character_url}">{character}</a>) has been included in a claim by <a href="{sender_url}">{sender}</a>. (<a href="{url}">View Claim</a>)',
    'url' => 'claims/view/{submission_id}'
  ],

  // GIFT_SUBMISSION_ALERT
  1004 => [
    'name' => 'Gift Submission Alert',
    'message' => 'Your character (<a href="{character_url}">{character_name}</a>) has {count} submissions by other users. (<a href="{url}">View {character_name}’s Submissions</a>)',
    'url' => '{character_url}/submissions'
  ],


  // BORDER_GRANT
  1106 => [
    'name' => 'Border Grant',
    'message' => 'You have received a staff grant of the user border {border_name} from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Borders</a>)',
    'url' => 'user/{recipient_name}/borders'
  ],

  // USER_SHOP_ITEM_SOLD
  1104 => [
    'name' => 'Shop Item Sold',
    'message' => 'You have sold a {item_name} from <a href="{url}">{shop_name}</a> and have been credited {currency_quantity} {currency_name}.',
    'url' => 'user-shops/shop/{shop_id}'
  ],

  /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    |
    | A list of notification type IDs and the messages associated with them.
    |
    */
  // AWARD_GRANT
  341 => [
    'name' => 'Award Grant',
    'message' => 'You have earned the following award(s): {award_name} (×{award_quantity}). Congratulations! (<a href="{url}">View Awards</a>)',
    'url' => 'awardcase'
  ],

  // AWARD_REMOVAL
  342 => [
    'name' => 'Award Removal',
    'message' => '{award_name} (×{award_quantity}) was removed from your Awards by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Awards</a>)',
    'url' => 'awardcase'
  ],

  // AWARD_TRANSFER
  343 => [
    'name' => 'Award Transfer',
    'message' => 'You have received {award_name} (×{award_quantity}) from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Awards</a>)',
    'url' => 'awardcase'
  ],

  // FORCED_AWARD_TRANSFER
  344 => [
    'name' => 'Forced Award Transfer',
    'message' => '{item_name} (×{item_quantity}) was removed from {character_name} by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Inventory</a>)',
    'url' => 'character/{character_slug}/inventory'
  ],

  // CHARACTER_AWARD_GRANT
  345 => [
    'name' => 'Character Award Grant',
    'message' => '{character_name} has received a staff grant of {award_name} (×{award_quantity}) from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Awards</a>)',
    'url' => 'character/{character_slug}/awards'
  ],

  // CHARACTER_AWARD_REMOVAL
  346 => [
    'name' => 'Character Award Removal',
    'message' => '{award_name} (×{award_quantity}) was removed from {character_name} by <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Awards</a>)',
    'url' => 'character/{character_slug}/awards'
  ],


  // RECIPE_GRANT
  600 => [
    'name'    => 'Recipe Grant',
    'message' => 'You have received a staff grant of the crafting recipe {recipe_name} from <a href="{sender_url}">{sender_name}</a>. (<a href="{url}">View Unlocked Recipes</a>)',
    'url'     => 'crafting',
  ],

  // PAIRING_APPROVED
  1300 => [
    'name'    => 'Pairing Approved',
    'message' => 'Your pairing of <a href="{character_1_url}">{character_1_slug}</a> and <a href="{character_2_url}">{character_2_slug}</a> has been approved! (<a href="{url}">View Pairings</a>)',
    'url'     => '/characters/pairings?type=pending',
  ],

  // PAIRING_REJECTED
  1301 => [
    'name'    => 'Pairing Rejected',
    'message' => 'Your pairing of <a href="{character_1_url}">{character_1_slug}</a> and <a href="{character_2_url}">{character_2_slug}</a> has been rejected. (<a href="{url}">View Pairings</a>)',
    'url'     => '/characters/pairings?type=closed',
  ],

  // PAIRING_NEW_APPROVAL
  1302 => [
    'name'    => 'Pairing Approval Request',
    'message' => 'A new pairing of <a href="{character_1_url}">{character_1_slug}</a> and <a href="{character_2_url}">{character_2_slug}</a> is awaiting your approval! (<a href="{url}">View Pairings</a>)',
    'url'     => '/characters/pairings?type=approval',
  ],

  // PAIRING_CANCELLED
  1303 => [
    'name'    => 'Pairings Cancelled',
    'message' => 'The pairing of <a href="{character_1_url}">{character_1_slug}</a> and <a href="{character_2_url}">{character_2_slug}</a> has been cancelled.',
    'url'     => '',
  ],

];
