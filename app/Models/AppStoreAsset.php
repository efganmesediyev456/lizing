<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AppStoreAsset extends Model
{
    protected $guarded = [];

    protected $casts = [
        'screenshot_paths' => 'array',
        'tablets'=>'array'
    ];

    // Kullanıcı ilişkisi (opsiyonel)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getScreenshotPathsAttribute($value){
        $values =json_decode(json_decode($value), true);
      
        return collect($values)->map(function ($path){
            return url(Storage::url($path));
        });
    }

    public function getTabletsAttribute($value){
        $values =json_decode(json_decode($value), true);
      
        return collect($values)->map(function ($path){
            return url(Storage::url($path));
        });
    }
}
