"use strict";
$(document).ready(function () {
    $.extend($.validator.defaults, {
        invalidHandler: function (c, a) {
            var d = a.numberOfInvalids();
            if (d) {
                var b = d == 1 ? "有 1 项未填写. 已高亮显示." : "有 " + d + " 项未填写. 已高亮显示.";
                noty({text: b, type: "error", timeout: 2000})
            }
        }
    });
    $("#validate-1").validate();
    $("#validate-2").validate();
    $("#validate-3").validate();
    $("#validate-4").validate()
});