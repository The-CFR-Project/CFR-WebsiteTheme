<canvas id = "quakeCanvas" style="z-index:999;"></canvas>

<script type='text/javascript' src='http://d3js.org/d3.v3.min.js'></script>
<script type='text/javascript' src='http://d3js.org/topojson.v1.min.js'></script>

<script>
    /*! Planetary.js 1.1.2 | (c) 2013 Michelle Tilley | Released under MIT License */ ! function(n, t) {
        "function" == typeof define && define.amd ? define(["d3", "topojson"], function(o, i) {
        return n.planetaryjs = t(o, i, n)
    }) : "object" == typeof exports ? module.exports = t(require("d3"), require("topojson")) : n.planetaryjs = t(n.d3, n.topojson, n)
}(this, function(n, t, o) {
    "use strict";
    var i = null;
    o && (i = o.planetaryjs);
    var e = [],
        r = function(t, o, i) {
            n.timer(function() {
                if (t.stopped) return !0;
                t.context.clearRect(0, 0, o.width, o.height);
                for (var n = 0; n < i.onDraw.length; n++) i.onDraw[n]()
            })
        },
        l = function(n, t) {
            for (var o = e.length - 1; o >= 0; o--) t.unshift(e[o]);
            for (0 === t.length && (c.plugins.earth && n.loadPlugin(c.plugins.earth()), c.plugins.pings && n.loadPlugin(c.plugins.pings())), o = 0; o < t.length; o++) t[o](n)
        },
        a = function(n, t, o) {
            if (o.onInit.length) {
                var i = 0,
                    e = function(n) {
                        var t = o.onInit[i];
                        t.length ? t(function() {
                            i++, n()
                        }) : (t(), i++, setTimeout(n, 0))
                    },
                    l = function() {
                        i >= o.onInit.length ? r(n, t, o) : e(l)
                    };
                e(l)
            } else r(n, t, o)
        },
        u = function(n, t, o, i) {
            n.canvas = t, n.context = t.getContext("2d"), n.stopped !== !0 && l(n, o), n.stopped = !1, a(n, t, i)
        },
        c = {
            plugins: {},
            noConflict: function() {
                return o.planetaryjs = i, c
            },
            loadPlugin: function(n) {
                e.push(n)
            },
            planet: function() {
                var t = [],
                    o = {
                        onInit: [],
                        onDraw: [],
                        onStop: []
                    },
                    i = {
                        plugins: {},
                        draw: function(n) {
                            u(i, n, t, o)
                        },
                        onInit: function(n) {
                            o.onInit.push(n)
                        },
                        onDraw: function(n) {
                            o.onDraw.push(n)
                        },
                        onStop: function(n) {
                            o.onStop.push(n)
                        },
                        loadPlugin: function(n) {
                            t.push(n)
                        },
                        stop: function() {
                            i.stopped = !0;
                            for (var n = 0; n < o.onStop.length; n++) o.onStop[n](i)
                        },
                        withSavedContext: function(n) {
                            if (!this.context) throw new Error("No canvas to fetch context for");
                            this.context.save(), n(this.context), this.context.restore()
                        }
                    };
                return i.projection = n.geo.orthographic().clipAngle(90), i.path = n.geo.path().projection(i.projection), i
            }
        };
    return c.plugins.topojson = function(t) {
        return function(o) {
            o.plugins.topojson = {}, o.onInit(function(i) {
                if (t.world) o.plugins.topojson.world = t.world, setTimeout(i, 0);
                else {
                    var e = t.file || "world-110m.json";
                    n.json(e, function(n, t) {
                        if (n) throw new Error("Could not load JSON " + e);
                        o.plugins.topojson.world = t, i()
                    })
                }
            })
        }
    }, c.plugins.oceans = function(n) {
        return function(t) {
            t.onDraw(function() {
                t.withSavedContext(function(o) {
                    o.beginPath(), t.path.context(o)({
                        type: "Sphere"
                    }), o.fillStyle = n.fill || "black", o.fill()
                })
            })
        }
    }, c.plugins.land = function(n) {
        return function(o) {
            var i = null;
            o.onInit(function() {
                var n = o.plugins.topojson.world;
                i = t.feature(n, n.objects.land)
            }), o.onDraw(function() {
                o.withSavedContext(function(t) {
                    t.beginPath(), o.path.context(t)(i), n.fill !== !1 && (t.fillStyle = n.fill || "white", t.fill()), n.stroke && (n.lineWidth && (t.lineWidth = n.lineWidth), t.strokeStyle = n.stroke, t.stroke())
                })
            })
        }
    }, c.plugins.borders = function(n) {
        return function(o) {
            var i = null,
                e = {
                    internal: function(n, t) {
                        return n.id !== t.id
                    },
                    external: function(n, t) {
                        return n.id === t.id
                    },
                    both: function() {
                        return !0
                    }
                };
            o.onInit(function() {
                var r = o.plugins.topojson.world,
                    l = r.objects.countries,
                    a = n.type || "internal";
                i = t.mesh(r, l, e[a])
            }), o.onDraw(function() {
                o.withSavedContext(function(t) {
                    t.beginPath(), o.path.context(t)(i), t.strokeStyle = n.stroke || "gray", n.lineWidth && (t.lineWidth = n.lineWidth), t.stroke()
                })
            })
        }
    }, c.plugins.earth = function(n) {
        n = n || {};
        var t = n.topojson || {},
            o = n.oceans || {},
            i = n.land || {},
            e = n.borders || {};
        return function(n) {
            c.plugins.topojson(t)(n), c.plugins.oceans(o)(n), c.plugins.land(i)(n), c.plugins.borders(e)(n)
        }
    }, c.plugins.pings = function(t) {
        var o = [];
        t = t || {};
        var i = function(n, i, e) {
                e = e || {}, e.color = e.color || t.color || "white", e.angle = e.angle || t.angle || 5, e.ttl = e.ttl || t.ttl || 2e3;
                var r = {
                    time: new Date,
                    options: e
                };
                t.latitudeFirst ? (r.lat = n, r.lng = i) : (r.lng = n, r.lat = i), o.push(r)
            },
            e = function(n, t, i) {
                for (var e = [], l = 0; l < o.length; l++) {
                    var a = o[l],
                        u = i - a.time;
                    u < a.options.ttl && (e.push(a), r(n, t, i, u, a))
                }
                o = e
            },
            r = function(t, o, i, e, r) {
                var l = 1 - e / r.options.ttl,
                    a = n.rgb(r.options.color);
                a = "rgba(" + a.r + "," + a.g + "," + a.b + "," + l + ")", o.strokeStyle = a;
                var u = n.geo.circle().origin([r.lng, r.lat]).angle(e / r.options.ttl * r.options.angle)();
                o.beginPath(), t.path.context(o)(u), o.stroke()
            };
        return function(n) {
            n.plugins.pings = {
                add: i
            }, n.onDraw(function() {
                var t = new Date;
                n.withSavedContext(function(o) {
                    e(n, o, t)
                })
            })
        }
    }, c.plugins.zoom = function(t) {
        t = t || {};
        var o = function() {},
            i = t.onZoomStart || o,
            e = t.onZoomEnd || o,
            r = t.onZoom || o,
            l = t.afterZoom || o,
            a = t.initialScale,
            u = t.scaleExtent || [50, 2e3];
        return function(t) {
            t.onInit(function() {
                var o = n.behavior.zoom().scaleExtent(u);
                o.scale(null !== a && void 0 !== a ? a : t.projection.scale()), o.on("zoomstart", i.bind(t)).on("zoomend", e.bind(t)).on("zoom", function() {
                    r.call(t), t.projection.scale(n.event.scale), l.call(t)
                }), n.select(t.canvas).call(o)
            })
        }
    }, c.plugins.drag = function(t) {
        t = t || {};
        var o = function() {},
            i = t.onDragStart || o,
            e = t.onDragEnd || o,
            r = t.onDrag || o,
            l = t.afterDrag || o;
        return function(t) {
            t.onInit(function() {
                var o = n.behavior.drag().on("dragstart", i.bind(t)).on("dragend", e.bind(t)).on("drag", function() {
                    r.call(t);
                    var o = n.event.dx,
                        i = n.event.dy,
                        e = t.projection.rotate(),
                        a = t.projection.scale(),
                        u = n.scale.linear().domain([-1 * a, a]).range([-90, 90]),
                        c = u(o),
                        s = u(i);
                    e[0] += c, e[1] -= s, e[1] > 90 && (e[1] = 90), e[1] < -90 && (e[1] = -90), e[0] >= 180 && (e[0] -= 360), t.projection.rotate(e), l.call(t)
                });
                n.select(t.canvas).call(o)
            })
        }
    }, c
});
</script>






<script>
function createGlobe() {
  var canvas = document.getElementById('quakeCanvas');

  // Create our Planetary.js planet and set some initial values;
  // we use several custom plugins, defined at the bottom of the file
  var planet = planet();
  console.log('Hello');
  planet.loadPlugin(autocenter({extraHeight: -120}));
  planet.loadPlugin(autoscale({extraHeight: -120}));
  planet.loadPlugin(planetaryjs.plugins.earth({
    topojson: { file:   '/world-110m.json' },
    oceans:   { fill:   '#001320' },
    land:     { fill:   '#06304e' },
    borders:  { stroke: '#001320' }
  }));
  planet.loadPlugin(planetaryjs.plugins.pings());
  planet.loadPlugin(planetaryjs.plugins.zoom({
    scaleExtent: [50, 5000]
  }));
  planet.loadPlugin(planetaryjs.plugins.drag({
    onDragStart: function() {
      this.plugins.autorotate.pause();
    },
    onDragEnd: function() {
      this.plugins.autorotate.resume();
    }
  }));
  planet.loadPlugin(autorotate(5));
  planet.projection.rotate([100, -10, 0]);
  planet.draw(canvas);
};


    // Plugin to resize the canvas to fill the window and to
  // automatically center the planet when the window size changes
  function autocenter(options) {
    options = options || {};
    var needsCentering = false;
    var globe = null;

    var resize = function() {
      var width  = window.innerWidth + (options.extraWidth || 0);
      var height = window.innerHeight + (options.extraHeight || 0);
      globe.canvas.width = width;
      globe.canvas.height = height;
      globe.projection.translate([width / 2, height / 2]);
    };

    return function(planet) {
      globe = planet;
      planet.onInit(function() {
        needsCentering = true;
        d3.select(window).on('resize', function() {
          needsCentering = true;
        });
      });

      planet.onDraw(function() {
        if (needsCentering) { resize(); needsCentering = false; }
      });
    };
  };

  // Plugin to automatically scale the planet's projection based
  // on the window size when the planet is initialized
  function autoscale(options) {
    options = options || {};
    return function(planet) {
      planet.onInit(function() {
        var width  = window.innerWidth + (options.extraWidth || 0);
        var height = window.innerHeight + (options.extraHeight || 0);
        planet.projection.scale(Math.min(width, height) / 2);
      });
    };
  };

  // Plugin to automatically rotate the globe around its vertical
  // axis a configured number of degrees every second.
  function autorotate(degPerSec) {
    return function(planet) {
      var lastTick = null;
      var paused = false;
      planet.plugins.autorotate = {
        pause:  function() { paused = true;  },
        resume: function() { paused = false; }
      };
      planet.onDraw(function() {
        if (paused || !lastTick) {
          lastTick = new Date();
        } else {
          var now = new Date();
          var delta = now - lastTick;
          var rotation = planet.projection.rotate();
          rotation[0] += degPerSec * delta / 1000;
          if (rotation[0] >= 180) rotation[0] -= 360;
          planet.projection.rotate(rotation);
          lastTick = now;
        }
      });
    };
  };

  createGlobe();
</script>