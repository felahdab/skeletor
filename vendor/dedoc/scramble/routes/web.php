<?php

use Dedoc\Scramble\Scramble;

Scramble::registerUiRoute(path: 'ffast/scramble/api')->name('scramble.docs.ui');

Scramble::registerJsonSpecificationRoute(path: 'docs/api.json')->name('scramble.docs.document');
