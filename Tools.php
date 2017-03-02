<?php namespace JC;

class Tools
{
    public static function getKeysFromArrayOfHashes($hashes)
    {
        $keys = array_unique(
            call_user_func_array(
                'array_merge',
                array_map(
                    function ($hash) {
                        return array_keys($hash);
                    },
                    $hashes
                )
            )
        );

        return $keys;
    }

    public static function getRowsFromArrayOfHashesAlignedOnKeys($hashes, $keys = null)
    {
        if (is_null($keys)) {
            $keys = self::getKeysFromArrayOfHashes($hashes);
        }
        $rows = array_map(function ($hash) use ($keys) {
            return array_map(
                function ($key) use ($hash) {
                    if (array_key_exists($key, $hash)) {
                        return $hash[$key];
                    }
                },
                $keys
            );
        }, $hashes);

        return $rows;
    }

    public static function getArrayFromHashesWithKeysAsHeaders($hashes, $headers = null)
    {
        if (is_null($headers)) {
            $headers = self::getKeysFromArrayOfHashes($hashes);
        }
        $keys = $headers;
        $rows = self::getRowsFromArrayOfHashesAlignedOnKeys($hashes, $keys);
        array_unshift($rows, $headers);

        return $rows;
    }
}
