<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Models\Audit;

class Product extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use AuditableTrait;

    protected $guarded = [];
    protected $auditable = true;
    protected $table = 'product';

    public function categories() {
        return $this->belongsTo(Categories::class, 'categories_id', 'id');
    }
    public function audits(): \Illuminate\Database\Eloquent\Relations\MorphMany {
        return $this->morphMany(\OwenIt\Auditing\Models\Audit::class, 'auditable');
    }
}
