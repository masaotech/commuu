<?php

use App\Http\Controllers\RouteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ShoppingItemController;
use App\Http\Controllers\HabitItemController;
use App\Http\Controllers\DeclutterItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RouteController::class, 'rootUrl'])->name('rootUrl');

// 基本はこちら（auth と verified と emptygroup）
Route::group(['middleware' => ['auth', 'verified', 'emptygroup']], routes: function () {
    // アカウント管理 関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // グループ管理 関連
    Route::get('/group', [GroupController::class, 'index'])->name('group.index');
    Route::get('/group/create', [GroupController::class, 'create'])->name('group.create');
    Route::patch('/group/{group}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('/group/{group}', [GroupController::class, 'destroy'])->name('group.destroy');
    Route::get('/group/{group}/edit', [GroupController::class, 'edit'])->name('group.edit');
    Route::post('/group/{group}/adduseraccount', [GroupController::class, 'addUserAccount'])->name('group.addUserAccount');
    Route::patch('/group/{group}/updateUserRole', [GroupController::class, 'updateUserRole'])->name('group.updateUserRole');
    Route::delete('/group/{group}/destroygroupuser', [GroupController::class, 'destroyGroupUser'])->name('group.destroyGroupUser');
    Route::delete('/group/{group}/leavegroup', [GroupController::class, 'leaveGroup'])->name('group.leaveGroup');

    // 買い物アプリ 関連
    Route::get('/shoppingitem', [ShoppingItemController::class, 'index'])->name('shoppingitem.index');
    Route::get('/shoppingitem/edit', [ShoppingItemController::class, 'edit'])->name('shoppingitem.edit');
    Route::post('/shoppingitem', [ShoppingItemController::class, 'store'])->name('shoppingitem.store');
    Route::post('/shoppingitem/changeItemStatus', [ShoppingItemController::class, 'changeItemStatus'])->name('shoppingitem.changeItemStatus');
    Route::post('/shoppingitem/updateItemInfo', [ShoppingItemController::class, 'updateItemInfo'])->name('shoppingitem.updateItemInfo');
    Route::post('/shoppingitem/deleteItemInfo', [ShoppingItemController::class, 'deleteItemInfo'])->name('shoppingitem.deleteItemInfo');

    // 定例To-Doアプリ 関連
    Route::get('/habititem', [HabitItemController::class, 'index'])->name('habititem.index');
    Route::get('/habititem/edit', [HabitItemController::class, 'edit'])->name('habititem.edit');
    Route::post('/habititem/store', [HabitItemController::class, 'store'])->name('habititem.store');
    Route::post('/habititem/update', [HabitItemController::class, 'update'])->name('habititem.update');
    Route::post('/habititem/destroy', [HabitItemController::class, 'destroy'])->name('habititem.destroy');

    // 断捨離アプリ 関連
    Route::get('/declutter', [DeclutterItemController::class, 'index'])->name('declutter.index');
    Route::post('/declutter/store', [DeclutterItemController::class, 'store'])->name('declutter.store');
    Route::post('/declutter/destroy', [DeclutterItemController::class, 'destroy'])->name('declutter.destroy');
});

// 一部はこちら（auth のみ）
Route::group(['middleware' => ['auth', 'verified']], routes: function () {
    // グループ管理 関連
    Route::get('/group/create', [GroupController::class, 'create'])->name('group.create');
    Route::post('/group', [GroupController::class, 'store'])->name('group.store');
    Route::post('/group/changecurrentgroup', [GroupController::class, 'changeCurrentGroup'])->name('group.changeCurrentGroup');
    Route::get('/group/pickoutgroup', [GroupController::class, 'pickOutGroup'])->name('group.pickOutGroup');
});

require __DIR__ . '/auth.php';
