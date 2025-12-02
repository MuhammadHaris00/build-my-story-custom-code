<?php
/*
 * Plugin Name:       BuildMyStory Custom Code
 * Description:       Additional PHP Hooks and Shortcodes for the buildmystory.com
 * Version:           1.0.0
 * Author:            Muhammad Haris
 * Text Domain:       buildmystory-custom-domain
 * Domain Path:       /languages
 */

//  Shortcode for Rendering Projects Resources Grid
function shortcode_pdf_resources_grid() {
    global $post;

    if ( ! function_exists('get_field') || ! $post ) return '';

    $resources = get_field('resources', $post->ID);
    if ( empty($resources) ) return '<p>No PDFs found.</p>';

    $output = '<div class="hrs-pdf-grid">';

    foreach ( $resources as $item ) {
        $file = $item['resource'];

        if ( empty($file) || empty($file['url']) ) {
            continue;
        }

        $ext = strtolower(pathinfo($file['url'], PATHINFO_EXTENSION));

        // Allow both PDF and PPTX files
        if ( ! in_array($ext, ['pdf', 'pptx'], true) ) {
            continue;
        }

        // Use custom thumbnail if available
        if ( ! empty($item['thumbnail_image']) ) {
            $thumb = wp_get_attachment_image_url( $item['thumbnail_image']['ID'], 'medium' );
        } else {
            // Otherwise, try to get the file’s own thumbnail
            $thumb = wp_get_attachment_image_url( $file['ID'], 'medium' );
        }

        // Fallback icons
        if ( ! $thumb ) {
            if ( $ext === 'pptx' ) {
                $thumb = '/wp-content/uploads/2025/11/pptx-logo.png';
            } else {
                $thumb = 'https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg';
            }
        }

        $output .= '<div class="hrs-pdf-item">';
        $output .= '<a href="' . esc_url($file['url']) . '" target="_blank" rel="noopener">';
        $output .= '<img src="' . esc_url($thumb) . '" alt="' . esc_attr($file['title']) . '" class="hrs-pdf-thumb" />';
        $output .= '</a>';
        $output .= '<div class="hrs-pdf-name">' . esc_html($file['title']) . '</div>';
        $output .= '</div>';
    }

    $output .= '</div>';

    return $output;
}
add_shortcode('pdf_resources_grid', 'shortcode_pdf_resources_grid');


// Shortcode for rendering Student's Work (Books) for Projects

function shortcode_student_work_loop() {
    global $post;
    if ( ! $post ) return '';

    // 1. Get current program post ID
    $current_post_id = $post->ID;

    // 2. Get related books/posts from ACF Post Object field 'student_work'
    $related_posts = get_field('student_work', $current_post_id);

    // 3. Return message if no related posts
    if ( empty($related_posts) ) {
        return '<p>No related works found.</p>';
    }

    // 4. Normalize to array
    $related_posts = is_array($related_posts) ? $related_posts : [$related_posts];

    // 5. Start HTML output buffering
    ob_start();
    echo '<div class="student-work-grid">';

    foreach ( $related_posts as $related ) {
        $related_id = is_object($related) ? $related->ID : (int) $related;

        $title       = get_the_title($related_id);
        $link        = get_permalink($related_id);
        $thumbnail   = get_the_post_thumbnail($related_id, 'medium');
        $made_by     = get_field('made_by', $related_id); // custom field from ACF

        ?>
        <div class="student-work-item">
            <a href="<?php echo esc_url($link); ?>">
                <div class="student-work-content">
                    <h3 class="student-work-title"><?php echo esc_html($title); ?></h3>
                    <?php if ( $made_by ) : ?>
                        <p class="student-work-madeby"><?php echo esc_html($made_by); ?></p>
                    <?php endif; ?>
                </div>
                <div class="student-work-thumb">
                    <?php echo $thumbnail ?: '<div class="no-thumb"></div>'; ?>
                </div>
            </a>
        </div>
        <?php
    }

    echo '</div>';
    return ob_get_clean();
}
add_shortcode('student_work_loop', 'shortcode_student_work_loop');


?>