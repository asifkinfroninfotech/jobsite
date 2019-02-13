           


            Dropzone.options.profileImage = {
              maxFilesize: 3,
              acceptedFiles: '.jpg, .jpeg, .png, .bmp',
              init: function() {
                this.on('success', function() {
                  if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                         location.reload();
                     }
                  });
              }
            };

            Dropzone.options.coverImage = {
              maxFilesize: 3,
              acceptedFiles: '.jpg, .jpeg, .png, .bmp',
              init: function() {
                this.on('success', function() {
                  if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                        location.reload();
                     }
                  });
              }
            };

            Dropzone.options.myVideo = {
              maxFilesize: 3,
              acceptedFiles: '.mp4',
              init: function() {
                this.on('success', function() {
                  if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                       location.reload();
                     }
                  });
              }
            };

           
           
   
   