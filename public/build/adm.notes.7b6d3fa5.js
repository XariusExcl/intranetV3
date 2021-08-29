"use strict";(self.webpackChunkintranetv3=self.webpackChunkintranetv3||[]).push([[5431],{4668:(t,e,n)=>{var a=n(2396),i=n(9755);function o(t,e){return i.ajax({url:Routing.generate("administration_note_corrige_ajax",{note:t,action:e}),method:"POST",success:function(t){return t}})}i(document).on("click",".optAfficher",(function(){var t=i(this).data("id"),e=i(this).children("i"),n=i(this);i.ajax({url:Routing.generate("administration_evaluation_visibilite",{uuid:t}),success:function(){e.hasClass("fa-eye")?(n.addClass("btn-danger"),n.removeClass("btn-info").removeClass("btn-outline"),e.removeClass("fa-eye"),e.addClass("fa-eye-slash"),n.attr("title","Evaluation masquée. Rendre visible l'évaluation")):(n.removeClass("btn-danger"),n.addClass("btn-info").addClass("btn-outline"),e.removeClass("fa-eye-slash"),e.addClass("fa-eye"),n.attr("title","Evaluation visible. Masquer l'évaluation")),(0,a.qX)("Visibilité de l'évaluation modifiée !","success")},error:function(){(0,a.qX)("Une erreur est survenue !","danger")}})})),i(document).on("click",".optVerrouiller",(function(){var t=i(this).data("id"),e=i(this).children("i"),n=i(this);i.ajax({url:Routing.generate("administration_evaluation_modifiable",{uuid:t}),success:function(){e.hasClass("fa-lock-open")?(console.log("ok"),n.addClass("btn-danger"),n.removeClass("btn-warning").removeClass("btn-outline"),e.removeClass("fa-lock-open"),e.addClass("fa-lock"),n.attr("data-original-title","Modification interdite. Autoriser la modificaiton")):(n.removeClass("btn-danger"),n.addClass("btn-warning").addClass("btn-outline"),e.removeClass("fa-lock"),e.addClass("fa-lock-open"),n.attr("data-original-title","Modification autorisée. Interdire la modification")),(0,a.qX)("Vérouillage de l'évaluation modifiée !","success")},error:function(){(0,a.qX)("Une erreur est survenue !","danger")}})})),i(document).on("click","#voirDetailAbsent",(function(t){t.preventDefault(),i("#detailIncoherent").hide(),i("#detailAbsent").toggle()})),i(document).on("click","#voirDetailIncoherent",(function(t){t.preventDefault(),i("#detailIncoherent").toggle(),i("#detailAbsent").hide()})),i(document).on("click","#remplacerParZero",(function(t){t.preventDefault(),o(i(this).data("note"),"zero").then((function(t){i("#note_"+t).text(0)}))})),i(document).on("click","#marquerAbsent",(function(t){t.preventDefault(),o(i(this).data("note"),"absent").then((function(t){i("#note_"+t).text("Absence justifiée")}))})),i(document).on("click","#supprAbsent",(function(t){t.preventDefault(),o(i(this).data("note"),"suppr-absence")}))},2396:(t,e,n)=>{n.d(e,{qX:()=>y,FX:()=>D,xQ:()=>O,XQ:()=>x,zl:()=>j});n(4916),n(3123),n(3843),n(3710),n(3210),n(5306),n(9653);var a=n(6455),i=n.n(a),o=(n(9070),n(7941),n(2526),n(7327),n(5003),n(9554),n(4747),n(9337),n(3321),n(8588)),r=n.n(o);function s(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,a)}return n}function c(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?s(Object(n),!0).forEach((function(e){u(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):s(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function l(t,e){for(var n=0;n<e.length;n++){var a=e[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}function u(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}const d=new(function(){function t(){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),u(this,"defaultOptions",{close:!0,duration:3e3,className:"toast",escapeMarkup:!1,gravity:"top",position:"right",stopOnFocus:!0})}var e,n,a;return e=t,(n=[{key:"show",value:function(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,a=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{};(a=c(c({},this.defaultOptions),a)).className+=" toast-"+t;var i='<div class="toast-wrapper">';n&&(i+='<div class="toast-head">'+n+"</div>"),i+='<div class="toast-body">'+e+"</div>",i+="</div>",a.text=i,r()(a).showToast()}},{key:"error",value:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};this.show("error",t,e,n)}},{key:"warning",value:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};this.show("warning",t,e,n)}},{key:"success",value:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};this.show("success",t,e,n)}},{key:"info",value:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};this.show("info",t,e,n)}}])&&l(e.prototype,n),a&&l(e,a),t}());var f,p,v,m=n(9755),h=n(9755),b=!1;function y(t,e){switch(e){case"success":d.success(t);break;case"danger":d.error(t);break;case"warning":d.warning(t);break;case"info":d.info(t)}}f=m(location).attr("pathname"),p=f.split("/"),v=2,"index.php"===p[1]&&p.length>1&&(v=3),"super-administration"===p[v]&&(v+=1),""===p[p.length-1]&&p.pop(),m(".menu-item").removeClass("active"),m("#menu-"+p[v]).addClass("active"),i().mixin({customClass:{confirmButton:"btn btn-primary",cancelButton:"btn btn-secondary"},buttonsStyling:!1}),m(document).on("click",".supprimer",(function(t){t.preventDefault();var e=m(this).attr("href"),n=m(this).data("csrf");i().fire({title:"Confirmer la suppression ?",text:"L'opération ne pourra pas être annulée.",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Oui, je confirme",cancelButtonText:"Non, Annuler",customClass:{confirmButton:"btn btn-primary",cancelButton:"btn btn-secondary"},buttonsStyling:!1}).then((function(t){t.value?m.ajax({url:e,type:"DELETE",data:{_token:n},success:function(t){t.hasOwnProperty("redirect")&&t.hasOwnProperty("url")?document.location.href=t.url:(m("#ligne_"+t).closest("tr").remove(),y("Suppression effectuée avec succès","success"),i().fire({title:"Supprimé!",text:"L'enregistrement a été supprimé.",icon:"success",confirmButtonText:"OK",customClass:{confirmButton:"btn btn-primary",cancelButton:"btn btn-secondary"},buttonsStyling:!1}))},error:function(t,e,n){i().fire({title:"Erreur lors de la suppression!",text:"Merci de renouveler l'opération",icon:"error",confirmButtonText:"OK",customClass:{confirmButton:"btn btn-primary",cancelButton:"btn btn-secondary"},buttonsStyling:!1}),y("Erreur lors de la tentative de suppression","danger")}}):"cancel"===t.dismiss&&i().fire({title:"Cancelled",text:"OK! Tout est comme avant !",icon:"error",confirmButtonText:"OK",customClass:{confirmButton:"btn btn-primary",cancelButton:"btn btn-secondary"},buttonsStyling:!1})}))}));var g="",k="text",C=!1;function w(t){var e=m("#myedit-input-"+t).val();m.ajax({url:g.attr("href"),data:{field:g.data("field"),value:e,type:k},method:"POST",success:function(){g.html(e),m("#myEdit-zone-"+t).replaceWith(g),C=!1}})}function O(t,e){var n={};return m.each(m(t).data(),(function(t,a){if("provide"!=(t=t.replace(/-([a-z])/g,(function(t){return t[1].toUpperCase()})))){if(null!=e)switch(e[t]){case"bool":a=Boolean(a);break;case"num":a=Number(a);break;case"array":a=a.split(",")}n[t]=a}})),n}function x(t){t.removeClass("is-valid").addClass("is-invalid")}function j(t){t.removeClass("is-invalid").addClass("is-valid")}function D(t){t.removeClass("is-invalid").removeClass("is-valid")}m(document).on("click",".myedit",(function(t){t.preventDefault(),g=m(this);var e,n,a="";C=!0,void 0!==m(this).data("type")&&(k=m(this).data("type")),"select"===m(this).data("type")||("textarea"===m(this).data("type")?(e=m(this),n=Date.now(),b=!0,a='<div id="myEdit-zone-'+n+'">\n                      <textarea rows="5" class="form-control" id="myedit-input-'+n+'">'+e.html().trim()+'</textarea>\n                      <span class="input-group-append">\n <button class="btn btn-success-outline myedit-valide" data-key="'+n+'"><i class="fas fa-check"></i></button>\n                        <button class="btn btn-danger-outline myedit-annule"  data-key="'+n+'"><i class="fas fa-times"></i></button>\n                      </span>\n                    </div>'):a=function(t){var e=Date.now();return'<div id="myEdit-zone-'+e+'" class="input-group">\n                      <input type="text" class="form-control" id="myedit-input-'+e+'" value="'+t.html().trim()+'" >\n                      <span class="input-group-append">\n <button class="btn btn-success-outline myedit-valide"  data-key="'+e+'"><i class="fas fa-check"></i></button>\n                        <button class="btn btn-danger-outline myedit-annule"  data-key="'+e+'"><i class="fas fa-times"></i></button>\n                      </span>\n                    </div>'}(m(this))),m(this).replaceWith(a),m("#myedit-input").focus()})),m(document).on("keyup","#myedit-input",(function(t){13===t.keyCode&&!1===b?w():27===t.keyCode&&m("#myEdit-zone").replaceWith(g)})),m(document).on("click",".myedit-valide",(function(t){b=!1,t.preventDefault(),w(m(this).data("key"))})),m(document).on("keypress",(function(t){!0===C&&!1===b&&13===t.which&&(t.preventDefault(),w(m(this).data("key"))),!0===C&&!1===b&&27===t.which&&(t.preventDefault(),m("#myEdit-zone-"+m(this).data("key")).replaceWith(g))})),m(document).on("click",".myedit-annule",(function(t){t.preventDefault(),m("#myEdit-zone-"+m(this).data("key")).replaceWith(g)})),h.fn.dataAttr=function(t,e){return m(this)[0].getAttribute("data-"+t)||e},h.fn.hasDataAttr=function(t){return m(this)[0].hasAttribute("data-"+t)}}},t=>{t.O(0,[9755,2109,3123,94,8771],(()=>{return e=4668,t(t.s=e);var e}));t.O()}]);