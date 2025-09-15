<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Http\Resources\MobileSettingResource;
use App\Http\Resources\NotificationResource;
use App\Models\Driver;
use App\Models\MobileSetting;
use Carbon\Carbon;



class NotificationController extends Controller
{



  public function index()
  {
    $driver = auth('driver')->user();

    $notifications = $driver->notification?->sortByDesc('id');

    $notifications = $notifications->map(function ($item) {
      return $item->notification;
    })->filter();




    $grouped = $notifications->groupBy(function ($item) {
      $createdAt = Carbon::parse($item?->created_at);
      if ($createdAt->isToday()) {
        return "Bu gün";
      } else if ($createdAt->isYesterday()) {
        return "Dünən";
      } else {
        return $createdAt->format('d.m.Y');
      }
    });

    $sorted = collect();

    if ($grouped->has('Bu gün')) {
      $sorted->put('Bu gün', NotificationResource::collection($grouped->get('Bu gün')));
    }

    if ($grouped->has('Dünən')) {
      $sorted->put('Dünən', NotificationResource::collection($grouped->get('Dünən')));
    }



    $dates = $grouped->keys()->filter(function ($key) {
      return $key !== 'Bu gün' && $key !== "Dünən";
    })->values()
      ->sort(function ($a, $b) {
        return Carbon::createFromFormat('d.m.Y', $b)->timestamp <=> Carbon::createFromFormat('d.m.Y', $a)->timestamp;
      });

    foreach ($dates as $date) {
      $sorted->put($date, NotificationResource::collection($grouped->get($date)));
    }

    return $sorted;


  }

}
