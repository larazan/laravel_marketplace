<?php

namespace App;

use Darryldecode\Cart\CartCollection;

use App\Models\DatabaseStorage;

class DBStorage {

    public function has($key)
    {
        return DatabaseStorage::find($key);
    }
    
    
    public function get($key)
    {
        if($this->has($key))
        {
            return new CartCollection(DatabaseStorage::find($key)->wishlist_data);
        }
        else
        {
            return [];
        }
    }
    
    
    public function put($key, $value)
    {
        if($row = DatabaseStorage::find($key))
        {
            // update
            $row->wishlist_data = $value;
            $row->save();
        }
        else
        {
            DatabaseStorage::create([
                'id' => $key,
                'wishlist_data' => $value
            ]);
        }
    }
    
    
    }