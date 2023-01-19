<?php

namespace app\Models;

use app\Helpers\Main;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use function foo\func;

class mLaporanSiswa extends Model
{
    use SoftDeletes;

    protected $table = 'laporan_siswa';
    protected $primaryKey = 'id_laporan_siswa';
    protected $fillable = [
        'id_kelas',
        'lps_jumlah_siswa',
        'lps_lulus',
        'lps_tidak_lulus'
    ];

    public function kelas()
    {
        return $this->belongsTo(mKelas::class, 'id_kelas');
    }

    public function province()
    {
        return $this->belongsTo(mProvince::class, 'id_province');
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
