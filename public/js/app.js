function deleteUser(id) {
    if (confirm('¿Desea continuar?')) {
        $.ajax({
        type: 'DELETE',
        url: '/users/' + id,
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
        url: '/children/' + id,
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
        url: '/categories/' + id,
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
        url: '/tags/' + id,
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