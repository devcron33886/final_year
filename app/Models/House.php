<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class House extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, HasFactory;

    public $table = 'houses';

    protected $appends = [
        'cover_photo','photos'
    ];

    const CURRENCY_SELECT = [
        '0' => 'RWF',
        '1' => 'USD',
    ];

    const HOUSE_STATUS_SELECT = [
        '1' => 'Available',
        '0' => 'Gone',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const PRICE_STATUS_SELECT = [
        '0' => 'Negotiable',
        '1' => 'Notnegotiable',
    ];

    const PAYMENT_TIME_SELECT = [
        '0' => 'Monthly',
        '1' => 'Yearly',
        '2' => 'Weekly',
        '3' => 'Daily',
        '4' => 'Nightly',
    ];

    protected $fillable = [
        'title',
        'price',
        'price_status',
        'currency',
        'payment_time',
        'bedrooms',
        'bathrooms',
        'floors',
        'latitude',
        'longitude',
        'house_status',
        'description',
        'created_by_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 120, 120);
        $this->addMediaConversion('preview')->fit('crop', 400, 400);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function getCoverPhotoAttribute()
    {
        $file = $this->getMedia('cover_photo')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }
    public function getPhotosAttribute()
    {
        $files = $this->getMedia('photos');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }
    
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function scopeSearchResults($query)
    {
        return $query->where('house_status', 1)
            ->when(request()->filled('search'), function($query) {
                $query->where(function($query) {
                    $search = request()->input('search');
                    $query->where('title', 'LIKE', "%$search%")
                        ->orWhere('description', 'LIKE', "%$search%")
                        ->orWhere('price', 'LIKE', "%$search%");
                });
            })
            ->when(request()->filled('category'), function($query) {
                $query->whereHas('categories', function($query) {
                    $query->where('id', request()->input('category'));
                });
            });
    }
}
