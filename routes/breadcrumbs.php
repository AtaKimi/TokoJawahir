<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Transaction Index
Breadcrumbs::for('admin.transaction.index', function (BreadcrumbTrail $trail) {
    $trail->push('Transaksi', route('admin.transaction.index'));
});

// Transaction Index > Transaction User
Breadcrumbs::for('admin.transaction.users', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.transaction.index');
    $trail->push('Pengguna', route('admin.transaction.users'));
});

// Transaction Index > Transaction User > Create
Breadcrumbs::for('admin.transaction.create', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.transaction.users');
    $trail->push('Keranjang', route('admin.transaction.create', $user));
});

// Transaction Index > Transaction User > Create > Review
Breadcrumbs::for('admin.transaction.review', function (BreadcrumbTrail $trail, $user, $transaction) {
    $trail->parent('admin.transaction.create', $user);
    $trail->push('Review', route('admin.transaction.review', [$user, $transaction]));
});

// ==================================================================================================================

// Transaction Index
Breadcrumbs::for('admin.jewellery.index', function (BreadcrumbTrail $trail) {
    $trail->push('Perhiasan', route('admin.jewellery.index'));
});

// Transaction Index > Create
Breadcrumbs::for('admin.jewellery.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.jewellery.index');
    $trail->push('Tambah', route('admin.jewellery.create'));
});

// Transaction Index > Edit
Breadcrumbs::for('admin.jewellery.edit', function (BreadcrumbTrail $trail, $jewellery) {
    $trail->parent('admin.jewellery.index');
    $trail->push('Edit', route('admin.jewellery.edit', $jewellery));
});

// ==================================================================================================================

// Buyback Index
Breadcrumbs::for('admin.buyback.index', function (BreadcrumbTrail $trail) {
    $trail->push('Beli Kembali', route('admin.buyback.index'));
});


// Buyback Index > Buyback User
Breadcrumbs::for('admin.buyback.users', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.buyback.index');
    $trail->push('Pengguna', route('admin.buyback.users'));
});

// Buyback Index > Buyback User > Create
Breadcrumbs::for('admin.buyback.create', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.buyback.users');
    $trail->push('Keranjang', route('admin.buyback.create', $user));
});

// Buyback Index > Buyback User > Create > Review
Breadcrumbs::for('admin.buyback.review', function (BreadcrumbTrail $trail, $user, $buy_back) {
    $trail->parent('admin.buyback.create', $user);
    $trail->push('Review', route('admin.buyback.review', [$user, $buy_back]));
});

// ==================================================================================================================

// User Index
Breadcrumbs::for('admin.user.index', function (BreadcrumbTrail $trail) {
    $trail->push('Pengguna', route('admin.user.index'));
});

// User Index > User Transactions
Breadcrumbs::for('admin.user.transactions', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.user.index');
    $trail->push('Transaksi', route('admin.user.transactions', $user));
});

// User Index > User Buybacks
Breadcrumbs::for('admin.user.buybacks', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.user.index');
    $trail->push('Beli Kembali', route('admin.user.buybacks', $user));
});
