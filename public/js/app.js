function deleteUser(id) {
    if (confirm('¿Desea continuar?')) {
        $.ajax({
        type: 'DELETE',
        url: '/admin/users/' + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        }).done(function(data) {
            window.location.reload();
        }).fail(function(data) {
            toastr.error(data.responseText);
        });
    }
}

function deleteChild(id) {
    if (confirm('¿Desea continuar?')) {
        $.ajax({
        type: 'DELETE',
        url: '/admin/children/' + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        }).done(function(data) {
            window.location.reload();
        }).fail(function(data) {
            toastr.error(data.responseText);
        });
    }
}

function deleteCategory(id) {
    if (confirm('¿Desea continuar?')) {
        $.ajax({
        type: 'DELETE',
        url: '/admin/categories/' + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        }).done(function(data) {
            window.location.reload();
        }).fail(function(data) {
            toastr.error(data.responseText);
        });
    }
}

function deleteTag(id) {
    if (confirm('¿Desea continuar?')) {
        $.ajax({
        type: 'DELETE',
        url: '/admin/tags/' + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        }).done(function(data) {
            window.location.reload();
        }).fail(function(data) {
            toastr.error(data.responseText);
        });
    }
}

function deleteVideo(id) {
    if (confirm('¿Desea continuar?')) {
        $.ajax({
        type: 'DELETE',
        url: '/admin/videos/' + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        }).done(function(data) {
            window.location.reload();
        }).fail(function(data) {
            toastr.error(data.responseText);
        });
    }
}

$('a.page-scroll').bind('click', function(event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top - 50)
    }, 1250, 'easeInOutExpo');
    event.preventDefault();
});