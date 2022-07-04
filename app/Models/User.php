<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Protected table name
     */
    protected $table = 'pma_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'namauser',
        'nama',
        'golongan',
        'pic',
        'kodesite',
        'sandi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'sandi',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->sandi;
    }

    public function getPicAttribute($pic){
        if ($pic !== null):
            // return asset('storage/pic/'.$this->id.'/pic_'.$pic);
            return asset('storage/images/'.$pic);
        else :
            return 'https://ui-avatars.com/api/?name='.str_replace(' ', '+', $this->nama).'&background=4e73df&color=ffffff&size=100';
        endif;
    }
}
