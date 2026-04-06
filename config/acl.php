<?php

return [
    'modules' => array_values(array_filter(array_map('trim', explode(',', env('ACL_MODULES', 'users,companies'))))),
    'actions' => array_values(array_filter(array_map('trim', explode(',', env('ACL_ACTIONS', 'view,create,edit,delete'))))),
];
