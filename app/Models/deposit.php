<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;


class deposit extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'admin', 'nominal', 'created_at'];

    public function save(array $options = array())
    {
    	if( ! $this->admin)
        {
            $this->admin = Auth::user()->id;
        }
    	parent::save($options);
    }

    //table name
    protected $table = 'deposits';
    //primary key
    public $primaryKey = 'id';
    //timestaps
    public $timestaps = true;

    public $sortable = ['id',
                        'admin',
                        'nominal',
                        'created_at',
                        'updated_at'];
}