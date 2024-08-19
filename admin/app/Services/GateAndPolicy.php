<?php

namespace App\Services;
use Gate;
use App\Models\Category;
use App\Policies\CategoryPolicy;
use App\Policies\MenuPolicy;
use App\Policies\SettingPolicy;
use App\Policies\UserPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SliderPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
class GateAndPolicy{

    public function setGateAndPolicy(){
        $this->defineGateCategory('id');
        $this->defineGateSlider();
        // $this->defineGatePermission();
        $this->defineGateProduct('id');
        $this->defineGateSetting();
        $this->defineGateMenu();
        $this->defineGateRole();
        $this->defineGateUser();
    }
    

    public function defineGateSlider(){
        Gate::define('slider-list', [SliderPolicy::class, 'view']);
        Gate::define('slider-add', [SliderPolicy::class, 'create']);
        Gate::define('slider-edit', [SliderPolicy::class, 'update']);
        Gate::define('slider-delete', [SliderPolicy::class, 'delete']);
    }
    public function defineGateProduct($id){
        Gate::define('product-list', [ProductPolicy::class, 'view']);
        Gate::define('product-add', [ProductPolicy::class, 'create']);
        Gate::define('product-edit', [ProductPolicy::class, 'update']);
        Gate::define('product-delete', [ProductPolicy::class, 'delete']);
    }
    public function defineGateCategory($id){
        Gate::define('category-list', [CategoryPolicy::class, 'index']);
        Gate::define('category-add', [CategoryPolicy::class, 'create']);
        Gate::define('category-edit', [CategoryPolicy::class, 'edit']);
        Gate::define('category-delete', [CategoryPolicy::class, 'delete']);
    }
    public function defineGateMenu(){
        Gate::define('menu-list', [MenuPolicy::class, 'view']);
        Gate::define('menu-add', [MenuPolicy::class, 'create']);
        Gate::define('menu-edit', [MenuPolicy::class, 'update']);
        Gate::define('menu-delete', [MenuPolicy::class, 'delete']);
    }
    public function defineGateSetting(){
        Gate::define('setting-list', [SettingPolicy::class, 'view']);
        Gate::define('setting-add', [SettingPolicy::class, 'create']);
        Gate::define('setting-edit', [SettingPolicy::class, 'update']);
        Gate::define('setting-delete', [SettingPolicy::class, 'delete']);
    }
    public function defineGateRole(){
        Gate::define('role-list', [RolePolicy::class, 'view']);
        Gate::define('role-add', [RolePolicy::class, 'create']);
        Gate::define('role-edit', [RolePolicy::class, 'update']);
        Gate::define('role-delete', [RolePolicy::class, 'delete']);
    }
    // public function defineGatePermission(){
    //     Gate::define('permission-list', [PermissionPolicy::class, 'view']);
    //     Gate::define('permission-add', [PermissionPolicy::class, 'create']);
    //     Gate::define('permission-edit', [PermissionPolicy::class, 'update']);
    //     Gate::define('permission-delete', [PermissionPolicy::class, 'delete']);
    // }
    public function defineGateUser(){
        Gate::define('user-list', [UserPolicy::class, 'view']);
        Gate::define('user-add', [UserPolicy::class, 'create']);
        Gate::define('user-edit', [UserPolicy::class, 'update']);
        Gate::define('user-delete', [UserPolicy::class, 'delete']);
    }
}