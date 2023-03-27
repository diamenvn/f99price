
const app = {
    config: {
        routesUsingTheme: ['site.list.index', 'site.list.detail'],
        modalID: '#modal',
        modal: null
    },
    init: function() {
        $(function() {
            app.action.clickDom();
            app.running.setCSRF();
            app.running.loadDefault();
        });
    },
    action: {
        clickDom: function() {
            $(document)
            .on('click', '.call_ajax_modal-js', function(e) {
                self = $(this);
                href = self.attr('data-href') || self.attr('href');
                maxWidth = self.attr('max-width') || '600px';
                e.preventDefault();
                $.ajax({
                    url: href + "?popup=true",
                    type: 'GET',
                    dataType: 'html'
                }).done(function(res, status, xhr) {
                    if (xhr.status == 200) {
                        openModal(res, maxWidth);
                        app.action.activeUpload();
                    }
                }).fail(function(res) {
                    if (res.status == 401) {
                        window.location.href = window.loginURI + "?callback=" + window.location.href;
                    }
                });
            })

            .on('click', '.call_ajax_remove-js', function(e) {
                self = $(this);
                href = self.attr('data-href') || self.attr('href');
                e.preventDefault();

                $.confirm({
                    title: 'Xoá trang này',
                    content: 'Bạn có chắc chắn muốn xoá?',
                    buttons: {
                        confirm: {
                            text: 'Xoá',
                            btnClass: 'btn-red',
                            keys: ['enter'],
                            action: function(){
                                $.ajax({
                                    url: href,
                                    type: 'DELETE',
                                    dataType: 'json'
                                }).done(function(res) {
                                    alert(res.msg);
                                    if (res.success) {
                                        window.location.reload();
                                    }
                                });
                            }
                            
                        },
                        cancel: function () {
                            
                        },
                    }
                });  
            })

            .on('submit', '.form_submit_ajax-js', function(e) {
                e.preventDefault();
                method = $(this).attr('method') || "POST";
                d = $(this).serializeArray();
                href = $(this).attr('action') || "";
                $.ajax({
                    url: href,
                    type: method,
                    data: d,
                    dataType: 'json'
                }).done(function(res) {
                    alert(res.msg);
                    if (res.success) {
                        window.location.reload();
                    }
                });
            })
            .on('click', '.btn-category-add-display-view-js', function() {
                domClone = $(this).attr('data-dom-clone');
                domParent = $(this).attr('data-dom-parent');
                if (domClone && domParent) {
                    $(domParent).append($(domClone).clone().show());
                }
            })
            .on('click', '[event-click-remove-dom]', function() {
                findType = $(this).attr('data-find-type') || "this";
                domRemove = $(this).attr('event-click-remove-dom');
                alert = $(this).attr('data-alert') || false;
                if (alert == "true" && !confirm("Bạn có chắc chắn muốn xoá")) {
                    return;
                }

                if (findType == "this") {
                    $(domRemove).remove();
                }else{
                    $(this).closest(domRemove).remove();
                }
            })
            .on('click', '.submit_form-js', function() {
                form = $(this).attr('data-form') || null;
                if (form) {
                    $(form).submit();
                }
            })
            .on('click', '.app_navigation-js', function() {
                get = localStorage.getItem('sidebar-right-display');

                if (get == "hide") {
                    $('.sidebar--right-js').css('display', 'block');
                    localStorage.setItem("sidebar-right-display", "show");
                }else{
                    animateCSS('.sidebar--right-js', 'zoomOutLeft').then((message) => {
                        $('.sidebar--right-js').hide();
                        localStorage.setItem("sidebar-right-display", "hide");
                    });
                }
            })
            .on('click', '.sidebar__lists-items-js', function() {
                // animateCSS('.main-content', 'fadeOutDown').then((message) => {
                //     // localStorage.setItem("sidebar-right-display", "hide");
                //     $('.main-content').hide();
                // });
            })
            .on('click', '.btn-add-product-js', function() {
                form = $(this).attr('data-form-target');
                stt = $(form).find('tr').length;
                html = `<tr><th scope="row">` + stt + `</th>
                    <td><input class="form-control" name="product[]" type="text" value="" placeholder="Nhập tên sản phẩm..."></td>
                    <td>
                        <div class="btn btn-danger btn-click-remove-product-js">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                            </svg>
                        </div>
                        <div class="btn btn-secondary drag-handler">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-expand" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8zM7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708l2-2zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10z"/>
                            </svg>
                        </div>
                    </td></tr>`;
                $(form).find('tbody').append(html);
            })
            .on('click', '.btn-click-remove-product-js', function() {
                $(this).closest('tr').remove();
            })
            .on('click', '.btn-click-add-page-js', function() {
                alert();
            });
        },
        openModal: function(message = "", confirm = null, cancel = null) {

            app.config.modal = app.running.initModal();

            app.config.modal.setContent(message);

            app.config.modal.addFooterBtn('Huỷ bỏ', 'tingle-btn tingle-btn--default', function() {
                if (!!cancel) {
                    cancel();
                }else{
                    app.config.modal.destroy();
                }
            });

            if (!!confirm) {
                app.config.modal.addFooterBtn('Xác nhận', 'tingle-btn tingle-btn--primary', function() {
                    confirm();
                });
            }

            app.config.modal.open();
        },
        activeUpload: function() {
            $('[type="file"]').filepond({
                labelIdle: 'Kéo thả file hoặc nhấn vào <span class="filepond--label-action"> đây </span>',
            });
            $("[data-type='currency']").simpleMoneyFormat();
        }
    },
    running: {
        setCSRF: function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },
        initModal: function() {
            modal = new tingle.modal({
                footer: true,
                stickyFooter: false,
                closeMethods: ['overlay', 'button', 'escape'],
                closeLabel: "Close",
                cssClass: ['custom-modal'],
                onClose: function() {
                    modal.destroy();
                },
                beforeClose: function() {
                    return true;
                }
            });

            return modal;
        },
        loadDefault: function () {
            $.fn.filepond.setOptions({
                server: {
                    process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        const formData = new FormData();
                        formData.append('file', file, file.name);
            
                        const request = new XMLHttpRequest();
                        request.open('POST', window.uploadURI);
                        request.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute("content"));
                        
                        request.onload = function() {
                            if (request.status >= 200 && request.status < 300) {
                                load(JSON.parse(request.responseText).data);
                            }
                            else {
                                error('Error');
                            }
                        };
            
                        request.send(formData);
                        
                        // Should expose an abort method so the request can be cancelled
                        return {
                            abort: () => {
                                // This function is entered if the user has tapped the cancel button
                                request.abort();
            
                                // Let FilePond know the request has been cancelled
                                abort();
                            }
                        };
                    }
                  }
            });
            $("[data-type='currency']").simpleMoneyFormat();
            get = localStorage.getItem('sidebar-right-display');
            if (get == "hide") {
                $('.sidebar--right-js').hide();
            }
        }
    }
}




openModal = (html = "", size = "600px") => {
    modal = $(app.config.modalID);
    modal.find('.modal-dialog').css('max-width', size);
    modal.find('.modal-body').html(html);
    modal.modal();
}

app.init();