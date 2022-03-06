<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('admin.apis.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('api-generator::menus.apis.management'), route('admin.apis.index'));
});

Breadcrumbs::register('admin.apis.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.apis.index');
    $breadcrumbs->push(trans('api-generator::menus.apis.create'), route('admin.apis.create'));
});

Breadcrumbs::register('admin.apis.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.apis.index');
    $breadcrumbs->push(trans('api-generator::menus.apis.edit'), route('admin.apis.edit', $id));
});
