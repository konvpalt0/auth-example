let form = document.getElementById('userSettings');

// $(form).on('submit', function(event) {
//     event.preventDefault();
//
//     let formData = new FormData(form);
//     let attributes = {};
//
//     formData.forEach( function(value, key) {
//         attributes[key] = value;
//     });
//
//     $.post(`/api/users/${attributes.uuid}`, attributes, function() {console.log('ok')});
//
//     document.location.reload();
// });