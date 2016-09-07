!function(a,b,c,d){function e(a){var b=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(a);return b?{r:parseInt(b[1],16),g:parseInt(b[2],16),b:parseInt(b[3],16)}:null}a.image_map_pro_editor_content=function(){var b=a.image_map_pro_editor_current_settings(),c="";c+='<img id="imp-editor-image" src="'+b.general.image_url+'">',c+='<div id="imp-editor-shapes-container">';for(var d=0;d<b.spots.length;d++){var f=b.spots[d];if("spot"==f.type)if(1==parseInt(f.default_style.use_icon,10)){var g="";g+="left: "+f.x+"%;",g+="top: "+f.y+"%;",g+="width: "+f.width+"px;",g+="height: "+f.height+"px;",g+="margin-left: -"+f.width/2+"px;",g+="margin-top: -"+f.height/2+"px;",g+="background-image: url("+f.default_style.icon_url+")",g+="background-position: center;",g+="background-repeat: no-repeat;";var h="";if(1==parseInt(f.default_style.icon_is_pin,10)&&(h+="top: -50%;",h+="position: absolute;"),c+='<div class="imp-editor-shape imp-editor-spot" data-id="'+f.id+'" style="'+g+'"><div class="imp-selection" style="border-radius: '+f.default_style.border_radius+'px;"></div>',"library"==f.default_style.icon_type?(c+='   <svg style="'+h+'" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="'+f.default_style.icon_svg_viewbox+'" xml:space="preserve" width="'+f.width+'px" height="'+f.height+'px">',c+='       <path style="fill:'+f.default_style.icon_fill+'" d="'+f.default_style.icon_svg_path+'"></path>',c+="   </svg>"):f.default_style.icon_url.length>0&&(c+='<img style="'+h+'" src="'+f.default_style.icon_url+'">'),1==parseInt(f.default_style.icon_shadow,10)){var i="";i+="width: "+f.width+"px;",i+="height: "+f.height+"px;",0==parseInt(f.default_style.icon_is_pin,10)&&(i+="top: "+f.height/2+"px;"),c+='<div style="'+i+'" class="imp-editor-shape-icon-shadow"></div>'}c+="</div>"}else{var j=e(f.default_style.background_color),k=e(f.default_style.border_color),g="";g+="left: "+f.x+"%;",g+="top: "+f.y+"%;",g+="width: "+f.width+"px;",g+="height: "+f.height+"px;",g+="margin-left: -"+f.width/2+"px;",g+="margin-top: -"+f.height/2+"px;",g+="background: rgba("+j.r+", "+j.g+", "+j.b+", "+f.default_style.background_opacity+");",g+="border-color: rgba("+k.r+", "+k.g+", "+k.b+", "+f.default_style.border_opacity+");",g+="border-width: "+f.default_style.border_width+"px;",g+="border-style: "+f.default_style.border_style+";",g+="border-radius: "+f.default_style.border_radius+"px;",c+='<div class="imp-editor-shape imp-editor-spot" data-id="'+f.id+'" style="'+g+'"><div class="imp-selection" style="border-radius: '+f.default_style.border_radius+'px;"></div></div>'}if("rect"==f.type){var j=e(f.default_style.background_color),k=e(f.default_style.border_color),g="";g+="left: "+f.x+"%;",g+="top: "+f.y+"%;",g+="width: "+f.width+"%;",g+="height: "+f.height+"%;",g+="background: rgba("+j.r+", "+j.g+", "+j.b+", "+f.default_style.background_opacity+");",g+="border-color: rgba("+k.r+", "+k.g+", "+k.b+", "+f.default_style.border_opacity+");",g+="border-width: "+f.default_style.border_width+"px;",g+="border-style: "+f.default_style.border_style+";",g+="border-radius: "+f.default_style.border_radius+"px;",c+='<div class="imp-editor-shape imp-editor-rect" data-id="'+f.id+'" style="'+g+'">',c+='   <div class="imp-selection" style="border-radius: '+f.default_style.border_radius+'px;">',c+='       <div class="imp-selection-translate-boxes">',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-1" data-transform-direction="1"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-2" data-transform-direction="2"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-3" data-transform-direction="3"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-4" data-transform-direction="4"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-5" data-transform-direction="5"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-6" data-transform-direction="6"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-7" data-transform-direction="7"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-8" data-transform-direction="8"></div>',c+="       </div>",c+="   </div>",c+="</div>"}if("oval"==f.type){var j=e(f.default_style.background_color),k=e(f.default_style.border_color),g="";g+="left: "+f.x+"%;",g+="top: "+f.y+"%;",g+="width: "+f.width+"%;",g+="height: "+f.height+"%;",g+="background: rgba("+j.r+", "+j.g+", "+j.b+", "+f.default_style.background_opacity+");",g+="border-color: rgba("+k.r+", "+k.g+", "+k.b+", "+f.default_style.border_opacity+");",g+="border-width: "+f.default_style.border_width+"px;",g+="border-style: "+f.default_style.border_style+";",g+="border-radius: 100% 100%;",c+='<div class="imp-editor-shape imp-editor-oval" data-id="'+f.id+'" style="'+g+'">',c+='   <div class="imp-selection" style="border-radius: 100% 100%;">',c+='       <div class="imp-selection-translate-boxes">',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-1" data-transform-direction="1"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-2" data-transform-direction="2"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-3" data-transform-direction="3"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-4" data-transform-direction="4"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-5" data-transform-direction="5"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-6" data-transform-direction="6"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-7" data-transform-direction="7"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-8" data-transform-direction="8"></div>',c+="       </div>",c+="   </div>",c+="</div>"}if("poly"==f.type&&f.points){var l=e(f.default_style.fill),m=e(f.default_style.stroke_color),g="";g+="left: "+f.x+"%;",g+="top: "+f.y+"%;",g+="width: "+f.width+"%;",g+="height: "+f.height+"%;";var n="";n+="width: 100%;",n+="height: 100%;",n+="fill: rgba("+l.r+", "+l.g+", "+l.b+", "+f.default_style.fill_opacity+");",n+="stroke: rgba("+m.r+", "+m.g+", "+m.b+", "+f.default_style.stroke_opacity+");",n+="stroke-width: "+f.default_style.stroke_width+"px;",n+="stroke-dasharray: "+f.default_style.stroke_dasharray+";",n+="stroke-linecap: "+f.default_style.stroke_linecap+";",c+='<div class="imp-editor-shape imp-editor-poly" data-id="'+f.id+'" style="'+g+'">',c+='   <div class="imp-editor-poly-svg-temp-control-point"></div>';var o=b.general.width*(f.width/100),p=b.general.height*(f.height/100);c+='   <div class="imp-editor-svg-wrap" style="padding: '+f.default_style.stroke_width+"px; left: -"+f.default_style.stroke_width+"px; top: -"+f.default_style.stroke_width+'px;">',c+='       <svg class="imp-editor-poly-svg" viewBox="0 0 '+o+" "+p+'" preserveAspectRatio="none" style="'+n+'">',c+='           <polygon points="';for(var q=0;q<f.points.length;q++){var r=f.default_style.stroke_width+f.points[q].x/100*(o-2*f.default_style.stroke_width),s=f.default_style.stroke_width+f.points[q].y/100*(p-2*f.default_style.stroke_width);c+=r+","+s+" "}c+='           "></polygon>',c+="       </svg>",c+="   </div>",c+='       <svg class="imp-editor-shape-poly-svg-overlay" viewBox="0 0 '+o+" "+p+'" preserveAspectRatio="none">',c+='           <polygon points="';for(var q=0;q<f.points.length;q++){var r=f.points[q].x/100*o,s=f.points[q].y/100*p;c+=r+","+s+" "}c+='           "></polygon>',c+="       </svg>",c+='   <div class="imp-selection imp-expanded-selection">',c+='       <div class="imp-selection-translate-boxes">',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-1" data-transform-direction="1"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-2" data-transform-direction="2"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-3" data-transform-direction="3"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-4" data-transform-direction="4"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-5" data-transform-direction="5"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-6" data-transform-direction="6"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-7" data-transform-direction="7"></div>',c+='           <div class="imp-selection-translate-box imp-selection-translate-box-8" data-transform-direction="8"></div>',c+="       </div>",c+="   </div>";for(var q=0;q<f.points.length;q++)c+='       <div class="imp-poly-control-point" data-index="'+q+'" style="left: '+f.points[q].x+"%; top: "+f.points[q].y+'%;"></div>';c+="</div>"}}return c+="</div>"}}(jQuery,window,document);