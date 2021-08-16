<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends HomeController
{
    protected $name = 'UserRole';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     return parent::index($request);
    // }

    protected function setViewParameters(Request $request)
    {
        $parameters = parent::setViewParameters($request);
        $Roles = Role::get();
        $columns = [
            ['key' => '用户姓名', 'sortable' => false],
        ];
        foreach ($Roles as $Role) {
            $columns[] = [
                'key' => $Role->name,
                'sortable' => false,
            ];
        }
        $parameters['columns'] = json_encode($columns);
        return $parameters;
    }

    function list() {
        $Roles = Role::get();
        //create checkbox items
        $roles = [];
        foreach ($Roles as $Role) {
            if ($Role->name == 'admin') {
                continue;
            }
            $roles[] = [
                'text' => $Role->name,
                'value' => $Role->id,
            ];
        }
        $columns = [
            ['key' => '用户姓名'],
        ];
        foreach ($Roles as $Role) {
            $columns[] = [
                'key' => $Role->name,
            ];
        }
        $Users = User::with(['UserRole', 'UserRole.Role'])->get();
        $UserRoles = [];
        foreach ($Users as $User) {
            $user_cols = ['用户姓名' => $User->name];
            foreach ($Roles as $Role) {
                $user_cols[$Role->name] = [
                    'id' => null,
                    'user_id' => $User->id,
                    'role_id' => $Role->id,
                    'grant' => false,
                ];
            }
            foreach ($User->UserRole as $UserRole) {
                $user_cols[$UserRole->Role->name]['id'] = $UserRole->id;
                $user_cols[$UserRole->Role->name]['grant'] = true;
            }
            $UserRoles[] = $user_cols;
        }
        return json_encode([
            'Roles' => $roles,
            'UserRoleHeaders' => $columns,
            'UserRoles' => $UserRoles,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        UserRole::create([
            'user_id' => $request->input('user_id'),
            'role_id' => $request->input('role_id'),
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
        UserRole::destroy($id);
    }
}
