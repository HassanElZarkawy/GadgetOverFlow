jQuery.fn.tag=function(e){var t={seperator:",",unique:!0,addOnEnter:!0,style:{list:"taglist",item:"tag",input:"input",remove:"delete"}};e=jQuery.extend(t,e),jQuery(this).each(function(){""!=(seperator=jQuery(this).attr("data-seperator"))&&(e.seperator=seperator);var t=function(t){var r=t.replace(/^\s+|\s+$/g,"");if(""!=r){var i=jQuery("<li/>").addClass(e.style.item),a=jQuery("<span/>"),l=jQuery("<span/>").html("[X]"),u=jQuery("<a/>",{tabindex:"-1"}).addClass(e.style.remove).append(l).click(function(){jQuery(this).closest("li").remove(),s()});if(!(e.unique&&jQuery.inArray(r,y)>-1))return y.push(r),a.html(r),i.append(a).append(" ").append(u),i}},r=function(r){if(""!=jQuery(r).val()){var i=t(jQuery(r).val());i?(jQuery(r).closest("li").before(i),jQuery(r).val(jQuery(r).val().replace(e.seperator,"")),jQuery(r).width(8).val("").focus()):(jQuery(r).val(""),jQuery(r).width(8)),s(),o.html("")}},s=function(){var t=[];jQuery("li."+e.style.item+" > span",a).each(function(){t.push(jQuery(this).html())}),y=t,jQuery(i).val(t.join(e.seperator))},i=jQuery(this);if(i.is(":input")){i.hide();var a=jQuery("<ul/>").addClass(e.style.list).click(function(){jQuery(this).find("input").focus()}),l=jQuery("<input/>",{type:"text"}),u=i.val().split(e.seperator),y=[];for(index in u){var d=t(u[index]);a.append(d)}s(),i.after(a);var n=jQuery("<li/>").addClass(e.style.input),o=jQuery("<span/>");o.hide(),n.append(l),l.after(o),a.append(n);var h=function(e){o.html(jQuery(e).val().replace(/\s/g,"&nbsp;"));var t=""==jQuery(e).val()?8:10;jQuery(e).width(o.width()+t)};l.bind("keyup",function(){h(this)}).bind("keydown",function(e){h(this);var t=e.keyCode||e.which;if(""==jQuery(this).val()&&(8==t||46==t)){switch(jQuery(this).width(""!=jQuery(this).val()?o.width()+5:8),t){case 8:jQuery(this).closest("li").prev().is(".ready-to-delete")?(jQuery(".ready-to-delete").removeClass("ready-to-delete"),jQuery(this).closest("li").prev().remove()):(jQuery(".ready-to-delete").removeClass("ready-to-delete"),jQuery(this).closest("li").prev().addClass("ready-to-delete"));break;case 46:jQuery(this).closest("li").next().is(".ready-to-delete")?(jQuery(".ready-to-delete").removeClass("ready-to-delete"),jQuery(this).closest("li").next().remove()):(jQuery(".ready-to-delete").removeClass("ready-to-delete"),jQuery(this).closest("li").next().addClass("ready-to-delete"))}return s(),e.preventDefault(),!1}jQuery(".ready-to-delete").removeClass("ready-to-delete"),""==jQuery(this).val()&&((37==t||38==t)&&(jQuery(this).width(""!=jQuery(this).val()?o.width()+5:8),jQuery(this).closest("li").prev().before(jQuery(this).closest("li")),jQuery(this).focus()),(39==t||40==t)&&(jQuery(this).width(""!=jQuery(this).val()?o.width()+5:8),jQuery(this).closest("li").next().after(jQuery(this).closest("li")),jQuery(this).focus()))}).bind("keypress",function(t){h(this);var s=t.keyCode||t.which;return e.seperator==String.fromCharCode(s)||e.seperator==s||e.addOnEnter&&13==s?(r(this),t.preventDefault(),!1):void 0}).bind("blur",function(){r(this),jQuery(this).closest("ul").append(jQuery(this).closest("li"))})}})};