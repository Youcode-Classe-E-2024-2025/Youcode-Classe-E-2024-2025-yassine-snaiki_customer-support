<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAll()
    {
        // Retrieving all users with pagination
        return User::paginate(10);
    }

    public function update(User $user, $data)
    {
        // Updating the user details
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        // Deleting the user
        $user->delete();
        return ['message' => 'User deleted successfully'];
    }
}
