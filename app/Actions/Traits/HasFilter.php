<?php

namespace App\Actions\Traits;

trait HasFilter
{
    public function scopeFilterByName($query, array $params)
    {
        if (@$params['search']) {
            $query->where('name', 'like', "%{$params['search']}%");
        }
    }

    public function scopeFilterById($query, array $params)
    {
        if (@$params['search']) {
            $query->where('id', 'like', "%{$params['search']}%");
        }
    }

    public function scopeFilterByCategory($query, array $params)
    {
        if (@$params['category']) {
            $query->where('category_id', '=', "{$params['category']}");
        }
    }

    public function scopeFilterByCode($query, array $params)
    {
        if (@$params['search']) {
            $query->where('code', 'like', "%{$params['search']}%");
        }
    }

    public function scopeFIlterbyNameOrPhone($query, array $params)
    {
        if (@$params['search']) {
            $query->where('name', 'like', "%{$params['search']}%")->orWhere('phone', 'like', "%{$params['search']}%");
        }
    }
}
