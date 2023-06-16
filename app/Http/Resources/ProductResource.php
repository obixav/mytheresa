<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "sku" => $this->sku,
            "name" => $this->name,
            "category" => $this->category->name,
            "price" => [
                "original" => $this->price / 100,
                "final" => $this->when($this, function () {
                    if ($this->discount > 0 || $this->category->discount > 0) {
                        return $this->discount > $this->category->discount ? round(($this->price / 100) * ((100 - $this->discount) / 100)) : round(($this->price / 100) * ((100 - $this->category->discount) / 100));
                    } elseif ($this->discount == 0 && $this->category->discount == 0) {
                        return round($this->price / 100);
                    }
                }),
                "discount_percentage" => $this->when($this, function () {
                    if ($this->discount > 0 || $this->category->discount > 0) {
                        return $this->discount > $this->category->discount ? $this->discount . '%' : $this->category->discount . '%';
                    } elseif ($this->discount == 0 && $this->category->discount == 0) {
                        return null;
                    }
                }),
                "currency" => "Eur"
            ]
        ];
    }
}
