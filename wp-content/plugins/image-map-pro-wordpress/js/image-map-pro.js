!function (a, b, c, d) {
    function e(b, c) {
        this.element = b, this.settings = a.extend(!0, {}, n, c), this.root = a(b), this.wrap = d, this.shapeContainer = d, this.shapeSvgContainer = d, this.fullscreenTooltipsContainer = d, this.visibleTooltip = d, this.visibleTooltipIndex = d, this.highlightedShape = d, this.highlightedShapeIndex = d, this.clickedShape = d, this.clickedShapeIndex = d, this.initTimeout = d, this.touch = !1, this.fullscreenTooltipVisible = !1, this.init()
    }

    function f(a) {
        var b = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(a);
        return b ? {r: parseInt(b[1], 16), g: parseInt(b[2], 16), b: parseInt(b[3], 16)} : null
    }

    function g(a, b, c, d, e, f) {
        return a >= c && c + e >= a && b >= d && d + f >= b ? !0 : !1
    }

    function h(a, b, c) {
        for (var d = !1, e = 0, f = c.length - 1; e < c.length; f = e++) {
            var g = c[e][0], h = c[e][1], i = c[f][0], j = c[f][1], k = h > b != j > b && (i - g) * (b - h) / (j - h) + g > a;
            k && (d = !d)
        }
        return d
    }

    function i(a, b, c, d, e, f) {
        var g = (a - c) * (a - c), h = e * e, i = (b - d) * (b - d), j = f * f;
        return 1 >= g / h + i / j ? !0 : !1
    }

    function j(b, d, e, f) {
        return 0 > b && (b = 0), 0 > d && (d = 0), b > a(c).width() - e && (b = a(c).width() - e), d > a(c).height() - f && (d = a(c).height() - f), {
            x: b,
            y: d
        }
    }

    function k(a) {
        for (var b, c, d = a.length; 0 !== d;)c = Math.floor(Math.random() * d), d -= 1, b = a[d], a[d] = a[c], a[c] = b;
        return a
    }

    function l() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? !0 : !1
    }

    a.imageMapProInitialized = function (a) {
    }, a.imageMapProEventHighlightedShape = function (a, b) {
    }, a.imageMapProEventUnhighlightedShape = function (a, b) {
    }, a.imageMapProEventClickedShape = function (a, b) {
    }, a.imageMapProEventOpenedTooltip = function (a, b) {
    }, a.imageMapProEventClosedTooltip = function (a) {
    }, a.imageMapProHighlightShape = function (b, c) {
        var d = a("#" + c).data("index");
        p[b].highlightedShapeIndex != d && (p[b].highlightedShape && p[b].unhighlightShape(), p[b].manuallyHighlightedShape = !0, p[b].highlightShape(d, !1))
    }, a.imageMapProUnhighlightShape = function (a) {
        p[a].highlightedShape && p[a].unhighlightShape()
    }, a.imageMapProOpenTooltip = function (b, c) {
        var d = a("#" + c).data("index");
        p[b].manuallyShownTooltip = !0, p[b].showTooltip(d), p[b].updateTooltipPosition(d)
    }, a.imageMapProHideTooltip = function (a) {
        p[a].hideTooltip()
    }, a.imageMapProReInitMap = function (a) {
        p[a].init()
    }, a.imageMapProIsMobile = function () {
        return l()
    };
    var m = "imageMapPro", n = {
        id: Math.round(1e4 * Math.random()) + 1,
        editor: {previewMode: 0, selected_shape: -1, tool: "spot"},
        general: {
            name: "",
            shortcode: "",
            width: 1050,
            height: 700,
            responsive: 1,
            sticky_tooltips: 0,
            constrain_tooltips: 1,
            image_url: "https://webcraftplugins.com/uploads/image-map-pro/demo.jpg",
            tooltip_animation: "grow",
            pageload_animation: "none",
            fullscreen_tooltips: "none",
            late_initialization: 0
        },
        spots: []
    }, o = {
        id: "spot-0",
        type: "spot",
        x: -1,
        y: -1,
        width: 44,
        height: 44,
        actions: {mouseover: "show-tooltip", click: "no-action", link: "#", open_link_in_new_window: 1},
        default_style: {
            opacity: 1,
            border_radius: 50,
            background_color: "#000000",
            background_opacity: .4,
            border_width: 0,
            border_style: "solid",
            border_color: "#ffffff",
            border_opacity: 1,
            fill: "#000000",
            fill_opacity: .4,
            stroke_color: "#ffffff",
            stroke_opacity: .75,
            stroke_width: 0,
            stroke_dasharray: "10 10",
            stroke_linecap: "round",
            use_icon: 0,
            icon_type: "library",
            icon_svg_path: "M409.81,160.113C409.79,71.684,338.136,0,249.725,0C161.276,0,89.583,71.684,89.583,160.113     c0,76.325,119.274,280.238,151.955,334.638c1.72,2.882,4.826,4.641,8.178,4.641c3.351,0,6.468-1.759,8.168-4.631     C290.545,440.361,409.81,236.438,409.81,160.113z M249.716,283.999c-68.303,0-123.915-55.573-123.915-123.895     c0-68.313,55.592-123.895,123.915-123.895s123.876,55.582,123.876,123.895S318.029,283.999,249.716,283.999z",
            icon_svg_viewbox: "0 0 499.392 499.392",
            icon_fill: "#000000",
            icon_url: "",
            icon_is_pin: 0,
            icon_shadow: 0
        },
        mouseover_style: {
            opacity: 1,
            border_radius: 50,
            background_color: "#ffffff",
            background_opacity: .4,
            border_width: 0,
            border_style: "solid",
            border_color: "#ffffff",
            border_opacity: 1,
            fill: "#ffffff",
            fill_opacity: .4,
            stroke_color: "#ffffff",
            stroke_opacity: .75,
            stroke_width: 0,
            stroke_dasharray: "10 10",
            stroke_linecap: "round",
            icon_fill: "#000000"
        },
        tooltip_style: {
            border_radius: 5,
            padding: 20,
            background_color: "#000000",
            background_opacity: .9,
            position: "top",
            width: 300,
            auto_width: 0
        },
        tooltip_content: {
            content_type: "plain-text",
            plain_text: "Lorem Ipsum",
            plain_text_color: "#ffffff",
            squares_json: '{"containers":[{"id":"sq-container-403761","settings":{"elements":[{"settings":{"name":"Paragraph","iconClass":"fa fa-paragraph"}}]}}]}',
            squares_content: '<div class="squares-container"><div id="sq-element-725001" class="squares-element col-lg-12 " style="margin-top: 0px; margin-bottom: 0px; margin-left: 0px; margin-right: 0px; padding-top: 10px; padding-bottom: 10px; padding-left: 10px; padding-right: 10px; float: left; font-family: sans-serif; font-size: 14px; font-weight: normal; font-style: normal; line-height: 22px; color: #ffffff; text-align: left; text-decoration: none; text-transform: none; background-color: rgba(255, 255, 255, 0); opacity: 1; box-shadow: none; border-width: 0px; border-style: none; border-color: rgba(0, 0, 0, 1); border-radius: 0px; "><p id="" style="" class="">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p></div><div class="squares-clear"></div></div>'
        },
        points: [],
        vs: []
    }, p = new Array;
    MutationObserver = b.MutationObserver || b.WebKitMutationObserver;
    var q;
    a.extend(e.prototype, {
        init: function () {
            var c = this;
            p[this.settings.general.name] = this, this.id = 100 * Math.random();
            for (var d = 0; d < c.settings.spots.length; d++) {
                var e = c.settings.spots[d], f = a.extend(!0, {}, o);
                e = a.extend(!0, f, e), c.settings.spots[d] = a.extend(!0, {}, e)
            }
            c.root.addClass("imp-initialized"), c.root.html('<div class="imp-wrap"></div>'), c.wrap = c.root.find(".imp-wrap");
            var g = new Image;
            g.src = c.settings.general.image_url, c.loadImage(g, function () {
            }, function () {
                var b = "";
                b += '<img src="' + c.settings.general.image_url + '">', c.wrap.html(b), c.adjustSize(), c.drawShapes(), c.addTooltips(), c.events(), c.animateShapesLoop(), a.imageMapProInitialized(c.settings.general.name)
            }), a(b).on("resize", function () {
                c.adjustSize()
            })
        }, loadImage: function (b, c, e) {
            b.complete && b.naturalWidth !== d && b.naturalHeight !== d ? e() : (c(), a(b).on("load", function () {
                a(b).off("load"), e()
            }))
        }, adjustSize: function () {
            var a = this;
            if (1 == parseInt(a.settings.general.responsive, 10)) {
                for (var b = a.root.width(), c = a.root; 0 == b && (c = c.parent(), b = c.width(), !c.is("body")););
                var d = a.settings.general.width / a.settings.general.height;
                a.wrap.css({width: b, height: b / d})
            } else a.wrap.css({width: a.settings.general.width, height: a.settings.general.height})
        }, drawShapes: function () {
            for (var a = this, b = 0; b < a.settings.spots.length; b++) {
                var c = a.settings.spots[b];
                if (c.x = parseFloat(c.x), c.y = parseFloat(c.y), c.width = parseFloat(c.width), c.height = parseFloat(c.height), c.default_style.stroke_width = parseInt(c.default_style.stroke_width), c.mouseover_style.stroke_width = parseInt(c.mouseover_style.stroke_width), "poly" == c.type)for (var d = 0; d < c.points.length; d++)c.points[d].x = parseFloat(c.points[d].x), c.points[d].y = parseFloat(c.points[d].y)
            }
            a.settings.general.width = parseInt(a.settings.general.width), a.settings.general.height = parseInt(a.settings.general.height), a.wrap.prepend('<div class="imp-shape-container"></div>'), a.shapeContainer = a.wrap.find(".imp-shape-container");
            for (var e = "", g = !1, h = '<svg class="hs-poly-svg" viewBox="0 0 ' + a.settings.general.width + " " + a.settings.general.height + '" preserveAspectRatio="none">', b = 0; b < a.settings.spots.length; b++) {
                var c = a.settings.spots[b];
                if ("spot" == c.type)if (1 == parseInt(c.default_style.use_icon, 10)) {
                    var i = "";
                    if (i += "left: " + c.x + "%;", i += "top: " + c.y + "%;", i += "width: " + c.width + "px;", i += "height: " + c.height + "px;", i += "margin-left: -" + c.width / 2 + "px;", i += 1 == parseInt(c.default_style.icon_is_pin, 10) ? "margin-top: -" + c.height + "px;" : "margin-top: -" + c.height / 2 + "px;", i += "background-image: url(" + c.default_style.icon_url + ")", i += "background-position: center;", i += "background-repeat: no-repeat;", "fade" == a.settings.general.pageload_animation && (i += "opacity: 0;"), "grow" == a.settings.general.pageload_animation && (i += "opacity: " + c.default_style.opacity + ";", i += "transform: scale(0, 0);-moz-transform: scale(0, 0);-webkit-transform: scale(0, 0);", 1 == parseInt(c.default_style.icon_is_pin, 10) && (i += "transform-origin: 50% 100%;-moz-transform-origin: 50% 100%;-webkit-transform-origin: 50% 100%;")), "none" == a.settings.general.pageload_animation && (i += "opacity: " + c.default_style.opacity + ";"), e += '<div class="imp-shape imp-shape-spot" id="' + c.id + '" style="' + i + '" data-index=' + b + ">", "library" == c.default_style.icon_type ? (e += '   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="' + c.default_style.icon_svg_viewbox + '" xml:space="preserve" width="' + c.width + 'px" height="' + c.height + 'px">', e += '       <path style="fill:' + c.default_style.icon_fill + '" d="' + c.default_style.icon_svg_path + '"></path>', e += "   </svg>") : e += '<img src="' + c.default_style.icon_url + '">', 1 == parseInt(c.default_style.icon_shadow, 10)) {
                        var j = "";
                        j += "width: " + c.width + "px;", j += "height: " + c.height + "px;", j += "top: " + c.height / 2 + "px;", e += '<div style="' + j + '" class="imp-shape-icon-shadow"></div>'
                    }
                    e += "</div>"
                } else {
                    var i = "", k = f(c.default_style.background_color), l = f(c.default_style.border_color);
                    i += "left: " + c.x + "%;", i += "top: " + c.y + "%;", i += "width: " + c.width + "px;", i += "height: " + c.height + "px;", i += "margin-left: -" + c.width / 2 + "px;", i += "margin-top: -" + c.height / 2 + "px;", i += "border-radius: " + c.default_style.border_radius + "px;", i += "background: rgba(" + k.r + ", " + k.g + ", " + k.b + ", " + c.default_style.background_opacity + ");", i += "border-width: " + c.default_style.border_width + "px;", i += "border-style: " + c.default_style.border_style + ";", i += "border-color: rgba(" + l.r + ", " + l.g + ", " + l.b + ", " + c.default_style.border_opacity + ");", "fade" == a.settings.general.pageload_animation && (i += "opacity: 0;"), "grow" == a.settings.general.pageload_animation && (i += "opacity: " + c.default_style.opacity + ";", i += "transform: scale(0, 0);-moz-transform: scale(0, 0);-webkit-transform: scale(0, 0);"), "none" == a.settings.general.pageload_animation && (i += "opacity: " + c.default_style.opacity + ";"), e += '<div class="imp-shape imp-shape-spot" id="' + c.id + '" style="' + i + '" data-index=' + b + "></div>"
                }
                if ("rect" == c.type) {
                    var i = "", k = f(c.default_style.background_color), l = f(c.default_style.border_color);
                    i += "left: " + c.x + "%;", i += "top: " + c.y + "%;", i += "width: " + c.width + "%;", i += "height: " + c.height + "%;", i += "border-radius: " + c.default_style.border_radius + "px;", i += "background: rgba(" + k.r + ", " + k.g + ", " + k.b + ", " + c.default_style.background_opacity + ");", i += "border-width: " + c.default_style.border_width + "px;", i += "border-style: " + c.default_style.border_style + ";", i += "border-color: rgba(" + l.r + ", " + l.g + ", " + l.b + ", " + c.default_style.border_opacity + ");", "fade" == a.settings.general.pageload_animation && (i += "opacity: 0;"), "grow" == a.settings.general.pageload_animation && (i += "opacity: " + c.default_style.opacity + ";", i += "transform: scale(0, 0);-moz-transform: scale(0, 0);-webkit-transform: scale(0, 0);"), "none" == a.settings.general.pageload_animation && (i += "opacity: " + c.default_style.opacity + ";"), e += '<div class="imp-shape imp-shape-rect" id="' + c.id + '" style="' + i + '" data-index=' + b + "></div>"
                }
                if ("oval" == c.type) {
                    var i = "", k = f(c.default_style.background_color), l = f(c.default_style.border_color);
                    i += "left: " + c.x + "%;", i += "top: " + c.y + "%;", i += "width: " + c.width + "%;", i += "height: " + c.height + "%;", i += "border-radius: 50% 50%;", i += "background: rgba(" + k.r + ", " + k.g + ", " + k.b + ", " + c.default_style.background_opacity + ");", i += "border-width: " + c.default_style.border_width + "px;", i += "border-style: " + c.default_style.border_style + ";", i += "border-color: rgba(" + l.r + ", " + l.g + ", " + l.b + ", " + c.default_style.border_opacity + ");", "fade" == a.settings.general.pageload_animation && (i += "opacity: 0;"), "grow" == a.settings.general.pageload_animation && (i += "opacity: " + c.default_style.opacity + ";", i += "transform: scale(0, 0);-moz-transform: scale(0, 0);-webkit-transform: scale(0, 0);"), "none" == a.settings.general.pageload_animation && (i += "opacity: " + c.default_style.opacity + ";"), e += '<div class="imp-shape imp-shape-oval" id="' + c.id + '" style="' + i + '" data-index=' + b + "></div>"
                }
                if ("poly" == c.type) {
                    g = !0;
                    var m = f(c.default_style.fill), n = f(c.default_style.stroke_color), o = "";
                    if (o += "width: 100%;", o += "height: 100%;", o += "fill: rgba(" + m.r + ", " + m.g + ", " + m.b + ", " + c.default_style.fill_opacity + ");", o += "stroke: rgba(" + n.r + ", " + n.g + ", " + n.b + ", " + c.default_style.stroke_opacity + ");", o += "stroke-width: " + c.default_style.stroke_width + "px;", o += "stroke-dasharray: " + c.default_style.stroke_dasharray + ";", o += "stroke-linecap: " + c.default_style.stroke_linecap + ";", "fade" == a.settings.general.pageload_animation && (o += "opacity: 0;"), "grow" == a.settings.general.pageload_animation) {
                        o += "opacity: " + c.default_style.opacity + ";", o += "transform: scale(0, 0);-moz-transform: scale(0, 0);-webkit-transform: scale(0, 0);";
                        var p = c.x + c.width / 2, q = c.y + c.height / 2;
                        o += "transform-origin: " + p + "% " + q + "%;-moz-transform-origin: " + p + "% " + q + "%;-webkit-transform-origin: " + p + "% " + q + "%;"
                    }
                    "none" == a.settings.general.pageload_animation && (o += "opacity: " + c.default_style.opacity + ";");
                    var r = a.settings.general.width * (c.width / 100), s = a.settings.general.height * (c.height / 100);
                    h += '           <polygon class="imp-shape imp-shape-poly" style="' + o + '" data-index=' + b + ' id="' + c.id + '" points="', c.vs = new Array;
                    for (var d = 0; d < c.points.length; d++) {
                        var t = a.settings.general.width * (c.x / 100) + c.points[d].x / 100 * r, u = a.settings.general.height * (c.y / 100) + c.points[d].y / 100 * s;
                        h += t + "," + u + " ", c.vs.push([t, u])
                    }
                    h += '           "></polygon>'
                }
            }
            h += "</svg>", g ? a.shapeContainer.html(e + h) : a.shapeContainer.html(e)
        }, addTooltips: function () {
            var b = this;
            if ("always" == b.settings.general.fullscreen_tooltips || "mobile-only" == b.settings.general.fullscreen_tooltips && l()) {
                b.fullscreenTooltipsContainer || (a('.imp-fullscreen-tooltips-container[data-image-map-id="' + b.settings.id + '"]').remove(), a("body").prepend('<div class="imp-fullscreen-tooltips-container" data-image-map-id="' + b.settings.id + '"></div>'), b.fullscreenTooltipsContainer = a('.imp-fullscreen-tooltips-container[data-image-map-id="' + b.settings.id + '"]'));
                for (var c = "", d = 0; d < b.settings.spots.length; d++) {
                    var e = b.settings.spots[d];
                    e.tooltip_content.plain_text = e.tooltip_content.plain_text.replace(/\n/g, "<br>");
                    var g = "", h = f(e.tooltip_style.background_color);
                    if (g += "padding: " + e.tooltip_style.padding + "px;", g += "background: rgba(" + h.r + ", " + h.g + ", " + h.b + ", " + e.tooltip_style.background_opacity + ");", "none" == b.settings.general.tooltip_animation && (g += "opacity: 0;"), "fade" == b.settings.general.tooltip_animation && (g += "opacity: 0;", g += "transition-property: opacity;-moz-transition-property: opacity;-webkit-transition-property: opacity;"), "grow" == b.settings.general.tooltip_animation && (g += "transform: scale(0, 0);-moz-transform: scale(0, 0);-webkit-transform: scale(0, 0);", g += "transition-property: transform;-moz-transition-property: -moz-transform;-webkit-transition-property: -webkit-transform;", g += "transform-origin: 50% 50%;-moz-transform-origin: 50% 50%;-webkit-transform-origin: 50% 50%;"), c += '<div class="imp-fullscreen-tooltip" style="' + g + '" data-index="' + d + '">', c += '   <div class="imp-tooltip-close-button" data-index="' + d + '"><i class="fa fa-times" aria-hidden="true"></i></div>', "plain-text" == e.tooltip_content.content_type) {
                        var g = "";
                        g += "color: " + e.tooltip_content.plain_text_color + ";", c += '<div class="imp-tooltip-plain-text" style="' + g + '">' + e.tooltip_content.plain_text + "</div>"
                    } else c += e.tooltip_content.squares_content;
                    c += "</div>"
                }
                b.fullscreenTooltipsContainer.html(c)
            } else {
                for (var c = "", d = 0; d < b.settings.spots.length; d++) {
                    var e = b.settings.spots[d];
                    e.tooltip_content.plain_text = e.tooltip_content.plain_text.replace(/\n/g, "<br>");
                    var g = "", h = f(e.tooltip_style.background_color), i = "poly" == e.type ? "imp-tooltip-buffer-large" : "";
                    if (g += "border-radius: " + e.tooltip_style.border_radius + "px;", g += "padding: " + e.tooltip_style.padding + "px;", g += "background: rgba(" + h.r + ", " + h.g + ", " + h.b + ", " + e.tooltip_style.background_opacity + ");", "none" == b.settings.general.tooltip_animation && (g += "opacity: 0;"), "fade" == b.settings.general.tooltip_animation && (g += "opacity: 0;", g += "transition-property: opacity;-moz-transition-property: opacity;-webkit-transition-property: opacity;"), "grow" == b.settings.general.tooltip_animation && (g += "transform: scale(0, 0);-moz-transform: scale(0, 0);-webkit-transform: scale(0, 0);", g += "transition-property: transform;-moz-transition-property: -moz-transform;-webkit-transition-property: -webkit-transform;", "top" == e.tooltip_style.position && (g += "transform-origin: 50% 100%;-moz-transform-origin: 50% 100%;-webkit-transform-origin: 50% 100%;"), "bottom" == e.tooltip_style.position && (g += "transform-origin: 50% 0%;-moz-transform-origin: 50% 0%;-webkit-transform-origin: 50% 0%;"), "left" == e.tooltip_style.position && (g += "transform-origin: 100% 50%;-moz-transform-origin: 100% 50%;-webkit-transform-origin: 100% 50%;"), "right" == e.tooltip_style.position && (g += "transform-origin: 0% 50%;-moz-transform-origin: 0% 50%;-webkit-transform-origin: 0% 50%;")), c += '<div class="imp-tooltip" style="' + g + '" data-index="' + d + '">', "top" == e.tooltip_style.position && (c += '   <div class="hs-arrow hs-arrow-bottom" style="border-top-color: rgba(' + h.r + ", " + h.g + ", " + h.b + ", " + e.tooltip_style.background_opacity + ');"></div>', 0 == parseInt(b.settings.general.sticky_tooltips, 10) && (c += '   <div class="imp-tooltip-buffer imp-tooltip-buffer-bottom ' + i + '"></div>')), "bottom" == e.tooltip_style.position && (c += '   <div class="hs-arrow hs-arrow-top" style="border-bottom-color: rgba(' + h.r + ", " + h.g + ", " + h.b + ", " + e.tooltip_style.background_opacity + ');"></div>', 0 == parseInt(b.settings.general.sticky_tooltips, 10) && (c += '   <div class="imp-tooltip-buffer imp-tooltip-buffer-top ' + i + '"></div>')), "left" == e.tooltip_style.position && (c += '   <div class="hs-arrow hs-arrow-right" style="border-left-color: rgba(' + h.r + ", " + h.g + ", " + h.b + ", " + e.tooltip_style.background_opacity + ');"></div>', 0 == parseInt(b.settings.general.sticky_tooltips, 10) && (c += '   <div class="imp-tooltip-buffer imp-tooltip-buffer-right ' + i + '"></div>')), "right" == e.tooltip_style.position && (c += '   <div class="hs-arrow hs-arrow-left" style="border-right-color: rgba(' + h.r + ", " + h.g + ", " + h.b + ", " + e.tooltip_style.background_opacity + ');"></div>', 0 == parseInt(b.settings.general.sticky_tooltips, 10) && (c += '   <div class="imp-tooltip-buffer imp-tooltip-buffer-left ' + i + '"></div>')), "plain-text" == e.tooltip_content.content_type) {
                        var g = "";
                        g += "color: " + e.tooltip_content.plain_text_color + ";", c += '<div class="imp-tooltip-plain-text" style="' + g + '">' + e.tooltip_content.plain_text + "</div>"
                    } else c += e.tooltip_content.squares_content;
                    c += "</div>"
                }
                b.wrap.prepend(c)
            }
        }, measureTooltipSize: function (a) {
            if (!("always" == this.settings.general.fullscreen_tooltips || "mobile" == this.settings.general.fullscreen_tooltips && l())) {
                var b = this.settings.spots[a], c = this.wrap.find('.imp-tooltip[data-index="' + a + '"]');
                0 == parseInt(b.tooltip_style.auto_width, 10) && c.css({width: b.tooltip_style.width}), c.data("imp-measured-width", c.outerWidth()), c.data("imp-measured-height", c.outerHeight())
            }
        }, animateShapesLoop: function () {
            if ("none" != this.settings.general.pageload_animation)for (var a = 750 / this.settings.spots.length, b = k(this.settings.spots.slice()), c = 0; c < b.length; c++)this.animateShape(b[c], a * c)
        }, animateShape: function (b, c) {
            var d = this, e = a("#" + b.id);
            setTimeout(function () {
                "fade" == d.settings.general.pageload_animation && e.css({opacity: b.default_style.opacity}), "grow" == d.settings.general.pageload_animation && e.css({
                    transform: "scale(1, 1)",
                    "-moz-transform": "scale(1, 1)",
                    "-webkit-transform": "scale(1, 1)"
                })
            }, c)
        }, events: function () {
            var b = this;
            this.wrap.off("mousemove"), this.wrap.on("mousemove", function (a) {
                b.touch || b.handleEventMove(a)
            }), this.wrap.off("mouseup"), this.wrap.on("mouseup", function (a) {
                b.touch || b.handleEventEnd(a)
            }), this.wrap.off("touchstart"), this.wrap.on("touchstart", function (a) {
                b.touch = !0, b.handleEventMove(a)
            }), this.wrap.off("touchmove"), this.wrap.on("touchmove", function (a) {
                b.handleEventMove(a)
            }), this.wrap.off("touchend"), this.wrap.on("touchend", function (a) {
                b.handleEventEnd(a)
            }), a(c).off("mousemove." + this.settings.id), a(c).on("mousemove." + this.settings.id, function (c) {
                b.touch || b.manuallyHighlightedShape || b.manuallyShownTooltip || 0 == a(c.target).closest(".imp-wrap").length && 0 == a(c.target).closest(".imp-fullscreen-tooltips-container").length && (b.visibleTooltip && b.hideTooltip(), b.clickedShape && b.unclickShape(), b.highlightedShape && b.unhighlightShape())
            }), a(c).off("touchstart." + this.settings.id), a(c).on("touchstart." + this.settings.id, function (c) {
                b.manuallyHighlightedShape || b.manuallyShownTooltip || 0 == a(c.target).closest(".imp-wrap").length && 0 == a(c.target).closest(".imp-fullscreen-tooltips-container").length && (b.visibleTooltip && b.hideTooltip(), b.clickedShape && b.unclickShape(), b.highlightedShape && b.unhighlightShape())
            }), a(c).off("click." + this.settings.id, ".imp-tooltip-close-button"), a(c).on("click." + this.settings.id, ".imp-tooltip-close-button", function () {
                b.hideTooltip(), b.clickedShape && b.unclickShape(), b.highlightedShape && b.unhighlightShape()
            }), 1 == parseInt(this.settings.general.late_initialization, 10) ? q || (q = new MutationObserver(function (c, d) {
                clearTimeout(b.initTimeout), b.initTimeout = setTimeout(function () {
                    for (var d = 0; d < c.length; d++)if (0 == a(c[d].target).closest(".imp-initialized").length && !a(c[d].target).hasClass("imp-initialized")) {
                        b.init();
                        break
                    }
                }, 50)
            }), q.observe(c, {subtree: !0, attributes: !0})) : q && (q.disconnect(), q = d)
        }, handleEventMove: function (b) {
            if (!this.fullscreenTooltipVisible && (0 == a(b.target).closest(".imp-tooltip").length && !a(b.target).hasClass("imp-tooltip") || 0 != parseInt(this.settings.general.sticky_tooltips, 10))) {
                (this.manuallyHighlightedShape || this.manuallyShownTooltip) && (this.manuallyHighlightedShape = !1, this.manuallyShownTooltip = !1);
                var c = this.getEventRelativeCoordinates(b), d = this.matchShapeToCoords(c);
                console.log(c);
                -1 != d && d != this.highlightedShapeIndex ? (this.highlightedShape && this.highlightedShapeIndex != this.clickedShapeIndex && this.unhighlightShape(), this.highlightShape(d, !0)) : -1 == d && this.highlightedShape && this.highlightedShapeIndex != this.clickedShapeIndex && this.unhighlightShape(), this.highlightedShape && this.visibleTooltipIndex != this.highlightedShapeIndex ? (this.clickedShape && this.unclickShape(), this.visibleTooltip && this.hideTooltip(), "show-tooltip" == this.highlightedShape.actions.mouseover && (this.showTooltip(this.highlightedShapeIndex), this.updateTooltipPosition(d, b))) : !this.visibleTooltip || this.highlightedShape || this.clickedShape || this.visibleTooltip && this.hideTooltip(), this.visibleTooltip && this.highlightedShape && 1 == parseInt(this.settings.general.sticky_tooltips, 10) && "show-tooltip" == this.highlightedShape.actions.mouseover && this.updateTooltipPosition(this.highlightedShapeIndex, b)
            }
        }, handleEventEnd: function (b) {
            if (!this.fullscreenTooltipVisible) {
                (this.manuallyHighlightedShape || this.manuallyShownTooltip) && (this.manuallyHighlightedShape = !1, this.manuallyShownTooltip = !1);
                var c = this.getEventRelativeCoordinates(b), d = this.matchShapeToCoords(c);
                if (-1 != d && d != this.clickedShapeIndex)this.clickedShape && this.unclickShape(), this.clickShape(d, b); else if (-1 == d && this.clickedShape) {
                    if (0 != a(b.target).closest(".imp-tooltip").length)return;
                    this.unclickShape()
                }
            }
        }, getEventRelativeCoordinates: function (c) {
            var d, e;
            if ("touchstart" == c.type || "touchmove" == c.type || "touchend" == c.type || "touchcancel" == c.type) {
                var f = c.originalEvent.touches[0] || c.originalEvent.changedTouches[0];
                d = f.pageX, e = f.pageY
            } else("mousedown" == c.type || "mouseup" == c.type || "mousemove" == c.type || "mouseover" == c.type || "mouseout" == c.type || "mouseenter" == c.type || "mouseleave" == c.type) && (d = c.pageX, e = c.pageY);
            //return d -= this.wrap.offset().left - a(b).scrollLeft(), e -= this.wrap.offset().top - a(b).scrollTop(), d = d / this.wrap.width() * 100, e = e / this.wrap.height() * 100, {
            //    x: d,
            //    y: e
            //}
            return d -= this.wrap.offset().left - a(b).scrollLeft(), e -= this.wrap.offset().top, d = d / this.wrap.width() * 100, e = e / this.wrap.height() * 100, {
                x: d,
                y: e
            }
        }, getEventCoordinates: function (a) {
            var b, c;
            if ("touchstart" == a.type || "touchmove" == a.type || "touchend" == a.type || "touchcancel" == a.type) {
                var d = a.originalEvent.touches[0] || a.originalEvent.changedTouches[0];
                b = d.pageX, c = d.pageY
            } else("mousedown" == a.type || "mouseup" == a.type || "mousemove" == a.type || "mouseover" == a.type || "mouseout" == a.type || "mouseenter" == a.type || "mouseleave" == a.type) && (b = a.pageX, c = a.pageY);
            return {x: b, y: c}
        }, matchShapeToCoords: function (a) {
            for (var b = 0; b < this.settings.spots.length; b++) {
                var c = this.settings.spots[b];
                if ("poly" == c.type) {
                    var d = a.x / 100 * this.wrap.width(), e = a.y / 100 * this.wrap.height();
                    if (d = d * this.settings.general.width / this.wrap.width(), e = e * this.settings.general.height / this.wrap.height(), h(d, e, c.vs))return b
                }
                if ("spot" == c.type) {
                    var d = a.x / 100 * this.wrap.width(), e = a.y / 100 * this.wrap.height(), f = c.x / 100 * this.wrap.width() - c.width / 2, j = c.y / 100 * this.wrap.height() - c.height / 2, k = c.width, l = c.height;
                    if (1 == parseInt(c.default_style.icon_is_pin, 10) && (j -= c.height / 2), g(d, e, f, j, k, l))return b
                }
                if ("rect" == c.type && g(a.x, a.y, c.x, c.y, c.width, c.height))return b;
                if ("oval" == c.type) {
                    var d = a.x, e = a.y, m = c.x + c.width / 2, n = c.y + c.height / 2, f = c.width / 2, j = c.height / 2;
                    if (i(d, e, m, n, f, j))return b
                }
            }
            return -1
        }, applyMouseoverStyles: function (a) {
            var b = this, c = b.settings.spots[a], d = this.wrap.find("#" + c.id), e = "";
            if ("spot" == c.type && 0 == parseInt(c.default_style.use_icon, 10)) {
                var g = f(c.mouseover_style.background_color), h = f(c.mouseover_style.border_color);
                e += "left: " + c.x + "%;", e += "top: " + c.y + "%;", e += "width: " + c.width + "px;", e += "height: " + c.height + "px;", e += "margin-left: -" + c.width / 2 + "px;", e += "margin-top: -" + c.height / 2 + "px;", e += "opacity: " + c.mouseover_style.opacity + ";", e += "border-radius: " + c.mouseover_style.border_radius + "px;", e += "background: rgba(" + g.r + ", " + g.g + ", " + g.b + ", " + c.mouseover_style.background_opacity + ");", e += "border-width: " + c.mouseover_style.border_width + "px;", e += "border-style: " + c.mouseover_style.border_style + ";", e += "border-color: rgba(" + h.r + ", " + h.g + ", " + h.b + ", " + c.mouseover_style.border_opacity + ");"
            }
            if ("spot" == c.type && 1 == parseInt(c.default_style.use_icon, 10) && (e += "left: " + c.x + "%;", e += "top: " + c.y + "%;", e += "width: " + c.width + "px;", e += "height: " + c.height + "px;", e += "margin-left: -" + c.width / 2 + "px;", e += 1 == parseInt(c.default_style.icon_is_pin, 10) ? "margin-top: -" + c.height + "px;" : "margin-top: -" + c.height / 2 + "px;", e += "opacity: " + c.mouseover_style.opacity + ";"), "spot" == c.type && 1 == parseInt(c.default_style.use_icon, 10) && "library" == c.default_style.icon_type && d.find("path").attr("style", "fill:" + c.mouseover_style.icon_fill), "rect" == c.type) {
                var g = f(c.mouseover_style.background_color), h = f(c.mouseover_style.border_color);
                e += "left: " + c.x + "%;", e += "top: " + c.y + "%;", e += "width: " + c.width + "%;", e += "height: " + c.height + "%;", e += "opacity: " + c.mouseover_style.opacity + ";", e += "border-radius: " + c.mouseover_style.border_radius + "px;", e += "background: rgba(" + g.r + ", " + g.g + ", " + g.b + ", " + c.mouseover_style.background_opacity + ");", e += "border-width: " + c.mouseover_style.border_width + "px;", e += "border-style: " + c.mouseover_style.border_style + ";", e += "border-color: rgba(" + h.r + ", " + h.g + ", " + h.b + ", " + c.mouseover_style.border_opacity + ");"
            }
            if ("oval" == c.type) {
                var g = f(c.mouseover_style.background_color), h = f(c.mouseover_style.border_color);
                e += "left: " + c.x + "%;", e += "top: " + c.y + "%;", e += "width: " + c.width + "%;", e += "height: " + c.height + "%;", e += "opacity: " + c.mouseover_style.opacity + ";", e += "border-radius: 50% 50%;", e += "background: rgba(" + g.r + ", " + g.g + ", " + g.b + ", " + c.mouseover_style.background_opacity + ");", e += "border-width: " + c.mouseover_style.border_width + "px;", e += "border-style: " + c.mouseover_style.border_style + ";", e += "border-color: rgba(" + h.r + ", " + h.g + ", " + h.b + ", " + c.mouseover_style.border_opacity + ");"
            }
            if ("poly" == c.type) {
                var i = f(c.mouseover_style.fill), j = f(c.mouseover_style.stroke_color);
                e += "opacity: " + c.mouseover_style.opacity + ";", e += "fill: rgba(" + i.r + ", " + i.g + ", " + i.b + ", " + c.mouseover_style.fill_opacity + ");", e += "stroke: rgba(" + j.r + ", " + j.g + ", " + j.b + ", " + c.mouseover_style.stroke_opacity + ");", e += "stroke-width: " + c.mouseover_style.stroke_width + "px;", e += "stroke-dasharray: " + c.mouseover_style.stroke_dasharray + ";", e += "stroke-linecap: " + c.mouseover_style.stroke_linecap + ";"
            }
            d.attr("style", e)
        }, applyDefaultStyles: function (a) {
            var b = this, c = b.settings.spots[a], d = this.wrap.find("#" + c.id), e = "";
            if ("spot" == c.type && 0 == parseInt(c.default_style.use_icon, 10)) {
                var g = f(c.default_style.background_color), h = f(c.default_style.border_color);
                e += "left: " + c.x + "%;", e += "top: " + c.y + "%;", e += "width: " + c.width + "px;", e += "height: " + c.height + "px;", e += "margin-left: -" + c.width / 2 + "px;", e += "margin-top: -" + c.height / 2 + "px;", e += "opacity: " + c.default_style.opacity + ";", e += "border-radius: " + c.default_style.border_radius + "px;", e += "background: rgba(" + g.r + ", " + g.g + ", " + g.b + ", " + c.default_style.background_opacity + ");", e += "border-width: " + c.default_style.border_width + "px;", e += "border-style: " + c.default_style.border_style + ";", e += "border-color: rgba(" + h.r + ", " + h.g + ", " + h.b + ", " + c.default_style.border_opacity + ");"
            }
            if ("spot" == c.type && 1 == parseInt(c.default_style.use_icon, 10) && (e += "left: " + c.x + "%;", e += "top: " + c.y + "%;", e += "width: " + c.width + "px;", e += "height: " + c.height + "px;", e += "margin-left: -" + c.width / 2 + "px;", e += 1 == parseInt(c.default_style.icon_is_pin, 10) ? "margin-top: -" + c.height + "px;" : "margin-top: -" + c.height / 2 + "px;", e += "opacity: " + c.default_style.opacity + ";"), "spot" == c.type && 1 == parseInt(c.default_style.use_icon, 10) && "library" == c.default_style.icon_type && d.find("path").attr("style", "fill:" + c.default_style.icon_fill), "rect" == c.type) {
                var g = f(c.default_style.background_color), h = f(c.default_style.border_color);
                e += "left: " + c.x + "%;", e += "top: " + c.y + "%;", e += "width: " + c.width + "%;", e += "height: " + c.height + "%;", e += "opacity: " + c.default_style.opacity + ";", e += "border-radius: " + c.default_style.border_radius + "px;", e += "background: rgba(" + g.r + ", " + g.g + ", " + g.b + ", " + c.default_style.background_opacity + ");", e += "border-width: " + c.default_style.border_width + "px;", e += "border-style: " + c.default_style.border_style + ";", e += "border-color: rgba(" + h.r + ", " + h.g + ", " + h.b + ", " + c.default_style.border_opacity + ");"
            }
            if ("oval" == c.type) {
                var g = f(c.default_style.background_color), h = f(c.default_style.border_color);
                e += "left: " + c.x + "%;", e += "top: " + c.y + "%;", e += "width: " + c.width + "%;", e += "height: " + c.height + "%;", e += "opacity: " + c.default_style.opacity + ";", e += "border-radius: 50% 50%;", e += "background: rgba(" + g.r + ", " + g.g + ", " + g.b + ", " + c.default_style.background_opacity + ");", e += "border-width: " + c.default_style.border_width + "px;", e += "border-style: " + c.default_style.border_style + ";", e += "border-color: rgba(" + h.r + ", " + h.g + ", " + h.b + ", " + c.default_style.border_opacity + ");"
            }
            if ("poly" == c.type) {
                var i = f(c.default_style.fill), j = f(c.default_style.stroke_color);
                e += "opacity: " + c.default_style.opacity + ";", e += "fill: rgba(" + i.r + ", " + i.g + ", " + i.b + ", " + c.default_style.fill_opacity + ");", e += "stroke: rgba(" + j.r + ", " + j.g + ", " + j.b + ", " + c.default_style.stroke_opacity + ");", e += "stroke-width: " + c.default_style.stroke_width + "px;", e += "stroke-dasharray: " + c.default_style.stroke_dasharray + ";", e += "stroke-linecap: " + c.default_style.stroke_linecap + ";"
            }
            d.attr("style", e)
        }, highlightShape: function (b, c) {
            console.log('b = ' + b + ', c = ' + c);
            this.applyMouseoverStyles(b), this.highlightedShapeIndex = b, this.highlightedShape = this.settings.spots[b], c && a.imageMapProEventHighlightedShape(this.settings.general.name, this.highlightedShape.id)
        }, unhighlightShape: function () {
            this.applyDefaultStyles(this.highlightedShapeIndex), a.imageMapProEventUnhighlightedShape(this.settings.general.name, this.highlightedShape.id), this.highlightedShapeIndex = d, this.highlightedShape = d
        }, clickShape: function (b, c) {
            "show-tooltip" == this.settings.spots[b].actions.click && (this.applyMouseoverStyles(b), this.showTooltip(b), this.updateTooltipPosition(b, c), this.clickedShapeIndex = b, this.clickedShape = this.settings.spots[b]), "follow-link" == this.settings.spots[b].actions.click && (0 == a("#imp-temp-link").length && a("body").append('<a href="" id="imp-temp-link" target="_blank"></a>'), a("#imp-temp-link").attr("href", this.settings.spots[b].actions.link), 1 == parseInt(this.settings.spots[b].actions.open_link_in_new_window, 10) ? a("#imp-temp-link").attr("target", "_blank") : a("#imp-temp-link").removeAttr("target"), a("#imp-temp-link")[0].click()), a.imageMapProEventClickedShape(this.settings.spots[b].id)
        }, unclickShape: function () {
            this.applyDefaultStyles(this.clickedShapeIndex), "show-tooltip" == this.clickedShape.actions.click && this.hideTooltip(), this.clickedShapeIndex = d, this.clickedShape = d
        }, showTooltip: function (b) {
            if ("mobile-only" == this.settings.general.fullscreen_tooltips && l() || "always" == this.settings.general.fullscreen_tooltips) {
                this.visibleTooltip = a('.imp-fullscreen-tooltip[data-index="' + b + '"]'), this.visibleTooltipIndex = b, this.fullscreenTooltipsContainer.show();
                var c = this;
                setTimeout(function () {
                    c.visibleTooltip.addClass("imp-tooltip-visible")
                }, 20), this.fullscreenTooltipVisible = !0
            } else {     console.log('test'); console.log(b);  a(".imp-tooltip-visible").removeClass("imp-tooltip-visible"), this.visibleTooltip = this.wrap.find('.imp-tooltip[data-index="' + b + '"]'), this.visibleTooltipIndex = b, this.visibleTooltip.addClass("imp-tooltip-visible"), this.measureTooltipSize(b)};
            a.imageMapProEventOpenedTooltip(this.settings.general.name, this.settings.spots[b].id)
        }, hideTooltip: function () {
            if (a(".imp-tooltip-visible").removeClass("imp-tooltip-visible"), this.visibleTooltip = d, this.visibleTooltipIndex = d, "mobile-only" == this.settings.general.fullscreen_tooltips && l() || "always" == this.settings.general.fullscreen_tooltips) {
                var b = this;
                setTimeout(function () {
                    b.fullscreenTooltipsContainer.hide()
                }, 200), this.fullscreenTooltipVisible = !1
            }
            a.imageMapProEventClosedTooltip(this.settings.general.name)
        }, updateTooltipPosition: function (c, d) {
            if (!this.fullscreenTooltipVisible) {
                var e, f, g, h, i, k, l, m, n, o, p = 20;
                if (e = this.visibleTooltip, f = this.visibleTooltip.data("imp-measured-width"), g = this.visibleTooltip.data("imp-measured-height"), o = this.settings.spots[c], 1 == parseInt(this.settings.general.sticky_tooltips, 10) && "show-tooltip" == o.actions.mouseover && d) {
                    var q = this.getEventCoordinates(d);
                    m = q.x, n = q.y, h = m - this.wrap.offset().left, i = n - this.wrap.offset().top, k = 0, l = 0
                } else"spot" == o.type ? (k = o.width, l = o.height, h = Math.round(10 * o.x) / 10 / 100 * this.wrap.width() - k / 2, i = Math.round(10 * o.y) / 10 / 100 * this.wrap.height() - l / 2) : (k = o.width / 100 * this.wrap.width(), l = o.height / 100 * this.wrap.height(), h = Math.round(10 * o.x) / 10 / 100 * this.wrap.width(), i = Math.round(10 * o.y) / 10 / 100 * this.wrap.height());
                var r, s;
                "left" == o.tooltip_style.position && (r = h - f - p, s = i + l / 2 - g / 2), "right" == o.tooltip_style.position && (r = h + k + p, s = i + l / 2 - g / 2), "top" == o.tooltip_style.position && (r = h + k / 2 - f / 2, s = i - g - p), "bottom" == o.tooltip_style.position && (r = h + k / 2 - f / 2, s = i + l + p), "spot" == o.type && 1 == parseInt(o.default_style.icon_is_pin, 10) && (s -= l / 2);
                var t = {x: r, y: s};
                if (1 == parseInt(this.settings.general.constrain_tooltips, 10)) {
                    var u = this.wrap.offset().left - a(b).scrollLeft(), v = this.wrap.offset().top - a(b).scrollTop();
                    t = j(r + u, s + v, f, g), t.x -= u, t.y -= v
                }
                e.css({left: t.x, top: t.y})
            }
        }
    }), a.fn[m] = function (b) {
        return this.each(function () {
            a.data(this, "plugin_" + m, new e(this, b))
        })
    }
}(jQuery, window, document);


