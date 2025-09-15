<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $title = match($this->is_cron_debt){
            1 => 'Ödəniş bildirişi',
            2 => 'Texniki baxış bildirişi',
            3 => 'Sığorta bildirişi',
            'default'=> $this->driverNotificationTopic?->title
        };
       
        $driverNotificationTopicTitle = $title;
        return [
            "id"=> $this->id,
            'title'=>$driverNotificationTopicTitle,
            'note'=>$this->note, 
        ];
    }
}
