<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppStoreAssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "app_name"=> $this->app_name,
            "short_description"=> $this->description,
            "full_description"=> $this->full_description,
            "app_icon_path"=> url('storage/'.$this->icon_path),
            "screenshot_paths"=> $this->screenshot_paths,
            "app_category"=> $this->app_category,
            "privacy_policy_url"=> $this->privacy_policy_url,
            "feature_graphic_image"=> url('storage/'.$this->feature_graphic_image),
            'tablets'=>$this->tablets
        ];
    }
}
