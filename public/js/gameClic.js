document.addEventListener("DOMContentLoaded", function () {
    var selectedTrailer = document.querySelector('.selectedTrailer');
    if (selectedTrailer.textContent.includes('No available trailers')) {
        var screenshotsTab = document.querySelector("button[onclick*='Screenshots']");
        screenshotsTab.click();
    } else {
        document.querySelector('.tablinks').click();
    }
});
