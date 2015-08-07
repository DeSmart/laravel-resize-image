<?php

return [
    'driver' => 'DeSmart\ResizeImage\Driver\LazyResizeDriver',
    'upload_url' => config('app.url').'/upload/resize'
];
