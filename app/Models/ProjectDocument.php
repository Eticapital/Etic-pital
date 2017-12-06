<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDocument extends Model
{
    const CATEGORY_COMPANY = 'company';
    const CATEGORY_KEY = 'key';
    const CATEGORY_EXTRA = 'extra';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'file_name',
        'download_count',
        'downloaded_at',
        'created_at',
        'updated_at',
    ];

    protected $appends = ['icon'];

    public function scopeCompany($query)
    {
        return $query->where('category', self::CATEGORY_COMPANY);
    }

    public function scopeKey($query)
    {
        return $query->where('category', self::CATEGORY_KEY);
    }

    public function scopeExtra($query)
    {
        return $query->where('category', self::CATEGORY_EXTRA);
    }

    public function getIconAttribute()
    {
        $icon_parser = new \App\Extensions\MimeIconParser();
        return $icon_parser->getIconByExtension($this->extension);
    }
}
