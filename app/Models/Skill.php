<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'level',
        'icon',
        'color',
        'color_fill',
        'sort_order',
    ];

    protected $casts = [
        'level'        => 'integer',
        'sort_order'   => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


/*
|--------------------------------------------------------------------------
| MIGRATION — jalankan: php artisan make:migration create_skills_table
|--------------------------------------------------------------------------
| Isi migration-nya:
|
|  Schema::create('skills', function (Blueprint $table) {
|      $table->id();
|      $table->string('name');
|      $table->string('category');
|      $table->unsignedTinyInteger('level')->default(50);
|      $table->string('icon')->nullable();
|      $table->string('color', 20)->nullable();
|      $table->string('color_fill', 20)->nullable();
|      $table->json('certificates')->nullable();
|      $table->unsignedSmallInteger('sort_order')->default(0);
|      $table->timestamps();
|  });
|
| Lalu: php artisan migrate
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| ROUTES — tambahkan di routes/web.php
|--------------------------------------------------------------------------
|
|  use App\Http\Controllers\SkillController;
|
|  Route::resource('skills', SkillController::class)
|       ->only(['index', 'store', 'update', 'destroy']);
|
|--------------------------------------------------------------------------
*/
