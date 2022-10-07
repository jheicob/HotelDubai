<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UsersCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function create(UsersCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $this->createUser($request);

            DB::commit();

            return response()->json(['status'=>200],Response::HTTP_OK);

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

    protected function createUser($request)
    {
        $user              = new User();
        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->password    = bcrypt($request->password);
        $user->save();

        $user->roles()->sync($request->get('role_id'));

        return $user->id;
    }
}
