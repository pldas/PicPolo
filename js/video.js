// Resize the video elements so that we don't get any borders due to aspect ratio
function resizeVideo() {
  if ($(window).height() > $(window).width() * 0.5425) { // Which dimension is bigger dependant on aspect ratio (16:9)
    $("video").removeAttr("height").removeAttr("width").width("auto").height("100%");
  }
  else {
    $("video").removeAttr("height").removeAttr("width").width("100%").height("auto");
  }
};


// Add the resize function to the window resize event but put it on a short timer as to not call it too often
var resizeTimer;
$(window).resize(function () {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(resizeVideo, 150);
});