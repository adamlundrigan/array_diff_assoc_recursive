<?php
namespace Ldc;

function array_diff_assoc_recursive(array $a, array $b)
{
    $diff = [];

    $aKeys = array_keys($a);
    $bKeys = array_keys($b);

    // Calculate the key differences between the two arrays
    $diffKeys = array_unique(array_merge(
        array_diff($aKeys, $bKeys),
        array_diff($bKeys, $aKeys)
    ));
    $sameKeys = array_unique(array_merge(
        array_intersect($aKeys, $bKeys),
        array_intersect($bKeys, $aKeys)
    ));

    // Iterate over all the keys that both arrays have and run them
    foreach ( $sameKeys as $k ) {
        if ( !is_array($a[$k]) || !is_array($b[$k]) ) {
            if ($a[$k] === $b[$k]) {
                continue;
            }
            $diff[$k] = [$a[$k], $b[$k]];
            continue;
        }

        $subdiff = array_diff_assoc_recursive($a[$k], $b[$k]);
        if (empty($subdiff)) {
            continue;
        }
        $diff[$k] = $subdiff;
    }

    // If both arrays have the same keys at this level
    // our work is already done!
    if ( empty($diffKeys) ) {
        return $diff;
    }

    // Iterate over all the keys that are in one array or the other
    // and patch in the entire sub-array from that array
    foreach ( $diffKeys as $k ) {
        $diff[$k] = isset($a[$k]) ? $a[$k] : $b[$k];
    }

    return $diff;
}
