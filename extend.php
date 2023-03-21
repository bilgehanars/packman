<?php

/*
 * This file is part of bilgehanars/packman.
 *
 * Copyright (c) 2023 Bilgehan ARSLAN.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

 namespace Bilgehanars\PackMan;

 use Flarum\Extend;

 return [
     
     (new Extend\Frontend('admin'))
         ->js(__DIR__.'/js/dist/admin.js')
         ->css(__DIR__.'/less/admin.less'),
     new Extend\Locales(__DIR__.'/locale'),
 
     (new Extend\Routes('api'))
     ->post('/packman', 'packman', PackManController::class)
 ];
 
 