<?php

return array (
    'singular' => 'User',
    'plural' => 'Users',
    'list' => 'Users',
    'create' => 'User',
    'view' => 'View Details',
    'edit' => 'Edit User',
    'fields' =>
        array (
            'id' => 'Id',
            'title' => 'Title',
            'slug' => 'Slug',
            'short_description' => 'Short Description',
            'description' => 'Description',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ),
    'messages' =>
        array (
            'not_found' => 'User not found.',
            'confirm_delete' => 'Are you sure?',
            'create_success' => 'User Created successfully.',
            'update_success' => 'User updated successfully.',
            'delete_success' => 'User deleted successfully.',
            'create_error' => "Can't create this user.",
            'update_error' => "Can't update this user.",
            'delete_error' => "Can't delete this user.",
            'profile_success' => "Profile details updated successfully.",
            'password_invalid' => "Current Password is Invalid.",
            'current_password_invalid' => "New Password cannot be same as your current password.",
            'password_success' => "Profile details updated successfully."
        ),
);
