<?php

namespace Modules\Admin\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Models\SystemAdmin;

/**
 * @mixin SystemAdmin
 */
class SystemAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $data          = parent::toArray($request);
        $data['roles'] = $this->roles->pluck('name');

        return $data;
    }
}
