<?php

namespace Modules\Admin\Transformers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Role
 */
class SystemRoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $data                = parent::toArray($request);
        $data['permissions'] = $this->permissions->pluck('name');

        return $data;
    }
}
