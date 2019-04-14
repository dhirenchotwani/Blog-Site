<?php
//this model is created using artisan usig php artisan make:model Post -m
//here -m is to make migrations which contains db base queries

// php artisan migrate is used to run the migrations(queries formed)
//for post create_posts_table migration is created
namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
	protected $tableName='posts';
	public $primaryKey='id';
	//timestamps are already true for updation and stuff we can turn false here!
	public $timestamps=true;
	
	public function user(){
		return $this->belongsTo('App\User');
	}
}
