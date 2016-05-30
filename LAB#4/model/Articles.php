<?php

class Articles {

    public static function get_all_articles() {
        $articles = array();
        $files = glob( Config::get( 'project.articles_files' ) . '*.php' );

        if( count( $files ) ) {
            $step = 0;
            foreach( $files as $article ) {
                $content = json_decode( file_get_contents( $article ), true);
                if( isset( $content['title'] ) ) {
                    $articles[$step] = $content;
                    $step += 1;
                }
            }
        }

        return $articles;
    }

    public static function get_last_id() {
        $last = 1;
        $files = glob( Config::get( 'project.articles_files' ) . '*.php' );
        if( count( $files ) ) {
            foreach ($files as $article) {
                $parts = explode( '/', $article );
                $filename = $parts[ count( $parts ) - 1 ];
                $num = (int) str_replace('.php', '', $filename);
                if( $num > $last ) {
                    $last = $num;
                }
            }
        }
        return $last;
    }

    public static function add_new_article( $json_data ) {
        $data = json_decode( $json_data, true );
        $last_id = self::get_last_id() + 1;
        $filename = Config::get( 'project.articles_files' ) . "{$last_id}.php";
        file_put_contents($filename, json_encode(
            array(
                'id'    =>  $last_id,
                'title' =>  $data[0],
                'author'    =>  $data[1],
                'text'  =>  $data[2],
                'unix'  => time(),
            )
        ));
    }

    public static function get_content( $article_id ) {
        $filename = Config::get( 'project.articles_files' ) . "{$article_id}.php";
        $content = json_decode( file_get_contents( $filename ), true);
        if( isset( $content['text'] ) ) {
            return $content['text'];
        } else {
            return '';
        }
    }

    public static function delete( $article_id ) {
        $filename = Config::get( 'project.articles_files' ) . "{$article_id}.php";
        @unlink( $filename );
    }

}