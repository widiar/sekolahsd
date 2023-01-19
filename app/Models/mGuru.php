<?php

namespace app\Models;

use app\Helpers\Main;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use function foo\func;

class mGuru extends Model
{
    use SoftDeletes;

    protected $table = 'guru';
    protected $primaryKey = 'id_guru';
    protected $fillable = [
        'gru_nip',
        'gru_nama',
        'id_mata_pelajaran',
        'gru_alamat'
    ];

    public function mata_pelajaran()
    {
        return $this->belongsTo(mMataPelajaran::class, 'id_mata_pelajaran');
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
