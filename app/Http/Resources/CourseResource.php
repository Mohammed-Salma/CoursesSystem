<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //هنتحكم في الحقول يلي هترجع
        //فقط  الحقول يلي هيتم ذكرها هي اللي هترجع
        //وكمان بنقدر نغير اسماء الحقول والاعمدة زي ما بدنا
        return [
            'id' => $this->id,
            'the_name' => $this->name,
            'the_active' => $this->active ? 'مفعل' : 'غير مفعل',
        ];
    }
}
