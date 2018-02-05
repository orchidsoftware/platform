<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Traits;

use Illuminate\Support\Facades\Cache;

trait SettingTrait
{
    /**
     * @param string       $key
     * @param string|array $value
     *
     * Fast record
     *
     * @return bool
     */
    public function set(string $key, $value)
    {
        $result = $this->firstOrNew([
            'key' => $key,
        ])->fill([
                'value' => $value,
            ])->save();

        $this->cacheForget($key);

        return $result;
    }

    /**
     * @param $key
     *
     * @return null
     */
    private function cacheForget($key)
    {
        if (! $this->cache) {
            return;
        }

        if (is_array($key)) {
            foreach ($key as $value) {
                Cache::forget($value);
            }
        } else {
            Cache::forget($key);
        }
    }

    /**
     * @param string|array $key
     * @param string|null  $default
     *                              Get values
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (! $this->cache) {
            return $this->getNoCache($key, $default);
        }

        return Cache::rememberForever('settings-'.implode(',', (array) $key), function () use ($key, $default) {
            return $this->getNoCache($key, $default);
        });
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return null
     */
    public function getNoCache($key, $default = null)
    {
        if (is_array($key)) {
            $result = $this->select('key', 'value')->whereIn('key', $key)->pluck('value', 'key')->toArray();

            return empty($result) ? $default : $result;
        }

        $result = $this->select('value')->where('key', $key)->first();

        return is_null($result) ? $default : $result->value;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function forget($key)
    {
        if (is_array($key)) {
            $result = $this->whereIn('key', $key)->delete();
        } else {
            $result = $this->where('key', $key)->delete();
        }

        $this->cacheForget($key);

        return $result;
    }
}
