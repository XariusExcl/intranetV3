(self.webpackChunk=self.webpackChunk||[]).push([[1953],{41953:(e,t,n)=>{var o,i=n(19755);function a(e){return(a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}n(82526),n(41817),n(32165),n(57327),n(69826),n(66992),n(69600),n(47042),n(2707),n(83710),n(68309),n(9653),n(41539),n(54678),n(24603),n(74916),n(39714),n(78783),n(15306),n(23123),n(33948),(o=i).fn.collection=function(e){var t={container:"body",allow_up:!0,up:'<a href="#">&#x25B2;</a>',before_up:function(e,t){return!0},after_up:function(e,t){return!0},allow_down:!0,down:'<a href="#">&#x25BC;</a>',before_down:function(e,t){return!0},after_down:function(e,t){return!0},allow_add:!0,add:'<a href="#">[ + ]</a>',before_add:function(e,t){return!0},after_add:function(e,t){return!0},allow_remove:!0,remove:'<a href="#">[ - ]</a>',before_remove:function(e,t){return!0},after_remove:function(e,t){return!0},allow_duplicate:!1,duplicate:'<a href="#">[ # ]</a>',before_duplicate:function(e,t){return!0},after_duplicate:function(e,t){return!0},before_init:function(e){},after_init:function(e){},min:0,max:100,add_at_the_end:!1,prefix:"collection",prototype_name:"__name__",name_prefix:null,elements_selector:"> div, > fieldset",elements_parent_selector:"%id%",children:null,init_with_n_elements:0,hide_useless_buttons:!0,drag_drop:!0,drag_drop_options:{placeholder:"ui-state-highlight"},drag_drop_start:function(e,t){return!0},drag_drop_update:function(e,t){return!0},custom_add_location:!1,action_container_tag:"div",fade_in:!0,fade_out:!0,position_field_selector:null,preserve_names:!1},n=function(e,t){if(!t.attr("id")){var n;do{n=e+"_"+(""+1e3*Math.random()*(new Date).getTime()).replace(".","").split("").sort((function(){return.5-Math.random()})).join("")}while(o("#"+n).length>0);t.attr("id",n)}return t.attr("id")},r=function(e){try{var t=o(e)}catch(e){return null}return 0===t.length?null:t.is('input[type="checkbox"]')?!0===t.prop("checked"):t.is('input[type="radio"]')&&void 0!==t.attr("name")?o('input[name="'+t.attr("name")+'"]:checked').val():void 0!==t.prop("value")?t.val():t.html()},l=function(e,t,n){try{var i=o(e)}catch(e){return}0!==i.length&&(i.is('input[type="checkbox"]')?t?i.attr("checked",!0):i.removeAttr("checked"):void 0!==i.prop("value")?n?i.attr("value",t):i.val(t):i.html(t))},d=function(e){return void 0===e||e},c=function(e){return(e+"").replace(/[.?*+^$[\]\\(){}|-]/g,"\\$&")},s=function(e,t,n,i){var r=function(e){var t=o(e);"object"==a(e)&&"attributes"in e&&o.each(e.attributes,(function(e,a){"string"===o.type(a.value)&&t.attr(a.name.replace(n,i),a.value.replace(n,i))})),t.length>0&&o.each(t.data(),(function(e,a){"string"===o.type(a)&&t.data(e.replace(n,i),a.replace(n,i))}))},l=e.eq(t);r(l[0]),l.find("*").each((function(){r(this)}))},f=function(e,t,n,i,a,r){var l=new RegExp(c(n.name_prefix+"["+a+"]"),"g"),d=n.name_prefix+"["+r+"]";n.children&&o.each(n.children,(function(t,n){var o=e.find(n.selector).eq(i),a=o.data("collection-settings");a&&(a.name_prefix=a.name_prefix.replace(l,d),o.data("collection-settings",a))})),s(t,i,l,d),l=new RegExp(c(e.attr("id")+"_"+a),"g"),d=e.attr("id")+"_"+r,n.children&&o.each(n.children,(function(t,n){var o=e.find(n.selector).eq(i),a=o.data("collection-settings");a&&(a.elements_parent_selector=a.elements_parent_selector.replace(l,d),a.elements_selector=a.elements_selector.replace(l,d),a.prefix=a.prefix.replace(l,d),o.data("collection-settings",a))})),s(t,i,l,d)},p=function(e,t,n,o){var i=e.data("collection-settings");return i.position_field_selector||i.preserve_names||(f(e,t,i,n,n,"__swap__"),f(e,t,i,o,o,n),f(e,t,i,n,"__swap__",o)),t.eq(n).insertBefore(t.eq(o)),o>n?t.eq(o).insertBefore(t.eq(n)):t.eq(o).insertAfter(t.eq(n)),e.find(i.elements_selector)},_=function(e,t,n,o,i){for(var a=o+1;a<=i;a++)t=p(e,t,a,a-1);return e.find(n.elements_selector)},u=function(e,t,n,o,i){for(var a=o-1;a>=i;a--)t=p(e,t,a,a+1);return e.find(n.elements_selector)},h=function(e,t,n,o){for(var i=o+1;i<t.length;i++)t=p(e,t,i-1,i);return e.find(n.elements_selector)},m=function(e,t,i,a){var r=o(t.elements_parent_selector),l=0===r.find("."+t.prefix+"-tmp").length,d=e.find(t.elements_selector);if(t.allow_add&&l&&(r.append('<span class="'+t.prefix+'-tmp"></span>'),t.add&&r.append(o(t.add).addClass(t.prefix+"-action "+t.prefix+"-rescue-add").data("collection",e.attr("id")))),i){e.data("collection-offset",d.length);for(var c=o(t.container),s=e.find("."+t.prefix+"-add, ."+t.prefix+"-rescue-add, ."+t.prefix+"-duplicate").first(),f=0;d.length<t.init_with_n_elements;){f++;var p=d.length>0?d.last():void 0,_=d.length-1;if(d=x(c,s,e,t,d,p,_,!1),f>t.init_with_n_elements){console.error("Infinite loop, element selector ("+t.elements_selector+") not found !");break}}e.data("collection-offset",d.length)}if(d.each((function(r){var l=o(this);i&&l.data("index",r);var c=l.find("."+t.prefix+"-actions").addBack().filter("."+t.prefix+"-actions");0===c.length&&(c=o("<"+t.action_container_tag+' class="'+t.prefix+'-actions"></'+t.action_container_tag+">"),l.append(c));var s=0;"remove"===a&&t.fade_out&&(s=1);var f=[{enabled:t.allow_remove,selector:t.prefix+"-remove",html:t.remove,condition:d.length-s>t.min},{enabled:t.allow_up,selector:t.prefix+"-up",html:t.up,condition:d.length-s>1&&d.index(l)-s>0},{enabled:t.allow_down,selector:t.prefix+"-down",html:t.down,condition:d.length-s>1&&d.index(l)!==d.length-1},{enabled:t.allow_add&&!t.add_at_the_end&&!t.custom_add_location,selector:t.prefix+"-add",html:t.add,condition:d.length-s<t.max},{enabled:t.allow_duplicate,selector:t.prefix+"-duplicate",html:t.duplicate,condition:d.length-s<t.max}];o.each(f,(function(i,a){if(a.enabled){var d=l.find("."+a.selector);0===d.length&&a.html&&(d=o(a.html).appendTo(c).addClass(a.selector)),a.condition?(d.removeClass(t.prefix+"-action-disabled"),t.hide_useless_buttons&&d.css("display","")):(d.addClass(t.prefix+"-action-disabled"),t.hide_useless_buttons&&d.css("display","none")),d.addClass(t.prefix+"-action").data("collection",e.attr("id")).data("element",n(e.attr("id")+"_"+r,l))}else l.find("."+a.selector).css("display","none")}))})),t.allow_add){var u=0;"remove"===a&&t.fade_out&&(u=1);var h=e.find("."+t.prefix+"-rescue-add").css("display","").removeClass(t.prefix+"-action-disabled"),m=e.find("."+t.prefix+"-add");!t.add_at_the_end&&m.length>u||t.custom_add_location?h.css("display","none"):"remove"===a&&t.fade_out&&(h.css("display","none"),h.fadeIn("fast")),d.length-u>=t.max&&(h.addClass(t.prefix+"-action-disabled"),t.hide_useless_buttons&&e.find("."+t.prefix+"-add, ."+t.prefix+"-rescue-add, ."+t.prefix+"-duplicate").css("display","none"))}},v=function(e,t,n){n.children&&o.each(n.children,(function(n,o){if(!o.selector)return console.log("jquery.collection.js: given collection "+e.attr("id")+" has children collections, but children's root selector is undefined."),!0;null!==t?t.find(o.selector).collection(o):e.find(o.selector).collection(o)}))},x=function(e,t,n,i,a,s,f,p){if(a.length<i.max&&(p&&d(i.before_duplicate(n,s))||d(i.before_add(n,s)))){var _=n.data("prototype"),u=n.data("collection-offset");n.data("collection-offset",u+1),-1===f&&(f=a.length-1);var x=new RegExp(c(i.prototype_name),"g"),g=u;i.preserve_names&&(void 0===(g=n.data("collection-free-key"))&&(g=j(i,a)),n.data("collection-free-key",g+1));var k=o(_.replace(x,g)).data("index",u);q(i,k);var C=o(i.elements_parent_selector).find("> ."+i.prefix+"-tmp");if(o(k).find("[id]").first().attr("id"),p){var A=a.eq(f);!function(e){o(e).find(":input").each((function(e,t){l(t,r(t),!0)}))}(A);var E=o("<div/>").append(A.clone()).html(),S=i.preserve_names||i.position_field_selector?A.data("index"):f,B=i.preserve_names?y(i,A):S,F=function(e,t,n,o,i,a,r){var l=new RegExp(c(t.name_prefix+"["+a+"]"),"g"),d=t.name_prefix+"["+r+"]";return n=n.replace(l,d),l=new RegExp(c(e.attr("id")+"_"+o),"g"),d=e.attr("id")+"_"+i,n.replace(l,d)}(n,i,E,S,u,B,g);k=o("<div/>").html(F).contents().data("index",u),i.fade_in&&k.hide(),C.before(k).find(i.prefix+"-actions").remove()}else i.fade_in&&k.hide(),C.before(k);a=n.find(i.elements_selector);var R=k.find("."+i.prefix+"-add, ."+i.prefix+"-duplicate");R.length>0&&R.addClass(i.prefix+"-action").data("collection",n.attr("id")),i.add_at_the_end||f+1===u?m(n,i,!1):a=w(n,i,a,k,u,f+1),v(n,k,i),(p&&!d(i.after_duplicate(n,k))||!d(i.after_add(n,k)))&&(-1!==f&&(a=h(n,a,i,f+1)),k.remove())}if(void 0!==k&&i.fade_in)k.fadeIn("fast",(function(){i.position_field_selector&&b(i,a)}));else if(i.position_field_selector)return b(i,a);return a},g=function(e,t,n,i,a){if(n.length>t.min&&d(t.before_remove(e,i))){var r=function(){var r=i;t.preserve_names||(r=(n=h(e,n,t,a)).last());var l=r.clone({withDataAndEvents:!0}).show();r.remove(),d(t.after_remove(e,l))||(o(t.elements_parent_selector).find("> ."+t.prefix+"-tmp").before(l),n=e.find(t.elements_selector),n=function(e,t,n,o){for(var i=t.length-2;i>o;i--)t=p(e,t,i+1,i);return e.find(n.elements_selector)}(e,n,t,a-1)),t.position_field_selector&&b(t,n)};t.fade_out?i.fadeOut("fast",(function(){r()})):r()}return n},w=function(e,t,n,o,i,a){return 1===Math.abs(a-i)?(n=p(e,n,i,a),d(a-i>0?t.after_up(e,o):t.after_down(e,o))||(n=p(e,n,a,i))):i<a?(n=_(e,n,t,i,a),d(a-i>0?t.after_up(e,o):t.after_down(e,o))||(n=u(e,n,t,a,i))):(n=u(e,n,t,i,a),d(a-i>0?t.after_up(e,o):t.after_down(e,o))||(n=_(e,n,t,a,i))),m(e,t,!1),t.position_field_selector?b(t,n):n},b=function(e,t){return o(t).each((function(){var n=o(this);l(n.find(e.position_field_selector),t.index(n))})),t},y=function(e,t){return t.find(':input[name^="'+e.name_prefix+'["]').attr("name").slice(e.name_prefix.length+1).split("]",1)[0]},j=function(e,t){var n=0;return t.each((function(){var t=y(e,o(this));/^0|[1-9]\d*$/.test(t)&&t>=n&&(n=Number(t)+1)})),n},q=function(e,t){o.each(["-action","-action-disabled","-actions","-add","-down","-duplicate","-remove","-rescue-add","-tmp","-up"],(function(){var n=this;t.each((function(){var t=o(this);t.hasClass(e.user_prefix+n)&&t.addClass(e.prefix+n),t.find("*").each((function(){var t=o(this);t.hasClass(e.user_prefix+n)&&t.addClass(e.prefix+n)}))}))}))},k=o(this);return 0===k.length?(console.log("jquery.collection.js: given collection selector does not exist."),!1):(k.each((function(){var a=o.extend(!0,{},t,e);if(0===o(a.container).length)return console.log("jquery.collection.js: a container should exist to handle events (basically, a <body> tag)."),!1;var c,s,f=o(this);if(void 0!==f.data("collection")){var _=o("#"+f.data("collection"));if(0===_.length)return console.log("jquery.collection.js: given collection id does not exist."),!0}else _=f;if(_=o(_),a.elements_parent_selector=a.elements_parent_selector.replace("%id%","#"+n("",_)),!a.elements_parent_selector&&(a.elements_parent_selector="#"+n("",_),0===o(a.elements_parent_selector).length))return console.log("jquery.collection.js: given elements parent selector does not return any object."),!0;if(a.user_prefix=a.prefix,a.prefix=_.attr("id")+"-"+a.user_prefix,q(a,_),a.allow_add||(a.allow_duplicate=!1,a.add_at_the_end=!1),a.init_with_n_elements>a.max&&(a.init_with_n_elements=a.max),a.min&&(!a.init_with_n_elements||a.init_with_n_elements<a.min)&&(a.init_with_n_elements=a.min),!a.action_container_tag)return console.log("jquery.collection.js: action_container_tag needs to be set."),!0;if(a.before_init(_),null===_.data("prototype"))return console.log("jquery.collection.js: given collection field has no prototype, check that your field has the prototype option set to true."),!0;if(void 0!==_.data("prototype-name")&&(a.prototype_name=_.data("prototype-name")),void 0!==_.data("allow-add")&&(a.allow_add=_.data("allow-add"),a.allow_duplicate=!!_.data("allow-add")&&a.allow_duplicate),void 0!==_.data("allow-remove")&&(a.allow_remove=_.data("allow-remove")),void 0!==_.data("name-prefix")&&(a.name_prefix=_.data("name-prefix")),!a.name_prefix)return console.log("jquery.collection.js: the prefix used in descendant field names is mandatory, you can set it using 2 ways:"),console.log("jquery.collection.js: - use the form theme given with this plugin source"),console.log("jquery.collection.js: - set name_prefix option to  '{{ formView.myCollectionField.vars.full_name }}'"),!0;a.preserve_names&&(a.allow_up=!1,a.allow_down=!1,a.drag_drop=!1,a.add_at_the_end=!0),void 0!==i.ui&&void 0!==i.ui.sortable&&_.data("sortable")&&_.sortable("disable"),a.drag_drop&&a.allow_up&&a.allow_down&&(void 0===i.ui||void 0===i.ui.sortable?a.drag_drop=!1:_.sortable(o.extend(!0,{},{start:function(e,t){var n=_.find(a.elements_selector),i=t.item,r=o(this);d(a.drag_drop_start(e,t,n,i))?(t.placeholder.height(t.item.height()),t.placeholder.width(t.item.width()),c=n.index(i)):r.sortable("cancel")},update:function(e,t){var n=_.find(a.elements_selector),i=t.item;o(this).sortable("cancel"),!1!==a.drag_drop_update(e,t,n,i)&&d(s-c>0?a.before_up(_,i):a.before_down(_,i))&&(s=n.index(i),n=_.find(a.elements_selector),w(_,a,n,i,c,s))}},a.drag_drop_options))),_.data("collection-settings",a);var u=o(a.container);if(u.off("click","."+a.prefix+"-action").on("click","."+a.prefix+"-action",(function(e){var t,n,i=o(this);if(void 0===(n=(t=o("#"+i.data("collection"))).data("collection-settings"))&&void 0===(n=(t=o("#"+i.data("collection")).find("."+i.data("collection")+"-collection")).data("collection-settings")))throw"Can't find collection: "+i.data("collection");var a=t.find(n.elements_selector),r=i.data("element")?o("#"+i.data("element")):void 0,l=r&&r.length?a.index(r):-1,c=null,s=i.is("."+n.prefix+"-duplicate");(i.is("."+n.prefix+"-add")||i.is("."+n.prefix+"-rescue-add")||s)&&n.allow_add&&(c="add",a=x(u,i,t,n,a,r,l,s)),i.is("."+n.prefix+"-remove")&&n.allow_remove&&(c="remove",a=g(t,n,a,r,l)),i.is("."+n.prefix+"-up")&&n.allow_up&&(c="up",a=function(e,t,n,o,i){return 0!==i&&d(t.before_up(e,o))&&(n=p(e,n,i,i-1),d(t.after_up(e,o))||(n=p(e,n,i-1,i))),t.position_field_selector?b(t,n):n}(t,n,a,r,l)),i.is("."+n.prefix+"-down")&&n.allow_down&&(c="down",a=function(e,t,n,o,i){return i!==n.length-1&&d(t.before_down(e,o))&&(n=p(e,n,i,i+1),d(t.after_down(e,n))||(n=p(e,n,i+1,i))),t.position_field_selector?b(t,n):n}(t,n,a,r,l)),m(t,n,!1,c),e.preventDefault()})),m(_,a,!0),v(_,null,a),a.position_field_selector){var h=[],y=_.find(a.elements_selector);y.each((function(e){var t=o(this);h.push({position:parseFloat(r(t.find(a.position_field_selector))),element:t})})),h.sort((function(e,t){return e.position<t.position?-1:e.position>t.position?1:0})),o.each(h,(function(e,t){var n=[];o(y).each((function(e){n.push(o(this).attr("id"))}));var i=t.element,r=o.inArray(i.attr("id"),n);e!==r&&(y=w(_,a,y,i,r,e),l(i.find(a.position_field_selector),y.index(i)))}))}a.after_init(_)})),!0)}},2814:(e,t,n)=>{var o=n(17854),i=n(53111).trim,a=n(81361),r=o.parseFloat,l=1/r(a+"-0")!=-1/0;e.exports=l?function(e){var t=i(String(e)),n=r(t);return 0===n&&"-"==t.charAt(0)?-0:n}:r},2707:(e,t,n)=>{"use strict";var o=n(82109),i=n(13099),a=n(47908),r=n(47293),l=n(9341),d=[],c=d.sort,s=r((function(){d.sort(void 0)})),f=r((function(){d.sort(null)})),p=l("sort");o({target:"Array",proto:!0,forced:s||!f||!p},{sort:function(e){return void 0===e?c.call(a(this)):c.call(a(this),i(e))}})},54678:(e,t,n)=>{var o=n(82109),i=n(2814);o({global:!0,forced:parseFloat!=i},{parseFloat:i})}}]);