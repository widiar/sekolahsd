<?php

namespace app\Models;

use app\Helpers\Main;
use app\Http\Controllers\MasterData\MataPelajaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use function foo\func;

class mLaporanAnak extends Model
{
    use SoftDeletes;

    protected $table = 'laporan_anak';
    protected $primaryKey = 'id_laporan_anak';
    protected $fillable = [
        'id_siswa',
        'id_mata_pelajaran',
        'lpa_nilai',
        'lpa_keterangan_guru'
    ];

    public function siswa()
    {
        return $this->belongsTo(mSiswa::class, 'id_siswa');
    }
    public function mata_pelajaran()
    {
        return $this->belongsTo(mMataPelajaran::class, 'id_mata_pelajaran');
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
