$( document ).ready(function() {

    // Add new Article.
    $('.add_new_article').on( 'click', function() {
        $('.articles').addClass('hide');
        $('.new-article').removeClass('hide');
    } );

    // Add new Article.
    $('.create-article').on( 'click', function() {
        var title = $('input[name=title]').val();
        var author = $('input[name=author]').val();
        var text = $('textarea').val();

        if( ! title ) { alert( 'Title is empty!' ); return; }
        if( ! author ) { alert( 'Author is empty!' ); return; }
        if( ! text ) { alert( 'Text is empty!' ); return; }

        $.ajax({
            type: 'POST',
            url: '/home/new_article',
            data: 'content=' + JSON.stringify( [title, author, text] ),
            success: function(data){
                // Success!
                alert( 'Article was created with success!' );
                $('input[type=text]').val('');
                $('textarea').val('');
            }
        });
    });

    // Show article content.
    $('.article-status').on( 'click', function() {
        var article_id = $(this).data('id');

        if( 'show article' == $(this).text() ) {
            $(this).text('hide content')
            // Get article content with json.
            $.ajax({
                type: 'POST',
                url: '/home/get_article_content',
                data: 'id=' + article_id,
                success: function(data){
                    $('.article-' + article_id + '-content').removeClass('hide');
                    $('.article-' + article_id + '-content').text( data );
                }
            });
        } else {
            $(this).text('show article')
            $('.article-' + article_id + '-content').addClass('hide');
        }
    });

    // Delete article.
    $('.delete-me').on( 'click', function() {
        var article_id = $(this).data('id');
        var agree = confirm( "Do you really want to delete this article?" );
        if( agree ) {
            $.ajax({
                type: 'POST',
                url: '/home/delete_article',
                data: 'id=' + article_id,
                success: function(data){
                    $('.article-' + article_id).addClass('hide');
                    alert( "Article with ID:" + article_id + " is gone." );
                }
            });
        }
    });

});