const raw_url = location.protocol + '//' + location.host + location.pathname;
const url = raw_url.substring(0, raw_url.length - +(raw_url.lastIndexOf('/') == raw_url.length - 1));
import extensions from '../json/extensions.json';
var config, editor, ext;

$.ajaxSetup({
    type: 'POST',
});


// remove files
// // Prepare JsPanel
// Object.assign(jsPanel.defaults, {
//     theme: 'bootstrap-dark',
//     border: 'medium',
//     onminimized: function (panel, status) {
//         panel.close(panel.id);
//     },
//     headerToolbar: [
//         '<i class="fas fa-save">Save</i>'
//         , '<span class="fas fa-save">Save & Exit</span>'
//         , '<span class="fas fa-search">Search</span>'
//     , ],
//
//     maximizedMargin: [65, 20, 20, 20],
//     minimizeTo: 'parent',
//     container: 'main',
//     // dragit : true,
//     background: 'red',
//     dragit: {
//         containment: [65, 20, 20]
//     }
// });

var contextMenuObj = {

}

$.contextMenu({
    selector: 'td',
    trigger: 'right',
    events: {
        show: function (options) {
            // Add class to the menu
            this.parent().toggleClass("selected");
        },
    },
    items: {
        rename: {
            name: "Rename",
            icon: "fas fa-pencil-alt",
        },
        edit: {
            name: "Edit",
            icon: "edit",
            visible: function(key, opt){
                // Hide this item if the menu was triggered on a div
                if(opt.$trigger[0].parentNode.attributes[3].nodeValue == 'dir'){
                  console.log("hellow");
                  return false;
                }
                return true;
            }
        },
        copy: {
            name: "Copy",
            icon: "copy"
        },
        delete: {
            name: "Delete",
            icon: "delete"
        },
    },
    callback: function (key, options) {

        // $(".selected")
        //     .removeClass("selected");

        var file = "",
            action = key,
            param = "?",
            item = $(this)
            .text(),
            parent = $(this);
        ext = item.substring(item.lastIndexOf(".") + 1);
        // Requires AJAX
        if (action == "rename") {
            $(this)
                .html(`<input class="form-control" type="text" name="" value="${item}">`);
            $('input')
                .focus()
                .select();
            $(this)
                .on('focusout', function () {
                    var val = $(this)
                        .children(1)
                        .val();
                    $(this)
                        .load(url + '/rename/' + item, {
                            name: val
                        });
                });
            return;
        }
        if (action == "edit") {

            $.ajax({
                url : url + "/" + action + "/" + item,
                success: function (html) {
                    jsPanel.create({
                        content: '<textarea id="editor">' + html.output + '</textarea>',
                        headerControls: {
                            smallify: 'remove'
                        },
                        // contentOverflow: 'hidden scroll',
                        theme: 'bootstrap-dark',
                        border: 'medium',
                        onminimized: function (panel, status) {
                            panel.close(panel.id);
                        },
                        headerToolbar: [
                            '<i class="fas fa-save">Save</i>'
                            , '<span class="fas fa-save">Save & Exit</span>'
                            , '<span class="fas fa-search">Search</span>'
                        , ],
                        callback: function (panel) {
                            // handler for the icons
                            // Save ajax
                            $("i.fas.fa-save", panel)
                                .on("click", function () {
                                    $.ajax({
                                            type: 'POST',
                                            url: url + '/save/' + item,
                                            data: {
                                                'test': editor.getValue()
                                            },
                                        })
                                        .done(function (data) {
                                            console.log(data);
                                        });
                                });
                        },
                        maximizedMargin: [65, 20, 20, 20],
                        headerTitle: item,
                        minimizeTo: 'parent',
                        container: 'main',
                        // dragit : true,
                        background: 'red',
                        dragit: {
                            containment: [65, 20, 20]
                        }
                    })
                }
            });

            return;

        }

        $.each($(".selected"), function (key, value) {
            if (key != 0) param = "&";
            file += param + "items[]=" + $(this).data('target');
        });

        return document.location = url + "/" + action + "/" + file;
    }

});


// assign handler to event
document.addEventListener('jspanelloaded', function (event) {

    editor = CodeMirror.fromTextArea(document.getElementById('editor'), {
        lineNumbers: true,
        lineWrapping: false,
        readOnly: false,
        allowDropFileTypes: true,
        theme: 'liquibyte',
        addModeClass: true,
        viewportMargin: 1,
        autocorrect: true,
        matchBrackets: true,
        mode: extensions[ext],
        indentWithTabs: true,
        height: '2px',
    });

    editor.setSize("100%", "100%");
}, false);
