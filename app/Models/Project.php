<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'cover', 'type_id'];


    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function getCreatedAt()
    {
        return Carbon::create($this->created_at)->format('d-m-Y');
    }
    public function getUpdatedAt()
    {
        return Carbon::create($this->updated_at)->format('d-m-Y');
    }
}
