let redrawElementsTimeout;
var previousOrientation;

$(document).ready(function () {
    redrawElementsSteps();

    previousOrientation = window.orientation;

    window.addEventListener("orientationchange", mobileOrientationChanged, false);
    setInterval(mobileOrientationChanged, 2000);
});

$(window).on("resize", function () {
    redrawElements();
});

function redrawElements() {
    if ($(window).width() > 950) {
        redrawElementsSteps();
    }
}

function redrawElementsSteps() {
    clearTimeout(redrawElementsTimeout);

    redrawElementsTimeout = setTimeout(function () {
        $('.chosen-select').chosen('destroy').chosen();
    }, 200);
}

function mobileOrientationChanged() {
    if (window.orientation !== previousOrientation) {
        previousOrientation = window.orientation;
        redrawElementsSteps();
    }
}