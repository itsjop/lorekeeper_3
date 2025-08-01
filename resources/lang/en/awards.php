<?php

return [

    /*
    / --------------------------------------------------------------------------
    / Awards Extension Language Lines
    / --------------------------------------------------------------------------
    /
    / Note that if you adjust anything in here, you WILL NEED to adjust them
    / manually in any config file, specifically config/lorekeeper/notifications.
    / You can optionally also modify them in config/lorekeeper/admin_sidebar but
    / as that is admin-facing only, that isn't as important.
    /
    / If your text has more than one word (like "award case" for instance),
    / it *may* cause issues in loading pages.
    /
    */

    'award' => 'badge',                         // use __
    'awards' => 'badges',                       // use __
    'awards_' => 'award|awards',                // Use trans_choice instead of __

    'awardcase' => 'badge-collection',                 // use __
    'awardcases' => 'badge-collections',               // use __
    'awardcases_' => 'awardcase|awardcases',    // Use trans_choice instead of __

];
