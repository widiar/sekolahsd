<?php

namespace app\Models;

use app\Helpers\Main;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mUserRole extends Model
{
    use SoftDeletes;

    protected $table = 'tb_user_role';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_name',
        'role_keterangan',
        'role_akses'
    ];

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
