<?php

  use Illuminate\Contracts\Container\BindingResolutionException;

  /**
   * @throws BindingResolutionException
   */
  function getConfig($value, $default = null): mixed
  {
    $filename = explode(".", $value)[0];

    $array = include(findConfig($filename));
    $key = str_replace($filename . '.', '', $value);
    return getArrayValueByKey($array, $key, $default);
  }

  /**
   * @throws BindingResolutionException
   */
  function findConfig($name): string
  {
    if (file_exists(get_template_directory() . '/config/' . $name .'.php')) {
      return get_template_directory() . '/config/' . $name .'.php';
    }

    if (file_exists(base_path() . '/config/' . $name .'.php')) {
      return base_path() . '/config/' . $name .'.php';
    }

    return '';
  }

  function getArrayValueByKey($array, $key, $default = null) {
    if (is_null($key)) {
      return $default;
    }

    if (isset($array[$key])) {
      return $array[$key];
    }

    foreach (explode('.', $key) as $segment) {
      if (!is_array($array) || !array_key_exists($segment, $array)) {
        return $default;
      }

      $array = $array[$segment];
    }

    return $array;
  }