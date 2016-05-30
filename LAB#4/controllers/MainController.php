<?php

class MainController {

    public static function index( $params=array() ) {
        return miranda()->make('index', array(
            // Githun account news.
            'github' => Github::result( 5 ),
            // Show all articles.
            'articles'  =>  Articles::get_all_articles(),
        ));
    }

    public static function about() {
        return miranda()->make('about', array(
            // Githun account news.
            'github' => Github::result( 5 ),
        ));
    }

    public static function new_article() {
        Articles::add_new_article( $_POST['content'] );
    }

    public static function get_article_content() {
        $id = $_POST['id'];
        if( is_numeric( $id ) ) {
            return Articles::get_content( $id );
        }
    }

    public static function delete_article() {
        $id = $_POST['id'];
        if( is_numeric( $id ) ) {
            return Articles::delete( $id );
        }
    }

}
