<?php

namespace App\Http\Controllers;

use App\Controller;
use App\Permission;
use App\Role;
use App\RoleFunctionPermission;
use Illuminate\Http\Request;

class RoleFunctionPermissionController extends Controller
{
    protected $name = 'RoleFunctionPermission';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Roles = Role::with(['RoleFunctionPermission', 'RoleFunctionPermission.Controller', 'RoleFunctionPermission.Permission'])->get();
        $Controllers = Controller::orderBy('name', 'asc')->get();
        $columns = [
            ['key' => '功能', 'stickyColumn' => true, 'isRowHeader' => true],
        ];
        foreach ($Roles as $Role) {
            // if ($Role->name == 'admin') {
            //     continue;
            // }
            $columns[] = [
                'key' => $Role->name,
            ];
        }
        $Permissions = Permission::get();
        $RoleFunctionPermissions = [];
        $controllers = [];
        foreach ($Controllers as $Controller) {
            $controllers[] = [
                'text' => $Controller->name,
                'value' => $Controller->id,
            ];
            $controller_cols = ['功能' => $Controller->name];
            foreach ($Roles as $Role) {
                // if ($Role->name == 'admin') {
                //     continue;
                // }
                $controller_cols[$Role->name] = [
                    'id' => null,
                    'role_id' => $Role->id,
                    'controller_id' => $Controller->id,
                    'permissions' => [],
                ];
                foreach ($Permissions as $Permission) {
                    // $controller_cols[$Role->name]['permissions'][] = [
                    //     'text' => $Permission->name,
                    //     'value' => $Permission->id,
                    // ];
                    $controller_cols[$Role->name]['permissions'][$Permission->name] = [
                        'id' => $Permission->id,
                        'granted' => false,
                    ];
                }
            }
            foreach ($Controller->RoleFunctionPermission as $RoleFunctionPermission) {
                $controller_cols[$RoleFunctionPermission->Role->name]['id'] = $RoleFunctionPermission->id;
                $controller_cols[$RoleFunctionPermission->Role->name]['permissions'][$RoleFunctionPermission->Permission->name]['granted'] = true;
            }
            $RoleFunctionPermissions[] = $controller_cols;
        }
        return json_encode([
            'Controllers' => $controllers,
            'fields' => $columns,
            'RoleFunctionPermissions' => $RoleFunctionPermissions,
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
        RoleFunctionPermission::create([
            'role_id' => $request->input('role_id'),
            'controller_id' => $request->input('controller_id'),
            'permission_id' => $request->input('permission_id'),
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
        RoleFunctionPermission::destroy($id);
    }
}
