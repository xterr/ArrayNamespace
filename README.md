ArrayNamespace
==============

Thank you for chosing ArrayNamespace! ArrayNamespace makes your job easier when dealing with arrays.
You don`t have to worry about initializing keys when in strict mode or have to first set a value for increment operations.

Usage
-----

    $oMap = new ArrayNamespace;
    $oMap->set('key1.key2.key3', 10);
    $oMap->get('key1.key2.key3'); -> 10 or NULL is the key doesn`t exist
    $oMap->increment('key1.key2.key3', 1) // second parament is the increment step or value

    $oMap->sort('key1.key2', 'key3', TRUE); Order specific key by a field, ascending or descending
    $oMap->toArray(); Will create and return an associative array
  
Known bugs
----------

Currently sorting works only on numeric values
