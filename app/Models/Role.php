<?php

namespace App\Models;

use Spatie\Permission\Models\Role as RoleBase;

class Role extends RoleBase
{
    public function estateTypes()
    {
        return $this->belongsToMany(EstateType::class);
    }

    /**
     * @var RoleBase $role un solo rol
     * @return EstateType collect
     */
    public function getEstateTypeByRole(RoleBase $role)
    {
        $id_role = $role->id;

        $current = $this->find($id_role);

        return $current->estateTypes;
    }
}
