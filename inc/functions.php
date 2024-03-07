<?php 
/**
 * class Wdevs_Related_Posts_Widget
 */
if ( ! class_exists( 'Wdevs_Related_Posts_Widget' ) ) {
    class Wdevs_Related_Posts_Widget {
        public function __construct(){
            add_filter('the_content', array($this, 'related_post_below_content'));
        }

        /**
         * Related posts widget function 
         */
        public function related_post_below_content($content){

            // get the categories 
            $categories = get_the_category();

            // assign empty array of ids 
            $cat_ids = array();

            // loop for the category ids 
            foreach($categories as $category){
                // push or store the single category id to cat_ids variable 
                array_push($cat_ids, $category->term_id);
            }

            // query arguments 
            $q_args = array(
                'post_type' => 'post',
                'posts_per_page' => 5,
                'category__in' => $cat_ids,
                'orderby' => 'rand'
            );

            // instantiate wp_query class 
            $the_query = new WP_Query( $q_args );

            // check condition if have posts 
            if ( $the_query->have_posts() ) :

                // starting related post content 
                $related_posts = '<div class="wdevs_related_posts_wrap">';
                $related_posts .= '<h2>' . __('Related Posts', 'wdevs') . '</h2>';
                $related_posts .= '<ul class="wdevs_related_posts">';

                // loop for the posts based on query 
                while ( $the_query->have_posts() ) : $the_query->the_post();
                    $related_posts .= '<li><a href="' . esc_attr( get_the_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
                endwhile;

                // reset post query
                wp_reset_postdata();

                // end of related post
                $related_posts .= '</ul>';
                $related_posts .= '</div>';

                // insert related posts widget with the main content 
                $content =  $content . $related_posts;

            endif;

            // return the modified content 
            return $content;
        }

    }

    // instantiate class Wdevs_Related_Posts_Widget
    new Wdevs_Related_Posts_Widget();
}
