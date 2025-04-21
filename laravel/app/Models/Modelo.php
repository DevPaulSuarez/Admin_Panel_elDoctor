<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Modelo extends Model
{
    use Uuid;
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    protected $fillable = ['nombre', 'imagen_url', 'estado'];

    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = ["estado" => "boolean"];

    public static function setImagen($foto, $actual = false)
    {
        if($foto) {
            if($actual) {
                Storage::disk('public')->delete("files/$actual");
            }
            $imageName = Str::random(20) . '.jpg';
            $imagen = Image::make($foto)->encode('jpg', 90);
            $imagen->resize(500, 250, function ($constraint) {
                $constraint->upsize();
            });
            Storage::disk('public')->put("files/$imageName", $imagen->stream());
            return  $imageName;
        } else {
            return false;
        }
    }

    protected $table = 'modelos';
}
