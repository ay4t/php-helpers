<?php

namespace Ay4t\Helper\Formatter;

/**
 * Array Helper Class
 * Contoh Penggunaan:
 * - HP::Array($array)->flatten()
 * - HP::Array($array)->groupBy('key')
 * - HP::Array($array)->pluck('field')
 * - HP::Array($array)->where('field', 'value')
 * - HP::Array($array)->sortBy('field')
 * - HP::Array($array)->unique()
 * - HP::Array($array)->chunk(2)
 */
class ArrayHelper implements \Ay4t\Helper\Interfaces\FormatterInterface
{
    private $array;

    /**
     * Set array yang akan diproses
     * 
     * @param array $array
     * @return self
     */
    public function set(array $array)
    {
        $this->array = $array;
        return $this;
    }

    /**
     * Mengubah array multi-dimensi menjadi array satu dimensi
     * 
     * @return array
     */
    public function flatten()
    {
        $result = [];
        array_walk_recursive($this->array, function($value) use (&$result) {
            $result[] = $value;
        });
        return $result;
    }

    /**
     * Mengelompokkan array berdasarkan key tertentu
     * 
     * @param string $key
     * @return array
     */
    public function groupBy($key)
    {
        $result = [];
        foreach ($this->array as $item) {
            $result[$item[$key]][] = $item;
        }
        return $result;
    }

    /**
     * Mengambil nilai dari key tertentu dalam array
     * 
     * @param string $field
     * @return array
     */
    public function pluck($field)
    {
        return array_map(function($item) use ($field) {
            return is_array($item) ? $item[$field] : $item->$field;
        }, $this->array);
    }

    /**
     * Mencari data dalam array berdasarkan kondisi
     * 
     * @param string $field
     * @param mixed $value
     * @return array
     */
    public function where($field, $value)
    {
        return array_filter($this->array, function($item) use ($field, $value) {
            return (is_array($item) ? $item[$field] : $item->$field) == $value;
        });
    }

    /**
     * Mengurutkan array berdasarkan key tertentu
     * 
     * @param string $field
     * @param string $direction asc|desc
     * @return array
     */
    public function sortBy($field, $direction = 'asc')
    {
        // Wrap array elements with their original keys to achieve a stable sort
        $indexedArray = array_map(function($key, $value) {
            return ['key' => $key, 'value' => $value];
        }, array_keys($this->array), $this->array);

        usort($indexedArray, function($a, $b) use ($field, $direction) {
            $valA = is_array($a['value']) ? $a['value'][$field] : $a['value']->$field;
            $valB = is_array($b['value']) ? $b['value'][$field] : $b['value']->$field;
            
            $comparison = 0;
            if ($direction === 'asc') {
                $comparison = $valA <=> $valB;
            } else {
                $comparison = $valB <=> $valA;
            }

            // If values are equal, use original key to maintain order
            if ($comparison === 0) {
                return $a['key'] <=> $b['key'];
            }
            
            return $comparison;
        });

        // Unwrap the array to return only the original values
        return array_map(function($item) {
            return $item['value'];
        }, $indexedArray);
    }

    /**
     * Menghapus nilai duplikat dalam array
     * 
     * @param string|null $field Jika diisi, akan menghapus duplikat berdasarkan field tertentu
     * @return array
     */
    public function unique($field = null)
    {
        if ($field === null) {
            return array_unique($this->array);
        }

        $seen = [];
        return array_filter($this->array, function($item) use ($field, &$seen) {
            $value = is_array($item) ? $item[$field] : $item->$field;
            if (in_array($value, $seen)) {
                return false;
            }
            $seen[] = $value;
            return true;
        });
    }

    /**
     * Membagi array menjadi beberapa bagian
     * 
     * @param int $size
     * @return array
     */
    public function chunk($size)
    {
        return array_chunk($this->array, $size);
    }

    /**
     * Mencari nilai dalam array (case-insensitive)
     * 
     * @param string $needle
     * @param string|null $field Jika diisi, akan mencari dalam field tertentu
     * @return array
     */
    public function search($needle, $field = null)
    {
        $needle = strtolower($needle);
        return array_filter($this->array, function($item) use ($needle, $field) {
            if ($field !== null) {
                $value = is_array($item) ? $item[$field] : $item->$field;
            } else {
                $value = $item;
            }
            return str_contains(strtolower($value), $needle);
        });
    }

    /**
     * Mengubah array menjadi string dengan delimiter tertentu
     * 
     * @param string $delimiter
     * @param string|null $field Jika diisi, akan mengambil nilai dari field tertentu
     * @return string
     */
    public function implode($delimiter = ',', $field = null)
    {
        if ($field !== null) {
            $array = $this->pluck($field);
        } else {
            $array = $this->array;
        }
        return implode($delimiter, $array);
    }

    /**
     * Get the result of the formatting.
     *
     * @return array
     */
    public function getResult()
    {
        return $this->array;
    }
}
