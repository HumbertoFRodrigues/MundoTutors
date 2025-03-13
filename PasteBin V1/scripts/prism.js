document.addEventListener("DOMContentLoaded", function () {
    var pres = document.querySelectorAll("pre[class*='language-']");
    pres.forEach(pre => {
        var code = pre.querySelector("code");
        if (code) {
            hljs.highlightElement(code);
        }
    });
});
