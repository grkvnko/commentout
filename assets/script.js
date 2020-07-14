let pageNum = 1;

function loadPage(pageNum) {
    $.ajax({
        url: '/Comments/getCommentsPage',
        method: 'POST',
        data: { page: pageNum },
        datatype: 'json',
        success: function(data) {
            var result = jQuery.parseJSON( data );
            $(".comments__wrap").empty();

            console.log(data);

            $.each(result.items, function (index, item) {
                newComment = $("<div>").addClass("comments__body");
                newComment.append($("<h3>").addClass("comment__title").text(item.title))
                    .append($("<div>").addClass("comment__body").text(item.comment))
                    .append(
                        $("<div>").addClass("comment__autor")
                            .append('<span class="comment__name">'+item.name+'</span><span class="comment__date">'+item.date+'</span>')
                    );
                $(".comments__wrap").append(newComment);
            });

            pagination = $('<ul>').addClass("pagination justify-content-center");
            pagination.append($('<li>').addClass("page-item disabled").append("<span class='page-link'>Страницы:</span>"));
            for(i = 1; i <= result.pagesCount; i++) {
                isCurrent = (i===pageNum)?'active':'';
                paginationItemA = $('<a>').addClass("page-link").attr("href", "?page=" + i).attr("data-pagenum", i).text(i);
                paginationItemSpan = $('<span>').addClass("page-link").text(i);
                paginationItemEl = (i===pageNum)?paginationItemSpan:paginationItemA;
                paginationItem = $('<li>').addClass("page-item "+isCurrent).append(paginationItemEl);
                pagination.append(paginationItem);
            }
            $("#paginator").empty().append(pagination);
        },
        error: function (jqXHR, exception) {
            console.log(jqXHR);
        }
    });
}

$("#commentForm").submit(function(e) {
    e.preventDefault();
    form = $(this);
    let data = $('form').serializeArray();
    $.ajax({
        type: "POST",
        url: '/Comments/storeNewComment',
        data: data,
        success: function(data)
        {
            console.log(data);
            if (data === 'novalid') {
                alert('Одно из полей не заполнено или заполнено неверно!');
            } else if (data === 'ok') {
                form[0].reset();
                loadPage(1);
            }
        }
    });
});

$("#paginator").on('click', 'a.page-link', function (e) {
    e.preventDefault();
    pageNum = $(this).data("pagenum");
    loadPage( pageNum );
});