@layout(main)

@section(content)
<div class="articles">
  @begin foreach( $articles as $id => $row )
  <div class="article-{{ $row['id'] }}">
    <h1>{{ $row['title'] }}</h1>
    <p><b>Added:</b> {{ date( 'j M, H:i:s', $row['unix'] ) }} <b>by</b> {{ $row['author'] }}</p>
    <h2>[ <a href="#" class="delete-me" data-id="{{ $row['id'] }}">delete this article</a> ] [ <a href="#" class="article-status" data-id="{{ $row['id'] }}">show article</a> ]</h2>
    <div class="article-{{ $row['id'] }}-content"></div>
  </div>
  @end
</div>

<div class="new-article hide">
  <h1>Create new article</h1>

  <p>
    <b>Title</b>:<br>
    <input type="text" name="title">
  </p>

  <p>
    <b>Author</b>:<br>
    <input type="text" name="author">
  </p>

  <p>
    <b>Title</b>:<br>
    <textarea name="text"></textarea>
  </p>

  <button class="create-article">Create new</button>

</div>
@section_end