<?php

function getConfig ( $value, $default = null ): mixed
{
    $filename = explode( '.', $value )[0];

    $array = include findConfig( $filename );
    $key = str_replace( $filename . '.', '', $value );

    return getArrayValueByKey( $array, $key, $default );
}

function findConfig($name): string
{
    if (file_exists(get_template_directory().'/config/'.$name.'.php')) {
        return get_template_directory().'/config/'.$name.'.php';
    }

    if (file_exists(dirname(__DIR__, 5).'/config/'.$name.'.php')) {
        return file_exists(dirname(__DIR__, 5)).'/config/'.$name.'.php';
    }

    return dirname(__DIR__).'/config/xtension.php';
}

function getArrayValueByKey ( $array, $key, $default = null )
{
    if( is_null( $key ) ) {
        return $default;
    }

    if( isset( $array[ $key ] ) ) {
        return $array[ $key ];
    }

    foreach ( explode( '.', $key ) as $segment ) {
        if( !is_array( $array ) || !array_key_exists( $segment, $array ) ) {
            return $default;
        }

        $array = $array[ $segment ];
    }

    return $array;
}
