<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\RoleFunctionPermission;
use App\_Function;
use Illuminate\Http\Request;

class RoleFunctionPermissionController extends HomeController
{
    protected $name = 'RoleFunctionPermission';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    // }

    function list() {
        $Roles = Role::with(['RoleFunctionPermission', 'RoleFunctionPermission._Function', 'RoleFunctionPermission.Permission'])->get();
        $Functions = _Function::get();
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
        $functions = [];
        foreach ($Functions as $Function) {
            $functions[] = [
                'text' => $Function->name,
                'value' => $Function->id,
            ];
            $function_cols = ['功能' => $Function->name];
            foreach ($Roles as $Role) {
                // if ($Role->name == 'admin') {
                //     continue;
                // }
                $function_cols[$Role->name] = [
                    'id' => null,
                    'role_id' => $Role->id,
                    'function_id' => $Function->id,
                    'permissions' => [],
                ];
                foreach ($Permissions as $Permission) {
                    // $function_cols[$Role->name]['permissions'][] = [
                    //     'text' => $Permission->name,
                    //     'value' => $Permission->id,
                    // ];
                    $function_cols[$Role->name]['permissions'][$Permission->name] = [
                        'id' => $Permission->id,
                        'granted' => false,
                    ];
                }
            }
            foreach ($Function->RoleFunctionPermission as $RoleFunctionPermission) {
                $function_cols[$RoleFunctionPermission->Role->name]['id'] = $RoleFunctionPermission->id;
                $function_cols[$RoleFunctionPermission->Role->name]['permissions'][$RoleFunctionPermission->Permission->name]['granted'] = true;
            }
            $RoleFunctionPermissions[] = $function_cols;
        }
        return json_encode([
            'Functions' => $functions,
            'RoleFunctionHeaders' => $columns,
            'RoleFunctionPermissions' => $RoleFunctionPermissions,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        RoleFunctionPermission::create([
            'role_id' => $request->input('role_id'),
            'function_id' => $request->input('function_id'),
            'permission_id' => $request->input('permission_id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
