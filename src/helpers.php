<?php

if (! function_exists('hashids_encode')) {
    /**
     * Encode a value using Sqids.
     *
     * @param  mixed  $value
     * @return string
     */
    function hashids_encode($value)
    {
        $sqids = app('hashids');

        if (is_array($value)) {
            return $sqids->encode($value);
        }

        return $sqids->encode([$value]);
    }
}

if (! function_exists('hashids_decode')) {
    /**
     * Decode a sqid back to its original value.
     *
     * @param  string  $id
     * @return array|int|null
     */
    function hashids_decode($id)
    {
        if (empty($id) || ! is_string($id)) {
            return null;
        }

        $decoded = app('hashids')->decode($id);

        if (empty($decoded)) {
            return null;
        }

        return count($decoded) === 1 ? $decoded[0] : $decoded;
    }
}

if (! function_exists('hashids_config')) {
    /**
     * Get hashids configuration value.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function hashids_config($key, $default = null)
    {
        return app('config')->get("hashids.{$key}", $default);
    }
}

if (! function_exists('sqids_encode')) {
    /**
     * Encode a value using Sqids (alias for hashids_encode).
     *
     * @param  mixed  $value
     * @return string
     */
    function sqids_encode($value)
    {
        return hashids_encode($value);
    }
}

if (! function_exists('sqids_decode')) {
    /**
     * Decode a sqid back to its original value (alias for hashids_decode).
     *
     * @param  string  $id
     * @return array|int|null
     */
    function sqids_decode($id)
    {
        return hashids_decode($id);
    }
}
