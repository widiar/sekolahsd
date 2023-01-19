<?php

namespace app\Models;

use app\Helpers\Main;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use function foo\func;

class mAbsen extends Model
{
    use SoftDeletes;

    protected $table = 'absen';
    protected $primaryKey = 'id_absen';
    protected $fillable = [
        'abs_nomber',
        'id_siswa',
        'id_kelas',
        'abs_tanggal',
        'abs_keterangan'
    ];

    public function siswa()
    {
        return $this->belongsTo(mSiswa::class, 'id_siswa');
    }

    public function kelas()
    {
        return $this->belongsTo(mKelas::class, 'id_kelas');
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
