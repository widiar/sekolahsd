<?php

namespace app\Models;

use app\Helpers\Main;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class mUser extends Model
{
    use SoftDeletes;

    protected $table = 'tb_user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_karyawan',
        'id_user_role',
        'username',
        'password',
        'nama',
        'inisial_karyawan',
        'id_lokasi'
    ];
    protected $hidden = [
        'password'
    ];

    function karyawan()
    {
        return $this->belongsTo(mKaryawan::class, 'id_karyawan');
    }

    function user_role()
    {
        return $this->belongsTo(mUserRole::class, 'id_user_role');
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
