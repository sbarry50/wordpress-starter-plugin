<?php

/**
 * Array Helpers - Static Collection of Helpers for Data Type Array
 *
 * @package     Vendor\Plugin\Support
 * @since       1.0.0
 * @author      sbarry
 * @link        http://example.com
 * @license     GNU General Public License 2.0+ and MIT License (MIT)
 */

/**
 * This class has been adapted from the Laravel Illuminate framework, which
 * is copyrighted to Taylor Otwell and carries a MIT Licence (MIT). It was
 * adapted by Tonya Mork of KnowTheCode.io for her Fulcrum plugin.
 * Changes reflect WordPress coding standard, compliance with PHP 5.3, +
 * additional functionality. It has been modified further for this plugin.
 */

namespace Vendor\Plugin\Support;

class Arr {

	/**
	 * Add an element to an array using "dot" notation if it does not exist.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $array
	 * @param  string $key
	 * @param  mixed $value
	 *
	 * @return array
	 */
	public static function add( $array, $key, $value ) {
		if ( is_null( static::get( $array, $key ) ) ) {
			static::set( $array, $key, $value );
		}

		return $array;
	}

	/**
	 * Flatten a multi-dimensional associative array with dots.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $array
	 * @param  string $prepend
	 *
	 * @return array
	 */
	public static function dot( $array, $prepend = '' ) {
		$results = array();

		foreach ( $array as $key => $value ) {
			if ( is_array( $value ) ) {
				$results = array_merge( $results, static::dot( $value, $prepend . $key . '.' ) );
			} else {
				$results[ $prepend . $key ] = $value;
			}
		}

		return $results;
	}

	/**
	 * Get all of the given array except for a specified array of items.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $array
	 * @param  array|string $keys
	 *
	 * @return array
	 */
	public static function except( $array, $keys ) {
		return array_diff_key( $array, array_flip( (array) $keys ) );
	}

	/**
	 * Fetch a flattened array of a nested array element.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $array
	 * @param  string $key
	 *
	 * @return array
	 */
	public static function fetch( $array, $key ) {
		$results = self::dot_notation_walk( $array, $key, 'callback_fetch' );

		return array_values( $results );
	}

	/**
	 * Flatten a multi-dimensional array into a single level
	 *
	 * @since 1.0.0
	 *
	 * @param  array $array
	 *
	 * @return array
	 */
	public static function flatten( $array ) {
		$return = array();
		array_walk_recursive( $array, function ( $x ) use ( &$return ) {
			$return[] = $x;
		} );

		return $return;
	}

	/**
	 * Remove one or many array items from a given array using "dot" notation.
	 *
	 * @param  array $array
	 * @param  array|string $keys
	 *
	 * @return void
	 */
	public static function forget( array &$array, $keys ) {
		$original =& $array;
		foreach ( (array) $keys as $key ) {
			self::forget_segments( $array, $key );

			$array =& $original;
		}
	}

	/**
	 * Drop keys from the array
	 *
	 * @since 1.0.0
	 *
	 * @param $array
	 * @param $keys
	 *
	 * @return null
	 */
	public static function drop( array &$array, $keys ) {
		self::forget( $array, $keys );
	}

	/**
	 * Get an item from an array using "dot" notation.
	 *
	 * @param  array $array
	 * @param  string $key
	 * @param  mixed $default
	 *
	 * @return mixed
	 */
	public static function get( $array, $key, $default = null ) {
		if ( is_null( $key ) ) {
			return $array;
		}

		if ( isset( $array[ $key ] ) ) {
			return $array[ $key ];
		}

		return self::dot_notation_walk( $array, $key, 'callback_get', compact( 'default' ) );
	}

	/**
	 * Check if an item exists in an array using "dot" notation.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $array
	 * @param  string $key
	 *
	 * @return bool
	 */
	public static function has( array $array, $key ) {
		if ( empty( $array ) || is_null( $key ) ) {
			return false;
		}

		if ( array_key_exists( $key, $array ) ) {
			return true;
		}

		return false === self::dot_notation_walk( $array, $key, 'callback_has' ) ? false : true;
	}

	/**
	 * Checks if the element within the array is a valid array - uses key dot notation.
	 *
	 * @since 1.0.0
	 *
	 * @param array|mixed $array
	 * @param string $key
	 * @param bool|true $valid_if_not_empty
	 *
	 * @return bool
	 */
	public static function is_array( $array, $key = '', $valid_if_not_empty = true ) {
		if ( empty( $array ) || empty( $key ) ) {
			return false;
		}

		if ( array_key_exists( $key, $array ) ) {
			return self::is_array_element_valid_array( $array, $key, $valid_if_not_empty );
		}

		return self::dot_notation_walk( $array, $key, 'callback_is_array', compact( 'valid_if_not_empty' ) );
	}

	/**
	 * Get a subset of the items from the given array.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $array
	 * @param  array|string $keys
	 *
	 * @return array
	 */
	public static function only( $array, $keys ) {
		return array_intersect_key( $array, array_flip( (array) $keys ) );
	}

    /**
     * Pluck an array of values from an array.
     *
     * @param  array  $array
     * @param  string|array  $value
     * @param  string|array|null  $key
     * @return array
     */
    public static function pluck($array, $value, $key = null) {
        $results = [];

        list($value, $key) = static::explodePluckParameters($value, $key);

        foreach ($array as $item) {
            $itemValue = data_get($item, $value);

            // If the key is "null", we will just append the value to the array and keep
            // looping. Otherwise we will key the array using the value of the key we
            // received from the developer. Then we'll return the final array form.
            if (is_null($key)) {
                $results[] = $itemValue;
            } else {
                $itemKey = data_get($item, $key);

                $results[$itemKey] = $itemValue;
            }
        }

        return $results;
    }

    /**
     * Explode the "value" and "key" arguments passed to "pluck".
     *
     * @param  string|array  $value
     * @param  string|array|null  $key
     * @return array
     */
    protected static function explodePluckParameters($value, $key) {
        $value = is_string($value) ? explode('.', $value) : $value;

        $key = is_null($key) || is_array($key) ? $key : explode('.', $key);

        return [$value, $key];
    }

	/**
	 * Get a value from the array, and remove it.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $array
	 * @param  string $key
	 * @param  mixed $default
	 *
	 * @return mixed
	 */
	public static function pull( &$array, $key, $default = null ) {
		$value = static::get( $array, $key, $default );

		static::forget( $array, $key );

		return $value;
	}

	/**
	 * Set an array item to a given value using "dot" notation.
	 *
	 * If no key is given to the method, the entire array will be replaced.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $array
	 * @param  string $key
	 * @param  mixed $value
	 * @param bool $append When true, appends the value to the current value
	 *
	 * @return array
	 */
	public static function set( &$array, $key, $value, $append = false ) {
		if ( is_null( $key ) ) {
			return $array = $value;
		}

		$keys = explode( '.', $key );
		while ( count( $keys ) > 1 ) {
			$key = array_shift( $keys );

			self::init_empty_array_when_key_does_not_exists( $array, $key );
			$array =& $array[ $key ];
		}

		$key = array_shift( $keys );

		if ( $append ) {
			$value = $array[ $key ] . $value;
		}

		$array[ $key ] = $value;

		return $array;
	}

	/*****************
	 * Helpers
	 ***************/

	/**
	 * Init an empty array at the key index when the key does not currently exists in the array
	 *
	 * @since 1.0.0
	 *
	 * @param array $array
	 * @param string $key
	 */
	protected static function init_empty_array_when_key_does_not_exists( array &$array, $key ) {
		if ( ! array_key_exists( $key, $array ) || ! is_array( $array[ $key ] ) ) {
			$array[ $key ] = array();
		}
	}

	/**
	 * Dot notation array walker - this function dissembles the dot notation keys and then
	 * iterates through each of them and applies the callback to each.
	 *
	 * @since 1.0.0
	 *
	 * @param array $array
	 * @param string $dot_notation_keys
	 * @param string $callback
	 * @param array $args
	 *
	 * @return mixed
	 */
	protected static function dot_notation_walk( array &$array, $dot_notation_keys, $callback, $args = array() ) {
		$value = null;
		$break = false;

		$dot_notation_keys = explode( '.', $dot_notation_keys );
		foreach ( $dot_notation_keys as $key ) {
			$value = self::$callback( $array, $key, $break, $args );
			if ( $break ) {
				return $value;
			};
		}

		return $value;
	}

	/**
	 * Fetch() function callback for key dot notation walker
	 *
	 * @since 1.0.0
	 *
	 * @param array $array
	 * @param string $key Key to evaluate within the "array"
	 *
	 * @return bool
	 */
	protected static function callback_fetch( array &$array, $key ) {
		$results = array();

		foreach ( $array as $value ) {
			if ( array_key_exists( $key, $value = (array) $value ) ) {
				$results[] = $value[ $key ];
			}
		}
		$array = array_values( $results );

		return $results;
	}

	/**
	 * Forget segments within the array
	 *
	 * @since 1.0.0
	 *
	 * @param array $array
	 * @param string $key
	 */
	protected static function forget_segments( array &$array, $key ) {
		$parts = explode( '.', $key );
		while ( count( $parts ) > 1 ) {
			$part = array_shift( $parts );
			if ( isset( $array[ $part ] ) && is_array( $array[ $part ] ) ) {
				$array =& $array[ $part ];
			}
		}
		unset( $array[ array_shift( $parts ) ] );
	}

	/**
	 * Get() function callback for key dot notation walker
	 *
	 * @since 1.0.0
	 *
	 * @param array $array
	 * @param string $key
	 * @param bool $break
	 * @param array $args
	 *
	 * @return bool
	 */
	protected static function callback_get( array &$array, $key, &$break = false, $args = array() ) {
		if ( ! is_array( $array ) || ! array_key_exists( $key, $array ) ) {
			$break = true;

			return $args['default'];
		}

		$array = $array[ $key ];

		return $array;
	}

	/**
	 * Has() function callback for key dot notation walker
	 *
	 * @since 1.0.0
	 *
	 * @param array $array
	 * @param string $key_segment
	 * @param bool $break
	 *
	 * @return bool
	 */
	protected static function callback_has( array &$array, $key_segment, &$break = false ) {
		if ( ! array_key_exists( $key_segment, $array ) ) {
			$break = true;

			return false;
		}
		$array = $array[ $key_segment ];

		return true;
	}


	/**
	 * Is Valid Array() function callback for key dot notation walker
	 *
	 * @since 1.0.0
	 *
	 * @param array $array
	 * @param string $key
	 * @param bool $break
	 * @param array $args
	 *
	 * @return bool
	 */
	protected static function callback_is_array( array &$array, $key, &$break = false, $args ) {
		$is_valid = array_key_exists( $key, $array )
			? self::is_array_element_valid_array( $array, $key, $args['valid_if_not_empty'] )
			: false;

		if ( true === $is_valid ) {
			$array = $array[ $key ];

			return true;
		}

		$break = true;

		return false;
	}

	/**
	 * Checks if the array element, indicated by the key, is a valid array.
	 *
	 * @since 1.0.0
	 *
	 * @param array $array
	 * @param string $key
	 * @param bool $valid_if_not_empty
	 *
	 * @return bool
	 */
	protected static function is_array_element_valid_array( array $array, $key, $valid_if_not_empty = true ) {
		return is_array( $array[ $key ] ) && ( ! $valid_if_not_empty || ! empty( $array[ $key ] ) );
	}
}
