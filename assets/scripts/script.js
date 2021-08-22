const raw_url = location.protocol + '//' + location.host + location.pathname;
const url = raw_url.substring(0, raw_url.length - +(raw_url.lastIndexOf('/') == raw_url.length - 1));
$(document).on("dblclick", '[data-navigate]', (function (e) {

    var navigate = $(this).data('navigate');
    var val = $(this).text();

    // Last value
    param = url.substr(url.lastIndexOf("/") + 1);

    // Removes "/" if its the last key
    document.location = url+"/"+navigate;
    return
}));
$(document)
    .ready(function () {

        $(document)
            .on('click', '.clickable-row', function () {
                window.location = $(this)
                    .data("href");
            });

        function delay(callback, ms) {
            var timer = 0;
            return function () {
                var context = this,
                    args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        $(document)
            .on('click', '[data-link]', function () {
                window.location = $(this)
                    .data("href");
            });

        $(document)
            .on("dblclick", '[data-action="open"]', (function (e) {


                var type = $(this)
                    .data('type');

                    console.log(type);
                var test = {}

                var action = $(this)
                    .data('action');
                var item = $(this)
                    .data('target');

                if (type == "file") {
                    ext = item.substring(item.lastIndexOf(".") + 1);
                    $.ajax({
                        url : url + "/edit/" + item,
                        success: function (html) {
                            jsPanel.create({
                                headerTitle: item,
                                content: '<textarea id="editor">' + html.output + '</textarea>',
                                callback: function (panel) {
                                    $("i.fas.fa-save", panel)
                                        .on("click", function () {
                                            $.ajax({
                                                    type: 'POST',
                                                    url: url + '/' + item,
                                                    data: { 'test': editor.getValue() },
                                                })
                                                .done(function (data) {
                                                    console.log(data);
                                                });
                                        });

                                },
                            })
                        }
                    });
                    return;
                }

                // Last value
                var param = url.substr(url.lastIndexOf("/") + 1);

                // Redirect
                document.location = url + "/" + item;
                return
            }));

            $(document)
                .on("click", '[data-selectable=true]', (function (e) {
                    $(this).toggleClass("selected");
                }));

    });
