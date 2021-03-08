$('#myModal').on('shown.bs.modal', function() {
    $('#myInput').trigger('focus')
})
var loadFile = function(event) {
    var image = document.getElementById('output');
    image.src = URL.createObjectURL(event.target.files[0]);
    var profileimage = document.getElementById('profileimg');
    profileimage.src = URL.createObjectURL(event.target.files[0]);
    var coverimage = document.getElementById('coverimg');
    coverimage.src = URL.createObjectURL(event.target.files[0]);
};