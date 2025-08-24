<?php

namespace Litepie\Hashids\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait Hashids
{
    /**
     * Check if the model uses soft deletes.
     *
     * @return bool
     */
    protected static function usesSoftDeletes()
    {
        return in_array(SoftDeletes::class, class_uses_recursive(static::class));
    }

    /**
     * Find a model by its hashed ID or throw an exception.
     *
     * @param  string  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|static
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findOrFail($id, $columns = ['*'])
    {
        $decodedId = hashids_decode($id);

        if (empty($decodedId)) {
            throw (new static)->newModelNotFoundException();
        }

        if (static::usesSoftDeletes()) {
            return parent::withTrashed()->findOrFail($decodedId, $columns);
        }

        return parent::findOrFail($decodedId, $columns);
    }

    /**
     * Find a model by its hashed ID or return a new instance.
     *
     * @param  string  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function findOrNew($id, $columns = ['*'])
    {
        $decodedId = hashids_decode($id);

        if (empty($decodedId)) {
            return new static;
        }

        if (static::usesSoftDeletes()) {
            $result = parent::withTrashed()->find($decodedId, $columns);
        } else {
            $result = parent::find($decodedId, $columns);
        }

        return $result ?: new static;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return hashids_encode($this->getKey());
    }

    /**
     * Get the encoded ID attribute (alias for route key).
     *
     * @return string
     */
    public function getEidAttribute()
    {
        return hashids_encode($this->getKey());
    }

    /**
     * Get a signed ID with optional expiry.
     *
     * @param  int|string  $expiry
     * @return string
     */
    public function getSignedId($expiry = 0)
    {
        if (! empty($expiry)) {
            $expiry = is_numeric($expiry) ? $expiry : strtotime($expiry);
        }

        $appKey = hashids_config('salt') ?: (\function_exists('env') ? env('APP_KEY', '') : '');
        $salt = preg_replace('/[^0-9]/', '', $appKey);

        return hashids_encode([$this->getKey(), $salt, $expiry]);
    }

    /**
     * Find a model by its signed hashed ID.
     *
     * @param  string  $signedId
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public static function findBySignedId($signedId, $columns = ['*'])
    {
        $decodedSignedId = hashids_decode($signedId);

        if (empty($decodedSignedId) || count($decodedSignedId) !== 3) {
            return new static;
        }

        $appKey = hashids_config('salt') ?: (\function_exists('env') ? env('APP_KEY', '') : '');
        $salt = preg_replace('/[^0-9]/', '', $appKey);

        // Verify salt
        if ($salt != $decodedSignedId[1]) {
            return new static;
        }

        // Check expiry
        if ($decodedSignedId[2] != 0 && $decodedSignedId[2] < strtotime('now')) {
            return new static;
        }

        if (static::usesSoftDeletes()) {
            $result = parent::withTrashed()->find($decodedSignedId[0], $columns);
        } else {
            $result = parent::find($decodedSignedId[0], $columns);
        }

        return $result ?: new static;
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $decodedId = hashids_decode($value);

        if (empty($decodedId)) {
            return null;
        }

        return static::where($field ?? $this->getRouteKeyName(), $decodedId)->first();
    }
}
