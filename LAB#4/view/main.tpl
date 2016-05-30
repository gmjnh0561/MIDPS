<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>{{ Config::get('project.header_title') }}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/view/css/1.css" type="text/css" media="screen,projection" />
    <script type="text/javascript" src="/view/js/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="/view/js/main.js"></script>
</head>
<body>
<div id="container">
    <div id="header">
        <h1>{{ Config::get('project.header_title') }}</h1>
        <h2>{{ Config::get('project.header_slogan') }}</h2>
        <ul id="nav">
            <li><a href="/" class="home">Home</a></li>
            <li><a href="#" class="add_new_article">Add new article</a></li>
            <li><a href="/home/about">About</a></li>
        </ul>
    </div>
    <div id="sidebar">
        <h1>Github news</h1>
        <p>
            @begin foreach( $github as $id => $row )
            <b>{{ $row['title'] }}</b><br>
            <i>{{ date( 'j M, H:i:s', $row['time'] ); }}</i><br><br>
            @end
        </p>
    </div>
    <div id="content">
        @view_section(content)
    </div>
</div>
</div>
</html>
