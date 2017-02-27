$('#twitter').sharrre({
  share: {
    twitter: true
  },
  enableHover: false,
  enableTracking: false,
  click: function(api, options){
    api.simulateClick();
    api.openPopup('twitter');
  }
});
$('#facebook').sharrre({
  share: {
    facebook: true
  },
  enableHover: false,
  enableTracking: false,
  click: function(api, options){
    api.simulateClick();
    api.openPopup('facebook');
  }
});
$('#linkedin').sharrre({
  share: {
    linkedin: true
  },
  enableHover: false,
  enableTracking: false,
  click: function(api, options){
    api.simulateClick();
    api.openPopup('linkedin');
  }
});
$('#pinterest').sharrre({
  share: {
    pinterest: true
  },
  enableHover: false,
  enableTracking: false,
  click: function(api, options){
    api.simulateClick();
    api.openPopup('pinterest');
  }
});

$('#googleplus').sharrre({
  share: {
    googlePlus: true
  },
  urlCurl: 'frontend/page/share/sharrre.php',
  enableHover: false,
  enableTracking: false,
  click: function(api, options){
    api.simulateClick();
    api.openPopup('googlePlus');
  }
});
