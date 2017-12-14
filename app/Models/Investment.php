<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Traits\HasPolicyAttributes;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasPolicyAttributes;

    const STATUS_NEW = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = -1;

    protected $fillable = [
        'amount',
        'name',
        'email',
        'phone',
        'residence',
        'organization',
    ];

    protected $appends = [
        'status_label',
        'status_class',
        'status_icon',
    ];

    public function scopeAccepted($query)
    {
        return $query->whereInvestmentStatus(self::STATUS_ACCEPTED);
    }

    public function scopeActive($query)
    {
        return $query->where('investment_status', '>=', self::STATUS_NEW);
    }

    public function getStatusLabelAttribute()
    {
        if ($this->investment_status === self::STATUS_NEW) {
            return 'Pendiente';
        }
        if ($this->investment_status === self::STATUS_ACCEPTED) {
            return 'Aceptada';
        }
        if ($this->investment_status === self::STATUS_REJECTED) {
            return 'Rechazada';
        }
    }

    public function getStatusClassAttribute()
    {
        if ($this->investment_status === self::STATUS_NEW) {
            return 'info';
        }
        if ($this->investment_status === self::STATUS_ACCEPTED) {
            return 'success';
        }
        if ($this->investment_status === self::STATUS_REJECTED) {
            return 'danger';
        }
    }

    public function getStatusIconAttribute()
    {
        if ($this->investment_status === self::STATUS_NEW) {
            return 'menu';
        }
        if ($this->investment_status === self::STATUS_ACCEPTED) {
            return 'success';
        }
        if ($this->investment_status === self::STATUS_REJECTED) {
            return 'cross';
        }
    }

    /**
     * Una inversión pertence a un proyecto
     *
     * @return BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Marca la inversión como aceptada
     *
     * @return boolean
     */
    public function accept()
    {
        $this->investment_status = self::STATUS_ACCEPTED;
        return $this->save();
    }

    /**
     * Marca la inversión como rechazada
     *
     * @return boolean
     */
    public function reject()
    {
        $this->investment_status = self::STATUS_REJECTED;
        return $this->save();
    }
}
