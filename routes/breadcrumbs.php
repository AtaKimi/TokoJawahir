<?php

// routes/breadcrumbs.php

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

// ==================================================================================================================

// User Index
Breadcrumbs::for('user.profile.index', function (BreadcrumbTrail $trail) {
    $trail->push('Profile', route('user.profile.index'));
});

// User Index > User edit profile
Breadcrumbs::for('user.profile.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('user.profile.index');
    $trail->push('Edit', route('user.profile.edit'));
});

// ==================================================================================================================

// User Transaction Index
Breadcrumbs::for('user.transaction.index', function (BreadcrumbTrail $trail) {
    $trail->push('Transaksi', route('user.transaction.index'));
});

// User Transaction Index > User Transaction Show
Breadcrumbs::for('user.transaction.show', function (BreadcrumbTrail $trail, $transaction) {
    $trail->parent('user.transaction.index');
    $trail->push('Detail', route('user.transaction.show', $transaction));
});

// ==================================================================================================================

// User Buyback Index
Breadcrumbs::for('user.buyback.index', function (BreadcrumbTrail $trail) {
    $trail->push('Beli Kembali', route('user.buyback.index'));
});

// User Buyback Index > User Buyback Show
Breadcrumbs::for('user.buyback.show', function (BreadcrumbTrail $trail, $buy_back) {
    $trail->parent('user.buyback.index');
    $trail->push('Detail', route('user.buyback.show', $buy_back));
});

// =================================================================================================================

// Store Index
Breadcrumbs::for('admin.store.index', function (BreadcrumbTrail $trail) {
    $trail->push('Toko', route('admin.store.index'));
});

// Store Index > Store Edit
Breadcrumbs::for('admin.store.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.store.index');
    $trail->push('Edit', route('admin.store.edit'));
});

// ======================================================  Guest  ===========================================================

Breadcrumbs::for('guest.index', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('guest.index'));
});

Breadcrumbs::for('guest.jewellery.index', function (BreadcrumbTrail $trail) {
    $trail->parent('guest.index');
    $trail->push('Jewellery', route('guest.jewellery.index'));
});

Breadcrumbs::for('guest.jewellery.show', function (BreadcrumbTrail $trail, $jewellery) {
    $trail->parent('guest.jewellery.index');
    $trail->push('Detail', route('guest.jewellery.show', $jewellery));
});
