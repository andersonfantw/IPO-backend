<?php

namespace App\Http\Controllers;

use App\MenuItem;
use App\Role;
use App\RoleMenuItem;
use Illuminate\Http\Request;

class RoleMenuItemController extends HomeController
{
    protected $name = 'RoleMenuItem';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    // }

    function list() {
        $MenuItems = MenuItem::get();
        //create checkbox items
        $menu_items = [];
        foreach ($MenuItems as $MenuItem) {
            $menu_items[] = [
                'text' => $MenuItem->name,
                'value' => $MenuItem->id,
            ];
        }
        $columns = [
            ['key' => '菜單項'],
        ];
        $Roles = Role::get();
        foreach ($Roles as $Role) {
            $columns[] = [
                'key' => $Role->name,
            ];
        }
        $MenuItems = MenuItem::with(['RoleMenuItem', 'RoleMenuItem.Role'])->get();
        $items = [];
        foreach ($MenuItems as $MenuItem) {
            $menu_Item_cols = ['菜單項' => $MenuItem->name];
            foreach ($Roles as $Role) {
                $menu_Item_cols[$Role->name] = [
                    'id' => null,
                    'role_id' => $Role->id,
                    'menu_item_id' => $MenuItem->id,
                    'granted' => false,
                ];
            }
            foreach ($MenuItem->RoleMenuItem as $RoleMenuItem) {
                $menu_Item_cols[$RoleMenuItem->Role->name]['id'] = $RoleMenuItem->id;
                $menu_Item_cols[$RoleMenuItem->Role->name]['granted'] = true;
            }
            $items[] = $menu_Item_cols;
        }
        return json_encode([
            'MenuItems' => $menu_items,
            'fields' => $columns,
            'items' => $items,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        RoleMenuItem::create([
            'role_id' => $request->input('role_id'),
            'menu_item_id' => $request->input('menu_item_id'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RoleMenuItem::destroy($id);
    }
}
