<?php

namespace app\Models;

use app\Helpers\Main;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class mKaryawan extends Model
{
    use SoftDeletes;

    protected $table = 'tb_karyawan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_karyawan',
        'nama_karyawan',
        'alamat_karyawan',
        'telp_karyawan',
        'posisi_karyawan',
        'email_karyawan',
        'foto_karyawan'
    ];

    public function user()
    {
        return $this->hasMany(mUser::class, 'id');
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
