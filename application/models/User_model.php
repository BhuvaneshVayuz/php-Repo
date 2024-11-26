<?php
class User_model extends CI_model {
    
    // Create a new user (ensure the logged-in user's auth_id is used)
    function create($formArray, $authId) {
        // Add auth_id to the form data
        $formArray['auth_id'] = $authId;
        $this->db->insert("users", $formArray); // INSERT INTO users (name,email,created,auth_id) values (?, ?, ?, ?);
    }

    // Get all users, but only those with the same auth_id as the logged-in user
    function all($authId) {
        $this->db->where('auth_id', $authId); // Filter by auth_id
        return $users = $this->db->get('users')->result_array(); // SELECT * from users WHERE auth_id = ?
    }

    // Get a specific user by user_id, but only if they have the same auth_id as the logged-in user
    function getUser($userId, $authId) {
        $this->db->where('user_id', $userId);
        $this->db->where('auth_id', $authId); // Ensure that the auth_id matches
        return $user = $this->db->get('users')->row_array(); // SELECT * FROM users WHERE user_id = ? AND auth_id = ?
    }

    // Update a user's details, but only if the user belongs to the logged-in user's auth_id
    function updateUser($userId, $formArray, $authId) {
        $this->db->where('user_id', $userId);
        $this->db->where('auth_id', $authId); // Ensure the auth_id matches
        $this->db->update('users', $formArray); // UPDATE users SET name = ?, email = ? WHERE user_id = ? AND auth_id = ?

        // Check if the update was successful
        $this->db->where('user_id', $userId);
        $this->db->where('auth_id', $authId);
        $query = $this->db->get('users');

        if ($query->num_rows() == 0) {
            return false;  // User not found or doesn't belong to this auth_id
        }
        if ($this->db->affected_rows() == 0) {
            return false;  // No changes were made
        }
        return true;
    }

    // Delete a user, but only if the user belongs to the logged-in user's auth_id
    function deleteUser($userId, $authId) {
        $this->db->where('user_id', $userId);
        $this->db->where('auth_id', $authId); // Ensure the auth_id matches
        $this->db->delete('users'); // DELETE FROM users WHERE user_id = ? AND auth_id = ?
    }
}
?>
