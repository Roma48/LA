!function(a,b,c,d){function e(a){return a.replace(/\\(.)/gm,"$1")}a.imp_editor_storage_get_saves_list=function(b){var c={action:"image_map_pro_get_saves_list"};a.post(ajaxurl,c).done(function(a){a=e(a);var c=JSON.parse(a);b(c)})},a.imp_editor_storage_get_save=function(b,c){var d={action:"image_map_pro_get_number_of_fragments_for_save",saveID:b};a.post(ajaxurl,d).done(function(d){function f(){var a="";for(var b in g)a+=g[b];var d={};a=e(a);try{d=JSON.parse(a)}catch(f){console.log("Failed to parse JSON: "),console.log("------"),console.log(a),d=!1}c(d)}d=parseInt(d,10);for(var g={},h=0,i=0;d>i;i++){var j={action:"image_map_pro_get_save_fragment",saveID:b,index:i};a.post(ajaxurl,j).done(function(a){var b=JSON.parse(a);g[b.index]=b.fragment,h++,h==d&&f()})}})},a.imp_editor_storage_store_save=function(b,c){var d={action:"image_map_pro_store_save_meta",saveID:b.id,meta:{name:b.general.name,id:b.id,shortcode:b.general.shortcode}};a.post(ajaxurl,d).done(function(d){var e={action:"image_map_pro_get_max_fragment_size"};a.post(ajaxurl,e).done(function(d){function e(){var d={action:"image_map_pro_store_save_complete",saveID:b.id,fragmentsLength:k};a.post(ajaxurl,d).done(function(a){c()})}for(var f=parseInt(d,10),g=JSON.stringify(b),h=[],i=g.length,j=0;i>j;j+=f)h.push(g.substring(j,j+f));for(var j=0,k=h.length,l=0,j=0;k>j;j++){var m={action:"image_map_pro_store_save_fragment",saveID:b.id,index:j,fragment:h[j]};a.post(ajaxurl,m).done(function(a){l++;var b=Math.round(l/k*100);c(b),l==k&&e()})}})})},a.imp_editor_storage_delete_save=function(b,c){var d={action:"image_map_pro_delete_save",saveID:b};a.post(ajaxurl,d).done(function(a){c()})},a.imp_editor_storage_get_last_save=function(b){var c={action:"image_map_pro_get_last_save"};a.post(ajaxurl,c).done(function(a){b(a.length>0?a:!1)})},a.imp_editor_storage_set_last_save=function(b,c){var d={action:"image_map_pro_set_last_save",saveID:b};a.post(ajaxurl,d).done(function(){c()})}}(jQuery,window,document);