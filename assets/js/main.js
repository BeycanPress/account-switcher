(($) => {

    "use strict";

    $(document).ready(() => {

        function disableScreen() {
            var div = document.createElement("div");
            div.className += "overlay";
            div.style.backgroundColor = "#EFEFEF";
            div.style.position = "fixed";
            div.style.width = "100%";
            div.style.height = "100%";
            div.style.zIndex = "999999999999999";
            div.style.top = "0px";
            div.style.left = "0px";
            div.style.opacity = ".5";
            document.body.appendChild(div);
        }

        function enableScreen() {
            if (document.querySelector(".overlay")) {
                document.querySelector(".overlay").remove();
            }
        }
    
        function swalPopup(message, type, html = null) {
            enableScreen();
            return Swal.fire({
                title: message,
                html,
                icon: type,
                didOpen: () => {
                    Swal.hideLoading();
                }
            });
        }
        function infoPopup(message, html = null) {
            return swalPopup(message, 'info', html);
        }
        
        function errorPopup(message, html = null) {
            return swalPopup(message, 'error', html);
        }
        
        function successPopup(message, html = null) {
            return swalPopup(message, 'success', html);
        }
        
        function waitingPopup(title, html = null) {
            Swal.fire({
                title,
                html,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }
        
        $.fn.serializeObject = function() {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };

        AS.getRedirectTo = () => {
            let dataRedirect = $(".as-modal").attr("data-redirect");
            let redirectTo = (new URLSearchParams(window.location.search)).get('redirect_to');
            return dataRedirect == 'same-page' ? window.location.href : (redirectTo || dataRedirect);
        }

        $(document).on('submit', '#as-login-form', function (e) {
            e.preventDefault();
            let data = $(this).serializeObject();
            let submit = $(this).find('input[type="submit"]');
            data.redirectTo = AS.getRedirectTo();
            $.ajax({
                method: 'POST',
                url: AS.apiUrl + '/login',
                data,
                beforeSend() {
                    submit.val(AS.lang.loggingIn);
                    $("#as-login-form input").prop("disabled", true);
                },
                success(response) {
                    submit.val(AS.lang.login);
                    $("#as-login-form input").prop("disabled", false);
                    if (response.success) {
                        successPopup(response.message).then(() => {
                            disableScreen();
                            if (response.data.redirectTo == window.location.href) {
                                window.location.reload();
                            } else {
                                location.href = response.data.redirectTo;
                            }
                        });
                    } else {
                        if (response.errorCode == 'ERR') {
                            errorPopup(response.message);
                        } else {
                            infoPopup(response.message);
                        }
                    }
                },
                error() {
                    submit.val(AS.lang.login);
                    $("#as-login-form input").prop("disabled", false);
                    errorPopup(AS.lang.somethingWentWrong);
                }
            });
        });

        $(document).on('click', ".as-close", function () {
            $(".as-modal").removeClass("opened");
        });

        $(document).on('click', "a[href='#account-switcher']", function () {
            $(".as-modal").addClass("opened");
            if ($(".as-user-list ul li").length > 0) {
                $(".as-users").addClass("active");
                $(".as-login").removeClass("active");
            }
        });

        $(document).on('click', ".as-login-exist-account", function () {
            $(".as-login").addClass("active");
            $(".as-users").removeClass("active");
        });

        $(document).on('click', ".as-user-list li:not(.current-user)", function () {
            let userId = $(this).attr("data-user-id");
            let secret = $(this).attr("data-user-secret");
            let redirectTo = AS.getRedirectTo();
            $.ajax({
                method: 'POST',
                url: AS.apiUrl + '/rememberLogin',
                data: {
                    userId,
                    secret,
                    redirectTo
                },
                beforeSend() {
                    waitingPopup(AS.lang.loggingIn);
                },
                success(response) {
                    if (response.success) {
                        successPopup(response.message).then(() => {
                            disableScreen();
                            if (response.data.redirectTo == window.location.href) {
                                window.location.reload();
                            } else {
                                location.href = response.data.redirectTo;
                            }
                        });
                    } else {
                        if (response.errorCode == 'ERR') {
                            errorPopup(response.message);
                        } else {
                            infoPopup(response.message);
                        }
                    }
                },
                error() {
                    errorPopup(AS.lang.somethingWentWrong);
                }
            });
        });
    });

})(jQuery);