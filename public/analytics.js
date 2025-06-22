var ns_domain = window.location.hostname.replace("www.", "");
var userAgent = navigator.userAgent;
var referrer = window.frames.top.document.referrer;
var title = document.title;
var tracking_id = crypto.randomUUID();
var serverURL = window.location.hostname;
var screenHeight = window.screen.height;
var screenWidth = window.screen.width;

var ns_site = document.querySelector('script[data-site]').dataset.site;
if (typeof ns_site === "undefined") var ns_site = null;

var isErrorPage = null;
if(document.querySelectorAll('script[data-clevada-analytics-error="1"]').length > 0) isErrorPage = 1;

(function () { var e, t; e = this, t = function () { var r = { startStopTimes: {}, idleTimeoutMs: 3e4, currentIdleTimeMs: 0, checkStateRateMs: 250, active: !1, idle: !1, currentPageName: "current-page", timeElapsedCallbacks: [], userLeftCallbacks: [], userReturnCallbacks: [], trackTimeOnElement: function (e) { var t = document.getElementById(e); t && (t.addEventListener("mouseover", function () { r.startTimer(e) }), t.addEventListener("mousemove", function () { r.startTimer(e) }), t.addEventListener("mouseleave", function () { r.stopTimer(e) }), t.addEventListener("keypress", function () { r.startTimer(e) }), t.addEventListener("focus", function () { r.startTimer(e) })) }, getTimeOnElementInSeconds: function (e) { var t = r.getTimeOnPageInSeconds(e); return t || 0 }, startTimer: function (e, t) { if (e || (e = r.currentPageName), void 0 === r.startStopTimes[e]) r.startStopTimes[e] = []; else { var n = r.startStopTimes[e], i = n[n.length - 1]; if (void 0 !== i && void 0 === i.stopTime) return } r.startStopTimes[e].push({ startTime: t || new Date, stopTime: void 0 }), r.active = !0 }, stopAllTimers: function () { for (var e = Object.keys(r.startStopTimes), t = 0; t < e.length; t++)r.stopTimer(e[t]) }, stopTimer: function (e) { e || (e = r.currentPageName); var t = r.startStopTimes[e]; void 0 !== t && 0 !== t.length && (void 0 === t[t.length - 1].stopTime && (t[t.length - 1].stopTime = new Date), r.active = !1) }, getTimeOnCurrentPageInSeconds: function () { return r.getTimeOnPageInSeconds(r.currentPageName) }, getTimeOnPageInSeconds: function (e) { return void 0 === r.getTimeOnPageInMilliseconds(e) ? void 0 : r.getTimeOnPageInMilliseconds(e) / 1e3 }, getTimeOnCurrentPageInMilliseconds: function () { return r.getTimeOnPageInMilliseconds(r.currentPageName) }, getTimeOnPageInMilliseconds: function (e) { var t = r.startStopTimes[e]; if (void 0 !== t) { for (var n = 0, i = 0; i < t.length; i++) { var s = t[i].startTime, o = t[i].stopTime; void 0 === o && (o = new Date), n += o - s } return Number(n) } }, getTimeOnAllPagesInSeconds: function () { for (var e = [], t = Object.keys(r.startStopTimes), n = 0; n < t.length; n++) { var i = t[n], s = r.getTimeOnPageInSeconds(i); e.push({ pageName: i, timeOnPage: s }) } return e }, setIdleDurationInSeconds: function (e) { var t = parseFloat(e); if (!1 !== isNaN(t)) throw { name: "InvalidDurationException", message: "Invalid time" }; return r.idleTimeoutMs = 1e3 * e, this }, setCurrentPageName: function (e) { return r.currentPageName = e, this }, resetRecordedPageTime: function (e) { delete r.startStopTimes[e] }, resetAllRecordedPageTimes: function () { for (var e = Object.keys(r.startStopTimes), t = 0; t < e.length; t++)r.resetRecordedPageTime(e[t]) }, resetIdleCountdown: function () { r.idle && r.triggerUserHasReturned(), r.idle = !1, r.currentIdleTimeMs = 0 }, callWhenUserLeaves: function (e, t) { this.userLeftCallbacks.push({ callback: e, numberOfTimesToInvoke: t }) }, callWhenUserReturns: function (e, t) { this.userReturnCallbacks.push({ callback: e, numberOfTimesToInvoke: t }) }, triggerUserHasReturned: function () { if (!r.active) for (var e = 0; e < this.userReturnCallbacks.length; e++) { var t = this.userReturnCallbacks[e], n = t.numberOfTimesToInvoke; (isNaN(n) || void 0 === n || 0 < n) && (t.numberOfTimesToInvoke -= 1, t.callback()) } r.startTimer() }, triggerUserHasLeftPage: function () { if (r.active) for (var e = 0; e < this.userLeftCallbacks.length; e++) { var t = this.userLeftCallbacks[e], n = t.numberOfTimesToInvoke; (isNaN(n) || void 0 === n || 0 < n) && (t.numberOfTimesToInvoke -= 1, t.callback()) } r.stopAllTimers() }, callAfterTimeElapsedInSeconds: function (e, t) { r.timeElapsedCallbacks.push({ timeInSeconds: e, callback: t, pending: !0 }) }, checkState: function () { for (var e = 0; e < r.timeElapsedCallbacks.length; e++)r.timeElapsedCallbacks[e].pending && r.getTimeOnCurrentPageInSeconds() > r.timeElapsedCallbacks[e].timeInSeconds && (r.timeElapsedCallbacks[e].callback(), r.timeElapsedCallbacks[e].pending = !1); !1 === r.idle && r.currentIdleTimeMs > r.idleTimeoutMs ? (r.idle = !0, r.triggerUserHasLeftPage()) : r.currentIdleTimeMs += r.checkStateRateMs }, visibilityChangeEventName: void 0, hiddenPropName: void 0, listenForVisibilityEvents: function () { void 0 !== document.hidden ? (r.hiddenPropName = "hidden", r.visibilityChangeEventName = "visibilitychange") : void 0 !== document.mozHidden ? (r.hiddenPropName = "mozHidden", r.visibilityChangeEventName = "mozvisibilitychange") : void 0 !== document.msHidden ? (r.hiddenPropName = "msHidden", r.visibilityChangeEventName = "msvisibilitychange") : void 0 !== document.webkitHidden && (r.hiddenPropName = "webkitHidden", r.visibilityChangeEventName = "webkitvisibilitychange"), document.addEventListener(r.visibilityChangeEventName, function () { document[r.hiddenPropName] ? r.triggerUserHasLeftPage() : r.triggerUserHasReturned() }, !1), window.addEventListener("blur", function () { r.triggerUserHasLeftPage() }), window.addEventListener("focus", function () { r.triggerUserHasReturned() }), document.addEventListener("mousemove", function () { r.resetIdleCountdown() }), document.addEventListener("keyup", function () { r.resetIdleCountdown() }), document.addEventListener("touchstart", function () { r.resetIdleCountdown() }), window.addEventListener("scroll", function () { r.resetIdleCountdown() }), setInterval(function () { r.checkState() }, r.checkStateRateMs) }, websocket: void 0, websocketHost: void 0, setUpWebsocket: function (e) { if (window.WebSocket && e) { var t = e.websocketHost; try { r.websocket = new WebSocket(t), window.onbeforeunload = function () { r.sendCurrentTime(e.appId) }, r.websocket.onopen = function () { r.sendInitWsRequest(e.appId) }, r.websocket.onerror = function (e) { console && console.log("Error occurred in websocket connection: " + e) }, r.websocket.onmessage = function (e) { console && console.log(e.data) } } catch (e) { console && console.error("Failed to connect to websocket host.  Error:" + e) } } return this }, websocketSend: function (e) { r.websocket.send(JSON.stringify(e)) }, sendCurrentTime: function (e) { var t = { type: "INSERT_TIME", appId: e, timeOnPageMs: r.getTimeOnCurrentPageInMilliseconds(), pageName: r.currentPageName }; r.websocketSend(t) }, sendInitWsRequest: function (e) { var t = { type: "INIT", appId: e }; r.websocketSend(t) }, initialize: function (e) { var t = r.idleTimeoutMs || 30, n = r.currentPageName || "default-page-name", i = void 0, s = void 0; e && (t = e.idleTimeoutInSeconds || t, n = e.currentPageName || n, i = e.websocketOptions, s = e.initialStartTime), r.setIdleDurationInSeconds(t).setCurrentPageName(n).setUpWebsocket(i).listenForVisibilityEvents(), r.startTimer(void 0, s) } }; return r }, "undefined" != typeof module && module.exports ? module.exports = t() : "function" == typeof define && define.amd ? define([], function () { return e.TimeTrack = t() }) : e.TimeTrack = t() }).call(this);

function sendAnalyticEvent(id, scroll_percent) {
    let data = {
        "site": ns_site,
        "tracking_id": id,
        "scroll_percent": scroll_percent,
        "domain": ns_domain,
        "page": window.location.pathname,
        "referrer": referrer,
        "userAgent": userAgent,
        "title": title,
        "screenHeight": screenHeight,
        "screenWidth": screenWidth,
        "isErrorPage": isErrorPage,
    };
    fetch(`${serverURL}/analytic-event`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
        keepalive: true,
    })        
}


function sendTimeEvent(id, seconds_min) {
    let data = {
        "site": ns_site,
        "tracking_id": id,
        "seconds_min": seconds_min,             
    };
    fetch(`${serverURL}/time-event`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
        keepalive: true,
    });        
}

function startTracking() {
    //tracking_id = crypto.randomUUID();
    TimeTrack.initialize({
        idleTimeoutInSeconds: 310 // seconds
    });
    TimeTrack.callAfterTimeElapsedInSeconds(8, function () {
        sendTimeEvent(tracking_id, 10);
    });
    TimeTrack.callAfterTimeElapsedInSeconds(28, function () {
        sendTimeEvent(tracking_id, 30);
    });
    TimeTrack.callAfterTimeElapsedInSeconds(58, function () {
        sendTimeEvent(tracking_id, 60);
    });
    TimeTrack.callAfterTimeElapsedInSeconds(118, function () {
        sendTimeEvent(tracking_id, 120);
    });
    TimeTrack.callAfterTimeElapsedInSeconds(178, function () {
        sendTimeEvent(tracking_id, 180);
    });
    TimeTrack.callAfterTimeElapsedInSeconds(298, function () {
        sendTimeEvent(tracking_id, 300);
    });

    sendAnalyticEvent(tracking_id, 0); // send initial data

    //['visibilitychange', 'scroll'].forEach(event => document.addEventListener(event, doEvent));
    ['scroll'].forEach(event => document.addEventListener(event, doEvent));
    var scroller = new scrollPercent;
    var percent_25_sent = 0;
    var percent_50_sent = 0;
    var percent_75_sent = 0;

    function doEvent(e) {
        var percent = scroller.init();
        if (percent >= 25 && percent < 50 && !(percent_50_sent || percent_75_sent)) {
            if (percent_25_sent == 0) {
                sendAnalyticEvent(tracking_id, percent);
                percent_25_sent++;
            }
        }

        if (percent >= 50 && percent < 75 && !(percent_75_sent)) {
            if (percent_50_sent == 0) {
                sendAnalyticEvent(tracking_id, percent);
                percent_50_sent++;
            }
        }

        if (percent >= 75) {
            if (percent_75_sent == 0) {
                sendAnalyticEvent(tracking_id, percent);
                percent_75_sent++;
            }
        }

    };   
    
}

var scrollPercent = (function () {
    "use strict";
    var initDiff;
    var module = {
        init: function () {
            var windowHeight = this.getWindowHeight();
            var docHeight = this.getDocHeight() - windowHeight;
            initDiff = (windowHeight / docHeight) * 100;
            return this.percent();
        },
        percent: function () {
            var windowHeight = this.getWindowHeight();
            var docHeight = this.getDocHeight() - windowHeight;
            var scrollPosition = this.getScrollPosition();
            var result = ((scrollPosition + windowHeight) / docHeight) * 100 - initDiff;
            return Math.floor(result);
        },
        getScrollPosition: function () {
            return (window.scrollY !== undefined) ? window.scrollY : (document.documentElement || document.body.parentNode || document.body).scrollTop;
        },
        getWindowHeight: function () {
            return window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight || 0;
        },
        getDocHeight: function () {
            return Math.max(
                document.body.scrollHeight || 0,
                document.documentElement.scrollHeight || 0,
                document.body.offsetHeight || 0,
                document.documentElement.offsetHeight || 0,
                document.body.clientHeight || 0,
                document.documentElement.clientHeight || 0
            );
        }
    };

    return module;
});

setTimeout(startTracking, 2 * 1000); 
