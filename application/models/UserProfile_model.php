<?php
class UserProfile_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Create a new profile for a user
    public function createProfile($profileData) {
        return $this->db->insert('user_profiles', $profileData); // INSERT INTO user_profiles (user_id, education, phone_number, ...) VALUES (?, ?, ?, ...)
    }

    // Get the profile of a specific user
    public function getProfile($userId, $authId) {
        $this->db->select('user_profiles.*');
        $this->db->from('user_profiles');
        $this->db->join('users', 'users.user_id = user_profiles.user_id');
        $this->db->where('user_profiles.user_id', $userId);
        $this->db->where('users.auth_id', $authId); // Ensure the auth_id matches
        $query = $this->db->get();

        return $query->row_array(); // SELECT * FROM user_profiles WHERE user_id = ? AND auth_id = ?
    }

    // Update profile information
    public function updateProfile($userId, $authId, $profileData) {
        // Check if the user belongs to the logged-in user's auth_id
        $this->db->select('user_id');
        $this->db->from('users');
        $this->db->where('user_id', $userId);
        $this->db->where('auth_id', $authId); // Ensure the auth_id matches
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            // User exists and belongs to the logged-in user, so proceed with the update
            $this->db->where('user_id', $userId);
            $this->db->update('user_profiles', $profileData);
    
            // Return whether the update was successful
            return $this->db->affected_rows() > 0;
        } else {
            // If no matching user found, return false
            return false;
        }
    }
    
    

    // Delete a profile
    public function deleteProfile($userId, $authId) {
        $this->db->where('user_id', $userId);
        $this->db->where('user_id IN (SELECT user_id FROM users WHERE auth_id = ?)', $authId); // Ensure auth_id matches
        $this->db->delete('user_profiles'); // DELETE FROM user_profiles WHERE user_id = ? AND auth_id = ?

        return $this->db->affected_rows() > 0;
    }
}
?>
