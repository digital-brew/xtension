$(document).ready(function() {
  wrapAdminContent()
  removeFooter()
  unblockUI(true)
  maybeOpenSubMenu()
  maybeRotateChevron()
  handleOpenSubmenuEvent()
  handleSubmenuItemClickEvent()

  // Show menu item line for items before the current hovered item
  // $('#adminmenu ul.wp-submenu a').hover(function () {
  //   $(this).parent().prevAll().addClass('show-line')
  //   $(this).parent().nextAll().removeClass('show-line')
  // })
  //
  // $('#adminmenu a.menu-top').hover(function () {
  //   $('#adminmenu ul.wp-submenu li').removeClass('show-line')
  // })

});

function wrapAdminContent() {
  $( "#wpwrap" ).wrap( "<div id='db-wrapper-1'><div id='db-wrapper-2'><div id='db-wrapper-3'></div></div></div>" );
  $("#wpadminbar").detach().appendTo("#db-wrapper-1");
  $("#adminmenumain").detach().appendTo("#db-wrapper-1");
}

function removeFooter() {
  $("#wpfooter").remove()
}

function blockUI() {
  $("body").addClass('transition')
  $("body").addClass('mask-transparent')
  $("body").removeClass('mask-hidden')
  setTimeout(() =>{
    $("body").removeClass('mask-transparent')
  }, 100)
}

function unblockUI() {
  $("body").addClass('mask-transparent')
  setTimeout(() =>{
    $("body").addClass('mask-hidden')
  }, 300)
}

function handleOpenSubmenuEvent() {
  $("#adminmenu a.menu-top.wp-has-submenu").click(function (e) {
    e.preventDefault()
    toggleSubmenu(this)
    toggleChevron(this)
  })
}

function handleSubmenuItemClickEvent() {
  $('#adminmenu .wp-submenu a').click(function (e) {
    updateCurrentMenuItemClass(this)
    blockUI()
  })
}

function updateCurrentMenuItemClass(element) {
  $('#adminmenu .wp-submenu li').not($(element).parent('li')).removeClass('current')
  $('#adminmenu li.wp-has-submenu').not($(element).closest('li.wp-has-submenu')).removeClass('submenu-opened wp-has-current-submenu').addClass('wp-not-current-submenu')
  $('#adminmenu a.wp-has-submenu').not($(element).closest('a.wp-has-submenu')).removeClass('wp-has-current-submenu').addClass('wp-not-current-submenu')
  $(element).closest('li').addClass('current')
  $(element).closest('li.wp-has-submenu').addClass('wp-has-current-submenu').addClass('submenu-opened')
  $(element).closest('a.wp-has-submenu').addClass('wp-has-current-submenu')
}

function toggleSubmenu(element) {
  let submenu = $(element).next('ul')
  submenu.css('display') === 'none' ? submenu.slideDown(300) : submenu.slideUp(200)
  $('ul.wp-submenu').not($(element).next('ul')).slideUp(200)
}

function maybeOpenSubMenu() {
  $('#adminmenu li.wp-has-current-submenu ul').css('display', 'block')
}

function toggleChevron(element) {
  let parent = $(element).parent('li.menu-top.wp-has-submenu')
  parent.hasClass('submenu-opened') ? parent.removeClass('submenu-opened') : parent.addClass('submenu-opened')
  $('li.menu-top.wp-has-submenu').not(parent).removeClass('submenu-opened')
}

function maybeRotateChevron() {
  $('#adminmenu li.wp-has-current-submenu').addClass('submenu-opened')
}