<?php

namespace app\Models;

use app\Helpers\Main;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function foo\func;

class mSubdistrict extends Model
{
    protected $table = 'subdistrict';
    protected $primaryKey = 'id_subdistrict';
    protected $fillable = [
        'id_province',
        'id_city',
        'subdistrict_name'
    ];

    function barang() {
        return $this->belongsTo(mBarang::class, 'id_barang');
    }

    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'LIKE', '%' . $value . '%');
    }

    public function scopeOrWhereLike($query, $column, $value)
    {
        return $query->orWhere($column, 'LIKE', '%' . $value . '%');
    }

    public function getCreatedAtAttribute()
    {
        return date(Main::$date_format_view, strtotime($this->attributes['created_at']));
    }
    
    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])
            ->diffForHumans();
    }
}
