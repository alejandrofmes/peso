<?php

namespace App\Models;

//

use App\Redactors\FiveHashRedactor;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\Auth\CustomVerifyEmailQueued);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\Auth\CustomResetPasswordQueued($token));
    }

    protected $attributeModifiers = [
        'password' => FiveHashRedactor::class,
        'remember_token' => FiveHashRedactor::class,
        'google2fa_secret' => FiveHashRedactor::class,

    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'usertype',
        'userstatus',
        'description',
        'disabled_at',
        'google2fa_secret',
        'google2fa_enabled_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'disabled_at' => 'datetime',
        'google2fa_enabled_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected function google2faSecret(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value ? decrypt($value) : null,
            set: fn($value) => $value ? encrypt($value) : null,
        );
    }
    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }
    public function peso_accounts()
    {
        return $this->hasOne(PESO_Accounts::class, 'user_id');
    }

    public static function fieldMappings()
    {
        return [
            'id' => 'User ID',
            'email' => 'Email Address',
            'password' => 'Password',
            'usertype' => 'User Type',
            'userstatus' => 'Account Status',
            'description' => 'Status Remarks',
            'disabled_at' => 'Deactivated At',
            'email_verified_at' => 'Email Verified At',
            'google2fa_secret' => 'Google 2FA',
            'google2fa_enabled_at' => 'Google Enabled At',
            'remember_token' => 'Remember Token',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
