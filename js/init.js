
var Oboro = Oboro || {};

! function (e) {
    "use strict";
    e(window).on("resize", function (e) {
            return Oboro.SpamCheck(e) ? void console.log("window width: " + window.innerWidth) : !1
        }),

        e(".server_info > ul.nav > li > a").on("click", function () {
            e(".server_info > ul.nav").find(".active").removeClass("active"), e(this).parent().addClass("active");
            var t = e(this).attr("data-roll");
            e(".tab-content").find(".active").fadeOut(200, function () {
                e(this).removeClass("active").css("opacity", "0"), e("#" + t).fadeIn(200, function () {
                    e(this).addClass("active").css("opacity", "1")
                })
            })
        }), e("html, .oboro_forum_shoutbox_container").niceScroll({
            cursorwidth: "2px",
            cursorcolor: "rgb(185, 179, 179)",
            cursorborder: "rgb(185, 179, 179)",
            cursorborderradius: "4px",
            zindex: 150,
            scrollspeed: 50,
            spacebarenabled: !1,
            enablemousewheel: !0,
            bouncescroll: !0,
            autohidemode: !0
        }), e(".tab-content").niceScroll({
            cursorwidth: "2px",
            cursorcolor: "rgb(185, 179, 179)",
            cursorborder: "rgb(185, 179, 179)",
            cursorborderradius: "4px",
            zindex: 150,
            scrollspeed: 50,
            spacebarenabled: !1,
            enablemousewheel: !0,
            bouncescroll: !0,
            autohidemode: !0
        }), e("#OboroDT, #OboroDT2").DataTable({
            responsive: true,
            bFilter: !0,
            bInfo: !0,
            bPaginate: !0
        }), e("#OboroDT3").DataTable({
            responsive: !0,
            bFilter: !0,
            bInfo: !1,
            bPaginate: !0,
            lengthMenu: [4, 6, 8, 10, 15, 20]
        }), e("#OboroNews").DataTable({
            responsive: !0,
            bFilter: !1,
            bInfo: !1,
            bPaginate: !1,
            lengthMenu: [4, 6, 8, 10, 15, 20]
        }), e("#OboroDT_ItemDB").DataTable({
            responsive: !0,
            bFilter: !0,
            bInfo: !0,
            bPaginate: !0,
            Processing: !0,
            bSortClasses: !1,
            ajax: "libs/ajax/datatables.ajax.php?info=item_db",
            deferRender: !0
        }), e('[id="OBORO_NORMALIZED"]').on("submit", function (t) {
            t.preventDefault(), e(".loader").fadeIn("slow");
            var a = e(this).find('select[name="opt"]').val() || e(this).find('input[name="opt"]').val() || !1,
                o = e(this).find('input[name="rank"]').val() || !1,
                n = e(this).find('select[name="order"]').val() || !1,
                i = e(this).find('input[name="buscar"]').val() || !1,
                s = e(this).find('input[name="name"]').val() || 0,
                r = e(this).find('input[name="account_id"]').val() || 0,
                l = e(this).find('input[name="item_id"]').val() || 0,
                c = e(this).find('input[name="map"]').val() || 0,
                u = "?" + o;
            a && (u += "-" + a), n && (u += "-" + n), i && (u += "-" + i), 1 == a && (u += "-" + s + "-" + r + "-" + l + "-" + c), window.location.href = u
        });
    var t = function (t) {
        e.confirm({
            title: "Encountered an error!",
            closeIcon: !0,
            closeIconClass: "fa fa-close",
            backgroundDismiss: !0,
            content: t,
            autoClose: "close|7000",
            type: "red",
            typeAnimated: !0,
            buttons: {
                close: function () {}
            }
        })
    };
    e(".OBOROBACKWORK").on("submit", function (a) {
            a.preventDefault(), e(".loader").fadeIn("slow");
            var o = this;
            e.post("libs/ajax/functions.php", e(o).serialize(), function (a) {
                switch (e(o).find('input[name="OPT"]').val()) {
                    case "LOGIN":
                        "ok" !== e.trim(a) ? t(a) : window.location.href = "?";
                        break;
                    case "REGISTRO":
                        "ok" !== e.trim(a) ? e(".error_log").css("background", "#ffacac").html(a + "<br/><b>Note</b> Please click the submit(blue) button to update error list") : (Oboro.alerta("success", "&Eacute;xito", "Account has been created"), window.location.href = "index.php");
                        break;
                    case "ACCOUNTPANEL":
                        switch (e.trim(a)) {
                            case "okdeslog":
                                Oboro.alerta("success", "&Eacute;xito", "Please log in again to finish"), window.location.href = "index.php?session_destroy=true";
                                break;
                            case "ok":
                                Oboro.alerta("success", "&Eacute;xito", "Your account has been update");
                                break;
                            default:
                                t(a)
                        }
                        break;
                    case "CHARPANEL":
                        "ok" === e.trim(a) ? (Oboro.alerta("success", "&Eacute;xito", "Your account has been updated"), window.location.href = "index.php?account.info") : t(a);
                        break;
                    case "RECOVERPASS":
                        "ok" === e.trim(a) ? Oboro.alerta("success", "&Eacute;xito", "Please check your email for the new login") : t(a);
                        break;
                    case "CONVERT_ITEM_DB":
                        "error" === e.trim(a.split("@")[0]) ? (Oboro.alerta("success", "&Eacute;xito", "Your Item_DB.SQL Has been succesfully Created, starting your download soon..."), setTimeout(function () {
                            window.location.href = a.split("@")[1]
                        }, 1e3)) : t(a);
                        break;
                    case "LOGIN_WITH_GEO":
                        "ok" === e.trim(a) ? (Oboro.alerta("success", "&Eacute;xito", "Welcomeback"), window.location.href = "index.php") : t(a);
                        break;
                    case "UPDATE_GEO_INFO":
                        "ok" === e.trim(a) ? Oboro.alerta("success", "&Eacute;xito", "Geo-Localization Information Updated succesfully") : t(a);
                        break;
                    case "CREATE_DONATION_ITEM":
                        "ok" === e.trim(a) ? (Oboro.alerta("success", "&Eacute;xito", "New donation item created"), window.location.href = "?admin.donationshop") : t(a);
                        break;
                    case "DELETE_DONATION_ITEM":
                        "ok" === e.trim(a) ? (Oboro.alerta("success", "&Eacute;xito", "Donation Item has been deleted from donation shop"), window.location.href = "?admin.donationshop") : t(a);
                        break;
                    case "CHANGEPASSWORDPANEL":
                        "ok" === e.trim(a) ? (Oboro.alerta("success", "&Eacute;xito", "Password Updated"), window.location.href = "?session_destroy=true") : t(a);
                        break;
                    case "CREATEMODIFYCATEGORY":
                        "ok" === e.trim(a) ? (Oboro.alerta("success", "&Eacute;xito", "New Category Added"), window.location.href = "?admin.management-5") : t(a);
                        break;
                    case "CREATEMODIFYGROUPS":
                        "ok" === e.trim(a) ? (Oboro.alerta("success", "&Eacute;xito", "New Group Added"), window.location.href = "?admin.management-6") : t(a);
                        break;
                    case "NEWSHOUTBOX":
                        "ok" === e.trim(a) ? (Oboro.alerta("success", "&Eacute;xito", "New Shout Added"), LoadShoutBox()) : t(a);
                    break;
                }
            }), e(".loader").fadeOut("slow")
        }), e(".dona-box-on-buy").on("submit", function (a) {
            a.preventDefault(), e(".loader").fadeIn("slow");
            var o = e(this).attr("data-dona-id"),
                n = this;
            0 == e(this).find("input[name='confirma-compra']").prop("checked") ? t("You must have to confirm the checkbox") : (e(this).find("input[name='sub']").val("").val("Processing."), e.post("libs/ajax/donationshop.validator.php", {
                item_id: o
            }, function (a) {
                "ok" === e.trim(a) ? e.confirm({
                    title: "Congratulations!",
                    closeIcon: !0,
                    closeIconClass: "fa fa-close",
                    backgroundDismiss: !0,
                    content: "item has been successfully added to your inventory",
                    autoClose: "close|5000",
                    type: "green",
                    typeAnimated: !0,
                    buttons: {
                        close: function () {}
                    },
                    onClose: function () {
                        e(n).find("input[name='sub']").val("").val("Buy Again"), e("#get-donation-points").text(+e("#get-donation-points").text().replace(".", "").replace("£", "") - e(n).parent().parent().find(".donation_value").text().split(",")[0].replace(".", "").replace("£", ""))
                    }
                }) : (e(n).find("input[name='sub']").val("").val("Can't Buy").prop("disabled", !0), t(a))
            }).fail(function (e, t, a) {
                alert(a)
            })), e(".loader").fadeOut("slow")
        }), e(".card-heading").on("click", function () {
            console.log("click");
            if (e(this).parent().find(".card-block").css("display") === "none") {
                e(this).parent().find(".card-block").slideDown("slow");
                console.log("founded");
            } else
                e(this).parent().find(".card-block").slideUp("slow");
        }), e("#ShowLoginForm").on("click", function () {
            e(".all_container").fadeIn("slow", function () {
                e(".login_box").slideDown("slow")
            })
        }), e('[id^="fileInput"').on("change", function () {
            var t = e(this);
            e(this).closest("label").find("span").html(t.val().replace(/\\/g, "/").replace(/.*\//, ""))
        }), e('[id^="get_btn_donation_"]').on("click", function (a) {
            a.preventDefault();
            var o = e(this).closest("tr").attr("id"),
                n = e("#" + o).find('input[name="name"]').val(),
                i = e("#" + o).find('textarea[name="description"]').val(),
                s = e("#" + o).find('input[name="dona"]').val(),
                r = e("#" + o).attr("id").split("get_row_donation_")[1];
            e.post("libs/ajax/functions.php", {
                name: n,
                desc: i,
                dona: s,
                item_id: r,
                OPT: "DonationAdminUpdate"
            }, function (a) {
                if ("ok" === e.trim(a)) {
                    var n = e("#" + o).find("#fileInput")[0].files[0];
                    if (n) {
                        var i = new FormData;
                        i.append("image", e("#" + o).find("#fileInput")[0].files[0]), i.append("OPT", "DonationAdminUpdateImg"), e.ajax({
                            url: "libs/ajax/functions.php",
                            type: "POST",
                            data: i,
                            contentType: !1,
                            cache: !1,
                            processData: !1,
                            success: function (a) {
                                "ok" === e.trim(a) ? (Oboro.alerta("success", "&Eacute;xito", "Item updated succesfully"), window.location.href = "index.php?admin.donationshop") : t(a)
                            }
                        })
                    } else Oboro.alerta("success", "&Eacute;xito", "Item updated succesfully")
                } else t(a)
            })
        }),

        e('.IMGURAPIWIN').on("submit", function (a) {
            a.preventDefault();
            var i = new FormData;
            i.append("img", e("#fileimgInput")[0].files[0]), i.append("OPT", "IMGURAPIWIN");
            e.ajax({
                url: "libs/ajax/functions.php",
                type: "POST",
                data: i,
                contentType: !1,
                cache: !1,
                processData: !1,
                success: function (a) {
                    "ok" === e.trim(a) ? (Oboro.alerta("success", "&Eacute;xito", "Display Img Updated"), window.location.href = "?account.info") : t(a)
                }
            })
        }), e("#on-close-login").on("click", function () {
            e(".login_box").slideUp("slow", function () {
                e(".all_container").fadeOut("slow")
            })
        }); {
        var a = 1;
    }

    e(".forum-delete-post").on("click", function () {
        var blogid = e(this).attr("data-blogid");
        var catid = e(this).attr("data-catid");

        e.confirm({
            title: "Confirma",
            closeIcon: !0,
            closeIconClass: "fa fa-close",
            backgroundDismiss: !0,
            content: "Are you sure to permanent delete this Post?",
            autoClose: "close|10000",
            type: "orange",
            typeAnimated: !0,
            buttons: {
                ok: {
                    btnClass: 'btn-warning',
                    text: '<i class="fa fa-trash" aria-hidden="true"></i> Delete',
                    action: function () {
                        e.post("libs/ajax/functions.php", {
                            bid: blogid,
                            OPT: 'DELETE_POST',
                        }, function (r) {
                            if (e.trim(r) === "ok") {
                                Oboro.alerta("success", "&Eacute;xito", "Post deleted");
                                window.location.href = "?forum.cat-" + catid;
                            } else
                                t(r);
                        });
                    }
                },
                close: function () {}
            }
        })
    });

    e(".forum-lockunlock-post").on("click", function () {
        var blogid = e(this).attr("data-blogid");
        var catid = e(this).attr("data-catid");

        e.post("libs/ajax/functions.php", {
            bid: blogid,
            OPT: 'UN_LOCKPOST',
        }, function (r) {
            if (e.trim(r) === "ok") {
                Oboro.alerta("success", "&Eacute;xito", "Post (Un)Locked");
                window.location.href = "?forum.cat-" + catid;
            } else
                t(r);
        });
    });


    e(".ModifyBlog").on("click", function () {
        var
            catid = e(this).attr("date-catid"),
            catname = e(this).attr("data-catname"),
            catparentid = e(this).attr("data-parentid"),
            catdesc = e(this).attr("data-desc"),
            catlvacc = e(this).attr("data-lvacc"),
            catlvcreate = e(this).attr("data-lvcreate");
        $("input[name='name']").val(catname);
        $("textarea[name='description']").val(catdesc);
        $("input[name='lvtoread']").val(catlvacc);
        $("input[name='lvtowrite']").val(catlvcreate);
        $("input[name='catid']").val(catid);
        $('select[name=forum_categories]').val(catparentid);
    });


    e(".ModifyGroup").on("click", function () {
        $("input[name='name']").val(e(this).attr('data-name'));
        $("input[name='htmls']").val(e(this).attr('data-htmls'));
        $("input[name='htmle']").val(e(this).attr('data-htmle'));
        $("input[name='gid']").val(e(this).attr('data-gid'));
    });


    $('.col-lg-user-info').each(function () {
        var t = $(this),
            dispheight = t.parent().find(".user-text-container").css("height");

        t.css("height", dispheight);
        //alert(dispheight);
    });

    var LoadShoutBox = function () {
        $("[name='shout']").val("");
        e.post("libs/ajax/functions.php", {
            OPT: "AJAXSHOUTBOX"
        }, function (a) {
            e("#oboro_forum_shout_ajax").html(a);
            e(".loader").fadeOut("slow");
        });
    };

    var ShoutBox = setInterval(function () {
        e(".loader").fadeIn("slow");
        e("#oboro_forum_shout_ajax > *").remove();
        LoadShoutBox();
    }, 30000);

    var CKEditor;

    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            CKEditor = editor;
        });

    e(".oboro-post").on("submit", function (ev) {
        ev.preventDefault();

        var txthtml = CKEditor.getData(),
            blog_opt = e(this).attr('data-opt'),
            catid = e(this).attr('data-catid');

        e.post("libs/ajax/functions.php", {
            txthtml: txthtml,
            OPT: blog_opt,
            catid: catid
        }, function (r) {
            if (e.trim(r) !== "ok") {
                e.confirm({
                    title: 'Encountered an error!',
                    closeIcon: true,
                    closeIconClass: 'fa fa-close',
                    backgroundDismiss: true,
                    content: r,
                    autoClose: 'close|5000',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        close: function () {
                            text: 'Ok'
                        }
                    }
                });
            } else {
                Oboro.alerta("success", "&Eacute;xito", "Blog published");
                window.location.href = "?forum.post-" + catid;
            }
        });
    });

    e(".OnQuoted").on("click", function (ev) {
        CKEditor.setData("<blockquote><div class=\"title-quote\"><b>Post by: </b>" + e(this).attr("data-enq-user") + "</div>" + e(this).attr("data-enq") + "</blockquote>");
        Oboro.alerta("info", "Quoting!", "Post Quoted");
    });

    e('.forum-controller').on('submit', function (ev) {
        ev.preventDefault();
        var txthtml = CKEditor.getData(),
            title = e(this).find('input[name="title"]').val(),
            opt = e(this).attr('data-opt'),
            catid = e(this).attr('data-catid');

        e.post("libs/ajax/functions.php", {
            text: txthtml,
            title: title,
            OPT: opt,
            catid: catid
        }, function (r) {
            if (e.trim(r) !== "ok") {
                e.confirm({
                    title: 'Encountered an error!',
                    closeIcon: true,
                    closeIconClass: 'fa fa-close',
                    backgroundDismiss: true,
                    content: r,
                    autoClose: 'close|5000',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        close: function () {
                            text: 'Ok'
                        }
                    }
                });
            } else {
                Oboro.alerta("success", "&Eacute;xito", "Blog published");
                if (opt === "MODIFY_POST")
                    window.location.href = "index.php?forum.post-" + catid;
                else
                    window.location.href = "index.php?forum.cat-" + catid;
            }
        });
    });

    function htmldecode(text) {
        const span = document.createElement('span');

        return text
            .replace(/&[#A-Za-z0-9]+;/gi, (entity, position, text) => {
                span.innerHTML = entity;
                return span.innerText;
            });
    }

    e("#post-modify").on('submit', function (ev) {
        ev.preventDefault(); 
    });
    $(document).on("ready", function (ev) {
        if ($('#post-modify').length <= 0)
            return;
        
        e.post("libs/ajax/functions.php", {
            OPT: "GET_FORUM_POST",
            catid: e(this).find("input[name='catid']").val()
        }, function (r) {
            if (e.trim(r) !== 'error') {
                var arr = e.parseJSON(r);
                e('input[name="title"]').val(arr[0]);
                CKEditor.setData(htmldecode(arr[1]));
            } else
                window.location.href = "?forum.cat";
        });
    });

}(jQuery);
