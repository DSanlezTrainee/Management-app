<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    /**
     * Get company information, creating a default record if none exists
     * 
     * @return \App\Models\Company
     */
    public static function info()
    {
        $company = static::first();

        if (!$company) {
            $company = static::create([
                'name' => 'My Company',
            ]);
        }

        return $company;
    }
}
