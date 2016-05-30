<?php

class Github {

    public $git;

    public static function result( $limit = 10 ) {
        if( ! isset( $git ) ) {
            $git = new Github;
        }

        // Get page source form github.
        $source = file_get_contents( $git->url() );
        // Get list of commits.
        $content = $git->get_list_of_commits( $source );
        $time = $git->get_commit_time( $source );

        $result = array();

        $step = 0;
        if( isset( $content[1] ) ) {
            for ($row = 0; $row < count( $content[1] ); $row++) {

                if( ($step + 1) > $limit ) { break; }

                if( ! preg_match( "#Merge branch#", $content[1][ $row ] ) ) {
                    $title = trim( $content[1][ $row ] );
                    $title = str_replace( '/mowshon', 'http://github.com/mowshon', $title );
                    $result[ $step ]['title'] = $title;
                    $result[ $step ]['time'] = strtotime( trim( $time[1][ $row ] ) );
                    $step += 1;
                }
            }
        }

        return $result;

    }

    public function url() {
        return 'https://github.com/mowshon/MIDPS/commits/master';
    }

    private function get_list_of_commits( $source ) {
        preg_match_all('#<p class="commit-title ">(.+?)</p>#si', $source, $matches);
        return $matches;
    }

    private function get_commit_time( $source ) {
        preg_match_all('#<time datetime="(.+?)" is="relative-time">#si', $source, $matches);
        return $matches;
    }

}