<?php

namespace App\Rules\Room;

use App\Models\RoomStatus;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class VerifiedStatusPermissForCamarero implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $rol = Auth::user()->roles->first();

        switch ($rol->name) {
            case 'Admin':
                return true;
                break;
            case 'Camarero':
                $bool = self::getRoomStatusForCamarero();
                $bool = $bool->where('id', $value)->first();
                break;
            default:
                return false;
        }

        if ($bool == '') return false;
        return true;
    }

    private function  getRoomStatusForCamarero()
    {
        $room_status = RoomStatus::where('name', 'Sucio')
            ->orWhere('name', 'Disponible')
            ->get();

        return $room_status;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El rol no tiene permisos para ver';
    }
}
