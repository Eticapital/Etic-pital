<?php

namespace App\Models;

use App\Models\Traits\HasFile;
use Illuminate\Database\Eloquent\Model;

class ProjectDocument extends Model
{
    use HasFile;

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

    protected $appends = [
        'icon',
        'size_mb',
        'download_link'
    ];

    /**
     * El link para descargar el archivo
     *
     * @return string
     */
    public function getDownloadLinkAttribute()
    {
        return route('documents.download', [
            'document' => $this->id,
            'name' => urlencode($this->name),
        ]);
    }

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
}
