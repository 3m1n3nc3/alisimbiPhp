function fileSelected() {
  var file = document.getElementById('videoSource').files[0];
  if (file) {
    var kb = false;
    var fileSize = 0;
    var allowedSize = 6; //On production server change this value to maximum allowed upload size
    if (file.size > 1024 * 1024) {
      thisSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString();
      fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
    } else {
      var kb = true;
      fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
    }

    if (!kb && thisSize > allowedSize) {
      document.getElementById('upload_btn').removeAttribute("onclick");
      document.getElementById('upload_status').innerHTML = '<div id="notice" class="text-center font-weight-bold m-3 alert alert-danger">The selected file is too large and will not be uploaded, keep it below '+allowedSize+'MB</div>';
    } else {
      document.getElementById('upload_btn').setAttribute("onclick", "uploadFile()");
      document.getElementById('upload_status').innerHTML = "";
    }

    document.getElementById('fileName').innerHTML = 'Name: ' + file.name;
    document.getElementById('fileSize').innerHTML = 'Size: ' + fileSize;
    document.getElementById('fileType').innerHTML = 'Type: ' + file.type;
  }
}

function uploadFile() {
  var fd = new FormData();
  fd.append("videoSource", document.getElementById('videoSource').files[0]);
  fd.append("module_id", document.getElementById('module_id').value); 
  var xhr = new XMLHttpRequest();
  xhr.upload.addEventListener("progress", uploadProgress, false);
  xhr.addEventListener("load", uploadComplete, false);
  xhr.addEventListener("error", uploadFailed, false);
  xhr.addEventListener("abort", uploadCanceled, false);
  xhr.open("POST", siteUrl+'/connection/upload_video.php');
  xhr.send(fd);
}

function uploadProgress(evt) {
  if (evt.lengthComputable) {
    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
    var loader = '<div class="progress" id="loader_loading"><div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: '+percentComplete.toString()+'%" aria-valuenow="'+percentComplete.toString()+'" aria-valuemin="0" aria-valuemax="100"></div></div>';
    document.getElementById('progressNumber').innerHTML = loader;
  }
  else {
    document.getElementById('progressNumber').innerHTML = 'unable to compute';
  }
}

function uploadComplete(evt) {
  /* This event is raised when the server send back a response */
  // alert(evt.target.responseText);
  var resp, ret;
  resp = JSON.parse(evt.target.responseText);
  if (resp.status == 'success') {
    var alert = 'alert-success';
    document.getElementById('iframe_major').innerHTML = '<iframe src="'+siteUrl+'/uploads/videos/'+resp.rslt+'" width="280" height="210" style="border:none; background:gray;"></iframe>';
  } else if (resp.status == 'error') {
    var alert = 'alert-danger';
  }
  var x_loader = document.getElementById('loader_loading');
  x_loader.parentNode.removeChild(x_loader);
  document.getElementById('upload_status').innerHTML = '<div class="text-center font-weight-bold m-3 alert '+alert+'">'+resp.msg+'</div>';
}

function uploadFailed(evt) {
  alert("There was an error attempting to upload the file.");
}

function uploadCanceled(evt) {
  alert("The upload has been canceled by the user or the browser dropped the connection.");
}
