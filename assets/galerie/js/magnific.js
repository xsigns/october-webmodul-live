$('.magnific').magnificPopup({
  delegate: 'a',
  type: 'image',
  tLoading: 'Loading image #%curr%...',
  mainClass: 'mfp-img-mobile',
    tCounter: '%curr% von %total%',
    tPrev: 'Previous (Left arrow key)',
    tNext: 'Next (Right arrow key)',
  gallery: {
    enabled: true,
    navigateByImgClick: true,
    preload: [0,1], // Will preload 0 - before current, and 1 after the current image

  },

  image: {
    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
    titleSrc: function(item) {
      return item.el.children()[0].attributes['title'].value + '<small>' + item.el.children()[0].attributes['alt'].value + '</small>';
    }
  }
});
