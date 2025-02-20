<?php
/**
 * Template Name: Content Only Preview
 */

// get_header(); // Optional: include header if needed

// Get post ID from query parameter
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

if ($post_id) {
    $post = get_post($post_id);

    if ($post) {
        // Set up post data
        setup_postdata($post);
        // Output the post content only
        echo '<div class="post-content">';
        echo apply_filters('the_content', $post->post_content);
        echo '</div>';
        // Reset post data
        wp_reset_postdata();
    } else {
        echo '<p>Post not found.</p>';
    }
} else {
    echo '<p>No post ID provided.</p>';
}

// get_footer(); // Optional: include footer if needed
?>
