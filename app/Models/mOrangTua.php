<?php

namespace app\Models;

use app\Helpers\Main;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use function foo\func;

class mOrangTua extends Model
{
    use SoftDeletes;

    protected $table = 'orang_tua';
    protected $primaryKey = 'id_orang_tua';
    protected $fillable = [
        'ort_nama_ayah',
        'ort_nama_ibu',
        'id_siswa',
        'ort_alamat',
        'username',
        'password'
    ];

    public function siswa()
    {
        return $this->belongsTo(mSiswa::class, 'id_siswa');
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
