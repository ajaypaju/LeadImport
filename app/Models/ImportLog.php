<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ImportLog extends Model
{
    protected $fillable = [
        'file_name',
        'status',
        'error_message',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        $decryptedId = Crypt::decrypt($value);
        return $this->where($field ?? $this->getRouteKeyName(), $decryptedId)->firstOrFail();
    }

    public function getRouteKey()
    {
        return Crypt::encrypt($this->getKey());
    }
}
