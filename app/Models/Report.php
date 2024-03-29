<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Report extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = true;
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subCategory(){
        return $this->belongsTo(Category::class, 'sub_category_id', 'id');
    }
    public function action(){
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }
}
