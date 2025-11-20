<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessCredentialModel extends Model
{
    use SoftDeletes;

    protected $table = 'table_access_credentials';

    protected $fillable = [
        'customer_id',

        // WEB ACCESS
        'access_web',
        'username_web',
        'password_web',

        // OJS
        'akses_ojs',
        'username_ojs',
        'password_ojs',

        // CPANEL
        'akses_cpanel',
        'username_cpanel',
        'password_cpanel',

        // WEBMAIL
        'akses_webmail',
        'username_webmail',
        'password_webmail',

        'server',
        'note',
        'status',
        'expiration_date'
    ];

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id');
    }
}
