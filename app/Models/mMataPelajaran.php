<?php

namespace app\Models;

use app\Helpers\Main;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use function foo\func;

class mMataPelajaran extends Model
{
    use SoftDeletes;

    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id_mata_pelajaran';
    protected $fillable = [
        'mpj_kode',
        'mpj_nama',
        'mpj_kelas',
        'mpj_nilai_lulus',
        'id_guru'

    ];

    public function guru()
    {
        return $this->belongsTo(mGuru::class, 'id_guru');
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
