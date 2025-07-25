function createBasicMap(e, a, l, s) {
    var i = new google.maps.LatLng(a, l),
        t = document.getElementById(e),
        o = {
            zoom: 14,
            scrollwheel: !1,
            center: i
        },
        n = new google.maps.Map(t, o);
    marker = new google.maps.Marker({
        position: i,
        map: n,
        icon: s
    })
}

function createSimpleMap(e, a, l, s) {
    var i = new google.maps.LatLng(a, l),
        t = document.getElementById(e),
        o = {
            zoom: 14,
            scrollwheel: !1,
            center: i,
            styles: [{
                featureType: "landscape",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }, {
                featureType: "transit",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }, {
                featureType: "poi",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }, {
                featureType: "water",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }, {
                featureType: "road",
                elementType: "labels.icon",
                stylers: [{
                    visibility: "off"
                }]
            }, {
                stylers: [{
                    hue: "#00aaff"
                }, {
                    saturation: -100
                }, {
                    gamma: 2.15
                }, {
                    lightness: 12
                }]
            }, {
                featureType: "road",
                elementType: "labels.text.fill",
                stylers: [{
                    visibility: "on"
                }, {
                    lightness: 24
                }]
            }, {
                featureType: "road",
                elementType: "geometry",
                stylers: [{
                    lightness: 57
                }]
            }]
        },
        n = new google.maps.Map(t, o);
    marker = new google.maps.Marker({
        position: i,
        map: n,
        icon: s
    })
}

function createAdvancedMap(e, a, l, s, i) {
    for (var t = new google.maps.LatLng(a, l), o = document.getElementById(e), n = {
            zoom: 14,
            scrollwheel: !1,
            center: t,
            styles: [{
                featureType: "landscape",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }, {
                featureType: "transit",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }, {
                featureType: "poi",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }, {
                featureType: "water",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }, {
                featureType: "road",
                elementType: "labels.icon",
                stylers: [{
                    visibility: "off"
                }]
            }, {
                stylers: [{
                    hue: "#00aaff"
                }, {
                    saturation: -100
                }, {
                    gamma: 2.15
                }, {
                    lightness: 12
                }]
            }, {
                featureType: "road",
                elementType: "labels.text.fill",
                stylers: [{
                    visibility: "on"
                }, {
                    lightness: 24
                }]
            }, {
                featureType: "road",
                elementType: "geometry",
                stylers: [{
                    lightness: 57
                }]
            }]
        }, r = new google.maps.Map(o, n), p = [], f = 0; f < s.length; f++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(s[f].latitude, s[f].longitude),
            map: r,
            icon: i
        }), p.push(marker);
        var m = document.createElement("div"),
            y = {
                content: m,
                disableAutoPan: !1,
                pixelOffset: new google.maps.Size(-325, -60),
                zIndex: null,
                alignBottom: !0,
                boxClass: "infobox",
                enableEventPropagation: !0,
                closeBoxMargin: "0px 0px -30px 0px",
                closeBoxURL: "img/map-close.png",
                infoBoxClearance: new google.maps.Size(1, 1)
            };
        m.innerHTML = drawInfobox(m, s, f), p[f].infobox = new InfoBox(y), google.maps.event.addListener(marker, "click", function() {
            var e = this;
            $.each(p, function(a, l) {
                l !== e && l.infobox.close()
            }), e.infobox.open(r, this)
        })
    }
}

function drawInfobox(e, a, l) {
    if (a[l].name) var s = '<h3><a href="' + a[l].link + '">' + a[l].name + "</a></h3>";
    else s = "";
    if (a[l].about) var i = '<p class="about">' + a[l].about + "</p>";
    else i = "";
    if (a[l].address) var t = '<p class="address"><i class="fa fa-map-marker"></i>' + a[l].address + "</p>";
    else t = "";
    if (a[l].image) var o = '<div class="image" style="background-image: url(\'' + a[l].image + "')\"></div>";
    else o = '<div class="image"></div>';
    if (a[l].email) var n = '<i class="fa fa-envelope-o"></i><a href="mailto:' + a[l].email + '">' + a[l].email + "</a><br>";
    else n = "";
    if (a[l].phone) var r = '<i class="fa fa-phone"></i>' + a[l].phone + "<br>";
    else r = "";
    if (a[l].url) a[l].url, a[l].url;
    else "";
    return '<div class="infobox clearfix"><div class="inner">' + o + '<div class="text">' + s + i + t + '<p class="details">' + n + r + "</p></div></div></div>"
}