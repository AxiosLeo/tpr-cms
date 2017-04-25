"use strict";
$(document).ready(function () {
    var c = $("#sample_form");
    var d = $("#form_wizard");
    var a = $(".alert-danger", c);
    var f = $(".alert-success", c);
    c.validate({
        doNotHideMessage: true, focusInvalid: false, invalidHandler: function (h, g) {
            f.hide();
            a.show()
        }, submitHandler: function (g) {
            f.show();
            a.hide()
        }
    });
    var e = function () {
        var n=$('.number:last').html().trim();
        $("#tab"+n+" .form-control-static", c).each(function () {
            var g = $('[name="' + $(this).attr("data-display") + '"]', c);
            if (g.is(":text") || g.is("textarea")) {
                $(this).html(g.val())
            } else {
                if (g.is("select")) {
                    $(this).html(g.find("option:selected").text())
                } else {
                    if (g.is(":radio") && g.is(":checked")) {
                        $(this).html(g.attr("data-title"))
                    }
                }
            }
        })
    };
    var b = function (k, g, h) {
        var l = g.find("li").length;
        var m = h + 1;
        $(".step-title", d).text("Step " + (h + 1) + " of " + l);
        $("li", d).removeClass("done");
        var n = g.find("li");
        for (var j = 0; j < h; j++) {
            $(n[j]).addClass("done")
        }
        if (m == 1) {
            d.find(".button-previous").hide()
        } else {
            d.find(".button-previous").show()
        }
        if (m >= l) {
            d.find(".button-next").hide();
            d.find(".button-submit").show();
            e()
        } else {
            d.find(".button-next").show();
            d.find(".button-submit").hide()
        }
    };
    d.bootstrapWizard({
        nextSelector: ".button-next",
        previousSelector: ".button-previous",
        onTabClick: function (i, g, h, j) {
            f.hide();
            a.hide();
            if (c.valid() == false) {
                return false
            }
            b(i, g, j)
        },
        onNext: function (i, g, h) {
            f.hide();
            a.hide();
            if (c.valid() == false) {
                return false
            }
            b(i, g, h)
        },
        onPrevious: function (i, g, h) {
            f.hide();
            a.hide();
            b(i, g, h)
        },
        onTabShow: function (j, g, i) {
            var k = g.find("li").length;
            var l = i + 1;
            var h = (l / k) * 100;
            d.find(".progress-bar").css({width: h + "%"})
        }
    });
    d.find(".button-previous").hide();
    /* $("#form_wizard .button-submit").click(
     function(){
     alert("You just finished the wizard. :-)")
     }).hide()*/
});