!function ($) {

  $(function(){

    var $window = $(window)
    var $body   = $(document.body)

    var navHeight = $('.navbar').outerHeight(true) + 10


    // make code pretty
    window.prettyPrint && prettyPrint()

    $('.bs-docs-container [href=#]').click(function (e) {
      e.preventDefault()
    })

    $body.on('click', '.bs-sidenav [href^=#]', function (e) {
      var $target = $(this.getAttribute('href'))

      e.preventDefault() // prevent browser scroll

      $window.scrollTop($target.offset().top)
    })

    // tooltip demo
    $('.tooltip-demo').tooltip({
      selector: "[data-toggle=tooltip]"
    })

    $('.tooltip-test').tooltip()
    $('.popover-test').popover()

    $('.bs-docs-navbar').tooltip({
      selector: "a[data-toggle=tooltip]",
      container: ".bs-docs-navbar .nav"
    })

    // popover demo
    $("[data-toggle=popover]")
      .popover()

    // button state demo
    $('#fat-btn')
      .click(function () {
        var btn = $(this)
        btn.button('loading')
        setTimeout(function () {
          btn.button('reset')
        }, 3000)
      })


    // javascript build logic
    var inputsComponent = $("#less input")
      , inputsPlugin = $("#plugins input")
      , inputsVariables = $("#less-variables input")

    // toggle all plugin checkboxes
    $('#less .toggle').on('click', function (e) {
      e.preventDefault()
      inputsComponent.prop('checked', !inputsComponent.is(':checked'))
    })

    $('#plugins .toggle').on('click', function (e) {
      e.preventDefault()
      inputsPlugin.prop('checked', !inputsPlugin.is(':checked'))
    })

    $('#less-variables .toggle').on('click', function (e) {
      e.preventDefault()
      inputsVariables.val('')
    })

    // request built javascript
    $('.bs-customize-download .btn').on('click', function (e) {
      e.preventDefault()

      var css = $("#less input:checked")
            .map(function () { return this.value })
            .toArray()
        , js = $("#plugins input:checked")
            .map(function () { return this.value })
            .toArray()
        , vars = {}

      $("#less-variables input")
        .each(function () {
          $(this).val() && (vars[ $(this).prev().text() ] = $(this).val())
      })

      $.ajax({
        type: 'POST'
      , url: /localhost/.test(window.location) ? 'http://localhost:9001' : 'http://bootstrap.herokuapp.com'
      , dataType: 'jsonpi'
      , params: {
          js: js
        , css: css
        , vars: vars
      }
      })
    })
  })

// Modified from the original jsonpi https://github.com/benvinegar/jquery-jsonpi
$.ajaxTransport('jsonpi', function(opts, originalOptions, jqXHR) {
  var url = opts.url;

  return {
    send: function(_, completeCallback) {
      var name = 'jQuery_iframe_' + jQuery.now()
        , iframe, form

      iframe = $('<iframe>')
        .attr('name', name)
        .appendTo('head')

      form = $('<form>')
        .attr('method', opts.type) // GET or POST
        .attr('action', url)
        .attr('target', name)

      $.each(opts.params, function(k, v) {

        $('<input>')
          .attr('type', 'hidden')
          .attr('name', k)
          .attr('value', typeof v == 'string' ? v : JSON.stringify(v))
          .appendTo(form)
      })

      form.appendTo('body').submit()
    }
  }
})

}(window.jQuery)


$(document).ready(function(){
  $('#popover').popover({
      trigger: 'click',
      placement: 'bottom',
      html: true,
      container: 'body',
      animation: 'false',
      content: function() { return $('#openmllinks').html(); }
  });
  $('#popover2').popover({
      trigger: 'click',
      placement: 'bottom',
      html: true,
      container: 'body',
      animation: 'false',
      content: $('#sociallinks')
  });
  $('#popover').on('shown.bs.popover', function () {
     $('.popover').css('left','inherit')
     $('.popover').css('right','10px')
     $('.arrow').css('left','inherit')
     $('.arrow').css('right','10px')
  })
  $('#popover2').on('shown.bs.popover', function () {
     $('.popover').css('left','inherit')
     $('.popover').css('right','10px')
     $('.arrow').css('left','inherit')
     $('.arrow').css('right','55px')
     $('#sociallinks').css('display','block')
  })
  $('#popover2').on('hide.bs.popover', function () {
     $('body').append($('#sociallinks'))
     $('#sociallinks').css('display','none')
  })
});
$(document).click(function (e) {
    $('#popover').each(function () {
  if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
      if ($(this).data('bs.popover').tip().hasClass('in')) {
    $(this).popover('toggle');
      }
      return;
  }
    });
    $('#popover2').each(function () {
  if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
      if ($(this).data('bs.popover').tip().hasClass('in')) {
    $(this).popover('toggle');
      }
      return;
  }
    });
});
$('body').on('hidden.bs.modal', '.modal', function () {
  $(this).removeData('bs.modal');
});
