<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $fillable = [
        'site_name',
        'logo',
        'favicon',
        'contact_email',
        'maintenance_mode',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'from_email',
        'from_name',
        'connecteam_api_key',
        'points',
        'referrer_percent',
    ];
}
