<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UsersUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdatedController extends Controller
{
    public function updated(UsersUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $taks = User::where('id', $id)->withTrashed()->first();

            $taks->update($request->only([
                'name'  ,
                'email' ,
                'fiscal_machine_id'
            ]));

            if ($request->password) {
                $taks->update([
                    'password'  => bcrypt($request->password)
                ]);
            }
            $taks->roles()->sync($request->get('role_id'));
            DB::commit();

            return response()->json(Response::HTTP_OK);
        } catch (ValidationException $ex) {
            return response()->json([
                'data' => [
                    'title'  => $ex->getMessage(),
                    'errors' => collect($ex->errors())->flatten()
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'        => $ex->getCode(),
                    'title'       => __('errors.server.title'),
                    'description' => $ex->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
