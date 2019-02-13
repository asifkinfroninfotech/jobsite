/*
 * Drop Zone Script for auto refresh
 */

//Dropzone.autoDiscover = false;

/*$('.dropzone').each(function(){
    var options = $(this).attr('id').split('-');
    $(this).dropzone({
        
        maxFiles: 1,
        init: function() {
                this.on('success', function() {
                  if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                         location.reload();
                     }
                  });
              }
        });
});*/

/*
 *  Script to fill states combo on the basis of country Section
 */

$(document).ready(function () {
    $('#country').change(function () {
        var countryID = $(this).val();
        if (countryID) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "/api/get-state-list",
                data: {
                    'country_id': countryID
                },
                success: function (res) {
                    if (res) {
                        $("#state").empty();
                        $("#state").append('<option>Select</option>');
                        $.each(res, function (key, value) {
                            $("#state").append('<option value="' + value.stateid + '">' + value.name + '</option>');
                        });

                    } else {
                        $("#state").empty();
                    }
                },
                error: function (res) {
                    console.log(res);
                },
            });
        } else {
            $("#state").empty();

        }
    });
});




Dropzone.options.profileImage = {
    maxFilesize: 10,
    maxFiles: 1,
    acceptedFiles: '.jpg, .jpeg, .png, .bmp',
    init: function () {
        this.on('success', function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
    }
};









Dropzone.options.uploadgalleryimages = {
    maxFilesize: 10,
    maxFiles: 5,
    acceptedFiles: '.jpg, .jpeg, .png, .bmp',
    init: function () {
        this.on('success', function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
    }
};



Dropzone.options.uploadgalleryvideos = {
    maxFilesize: 100,
    maxFiles: 5,
    acceptedFiles: '.mp4',
    init: function () {
        this.on('success', function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
    }
};


var maxImageWidth = 200,
    maxImageHeight = 200;

Dropzone.options.uploadgallerythumbnail = {
    maxFilesize: 10,
    maxFiles: 1,
    acceptedFiles: '.jpg, .jpeg, .png, .bmp',
    addRemoveLinks: true,
    init: function () {

        this.on('success', function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
        this.on("thumbnail", function (file) {

            if (file.width > maxImageWidth || file.height > maxImageHeight) {
                file.rejectDimensions()
            } else {
                file.acceptDimensions();
            }
        });
    },
    accept: function (file, done) {
        file.acceptDimensions = done;
        file.rejectDimensions = function () {
            $('.dz-progress').hide();
            $("#errolbl").html("Thumbnail width and height must be less than 200 * 200 dimensions");
            setTimeout(function () {
                $("#errolbl").html(" ");

            }, 3000);

        };
    }
};






Dropzone.options.coverImage = {
    maxFilesize: 10,
    maxFiles: 1,
    acceptedFiles: '.jpg, .jpeg, .png, .bmp',
    init: function () {
        this.on('success', function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
    }
};

Dropzone.options.tenantimage = {
    maxFilesize: 10,
    maxFiles: 1,
    acceptedFiles: '.jpg, .jpeg, .png, .bmp',
    init: function () {
        this.on('success', function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
    }
};


Dropzone.options.minilogoimage = {
    maxFilesize: 10,
    maxFiles: 1,
    acceptedFiles: '.jpg, .jpeg, .png, .bmp',
    init: function () {

        this.on('success', function () {

            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
    }
};




Dropzone.options.myVideo = {
    maxFilesize: 100,
    maxFiles: 1,
    acceptedFiles: '.mp4',
    init: function () {
        this.on('success', function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
    }
};


Dropzone.options.myawesomedropzone = {
    maxFilesize: 100,
    maxFiles: 1,
    acceptedFiles: '.mp4',
    init: function () {
        this.on('success', function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
    }
};


Dropzone.options.uploadFilesPublic = {
    maxFilesize: 10,
    maxFiles: 5,
    acceptedFiles: '.mp4, .jpg, .xls, .xlsx, .pdf, .docx',
    init: function () {
        this.on('success', function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
    }
};

Dropzone.options.uploadFilesPrivate = {
    maxFilesize: 10,
    maxFiles: 5,
    acceptedFiles: '.mp4, .jpg, .xls, .xlsx, .pdf, .docx',
    init: function () {
        this.on('success', function () {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                location.reload();
            }
        });
    }
};